<?php
/**
* csv文件读取和导出
*/
class Csv_file{

    private $csv_file = "";
    private $header_data = array();
    private $file_name = "";
    private $data = array();

    public function __construct( $csv_file, $header_data, $file_name,$data){
        $this->csv_file    = $csv_file;
        $this->header_data = $header_data;
        $this->file_name   = $file_name;
        $this->data        = $data;
    }
    /**
     * 读取CSV文件
     * @param string $csv_file csv文件路径
     * @param int $lines       读取行数
     * @param int $offset      起始行数
     * @return array|bool
     */
    public function read_csv_lines($lines = 0, $offset = 0)
    {
        if (!$fp = fopen($this->csv_file, 'r')) {
            return false;
        }
        $i = $j = 0;
        while (false !== ($line = fgets($fp))) {
            if ($i++ < $offset) {
                continue;
            }
            break;
        }
        $data = array();
        while (($j++ < $lines) && !feof($fp)) {
            //var_dump(fgetcsv($fp));
            $data[] = fgetcsv($fp);
        }
        fclose($fp);
        return $data;
    }



    /**
     * 导出CSV文件
     * @param array $data        数据
     * @param array $header_data 首行数据
     * @param string $file_name  文件名称
     * @return string
     */
    public function export_csv_1($data = [], $header_data = [], $file_name = '')
    {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $file_name);
        if (!empty($header_data)) {
            echo iconv('utf-8','gbk//TRANSLIT','"'.implode('","',$header_data).'"'."\n");
        }
        foreach ($data as $key => $value) {
            $output = array();
            $output[] = $value['id'];
            $output[] = $value['name'];
            echo iconv('utf-8','gbk//TRANSLIT','"'.implode('","', $output)."\"\n");
        }
    }



    /**
     * 导出CSV文件
     * @param array $data        数据
     * @param array $header_data 首行数据
     * @param string $file_name  文件名称
     * @return string
     */
    //public function export_csv_2($data = [], $header_data = [], $file_name = '')
    public function export_csv2()
    {
        $file_name   = $this->file_name;
        $header_data = $this->header_data;
        $data        = $this->data;
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$file_name);
        header('Cache-Control: max-age=0');
        // 打开PHP文件句柄，php://output 表示直接输出到浏览器
        $fp = fopen('php://output', 'a');
       // var_dump($fp);
        if (!empty($header_data)) {
            foreach ($header_data as $key => $value) {
                $header_data[$key] = iconv('utf-8', 'GBK', $value);
            }
            // 将数据通过fputcsv写到文件句柄
            fputcsv($fp, $header_data);
        }
        $num = 0;
        //每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
        $limit = 100000;
        //逐行取出数据，不浪费内存
        $count = count($data);
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $num++;
                //刷新一下输出buffer，防止由于数据过多造成问题
                if ($limit == $num) {
                    ob_flush();
                    flush();
                    $num = 0;
                }
                $row = $data[$i];
                foreach ($row as $key => $value) {
                    $row[$key] = iconv('utf-8', 'GBK', $value);
                }
                fputcsv($fp, $row);
            }
        }
        fclose($fp);
    }

    public function __destruct(){

    }

}

/**
 *获取需要导出的数据
 */
function getData(){
    $conn = new mysqli('192.168.203.203:3388','bazi','ARJapEu6cvTKSS5B','bazi_udata');  //八字测试库
    if ($conn->connect_error) {  
        die("连接失败: " . $conn->connect_error);
    }  
    $sql = "SELECT a.rname,a.igender,a.birthsolar,a.birthlunar,a.birthtime,b.catname FROM bazi_udata.udatas_u29 AS a
            LEFT JOIN bazi.categories AS b
            ON a.catid = b.catid
            WHERE a.uid = 10829";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {   
        while($row = $result->fetch_assoc()) {      
            $data[] = $row;
        }
    } 
    $conn->close();
    return $data;
}


//将数据导出成csv文件
$data = getData();
foreach ($data as $key=>$value) {
    if($value['igender'] == 0){
        $data[$key]['igender'] = '男';
    }else{
        $data[$key]['igender'] = '女';
    }

    if(is_null($value['catname'])){
        $data[$key]['catname'] = '未分组';
    }
}

$header_data = array("姓名","性别","阳历生日","阴历生日","出生时辰","分组信息");
$csv = new Csv_file("",$header_data,"testad.csv",$data);
$csv->export_csv2();
//print_r($csv);



/*
//读取csv文件
$file = __DIR__."/test .csv";
//$file = "E:/yii/basic/-/test .csv";
$csv  = new Csv_file($file,"","","");
$data = $csv->read_csv_lines(10,0);
echo "<pre>";
print_r($data);
echo "<pre>";*/







