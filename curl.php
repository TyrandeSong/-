<?php 
function getForm($url){
       //$agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";
       $ch=curl_init();
       curl_setopt ($ch, CURLOPT_URL,$url );
       //curl_setopt($ch, CURLOPT_USERAGENT, $agent);
       curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt ($ch,CURLOPT_VERBOSE,false);
       curl_setopt($ch, CURLOPT_TIMEOUT, 5);
       curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, FALSE);
       curl_setopt($ch,CURLOPT_SSLVERSION,3);
       curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, FALSE);
       $page=curl_exec($ch);
       //echo curl_error($ch);
       $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
       curl_close($ch);
       var_dump($httpcode);
       return $page;
       
}


function postForm($url ,$post_data){
      //初始化
    $curl = curl_init();
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $url);
    //设置头文件的信息作为数据流输出
    curl_setopt($curl, CURLOPT_HEADER, 1);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //设置post方式提交
    curl_setopt($curl, CURLOPT_POST, 1);
    //设置post数据
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
    //执行命令
    $data = curl_exec($curl);
    //关闭URL请求
    curl_close($curl);
    //显示获得的数据
    return $data; 
}

$get_url   ="http://app.oa.com/bazi/api/gateway.php?act=getNames&channel=6&channel_key=C89730651C8FF3DFD45D6A30B82FDFEB&deviceid=133524011255618&machine=win32&mkey=10829-ba16de9769dfcf3f5eb440350ffdaec2&mod=iudatas&os=1&uids=10828%2C10831%2C10827%2C10009%2C10823&ver=v2.3&sig=2604bf2df22edc9b0cb81070246d66f6";

//echo getForm($get_url);

/*$post_url  = "http://app.oa.com/bazi/api/gateway.php";
$post_data = array(
       "channel_key" => "C89730651C8FF3DFD45D6A30B82FDFEB",
       "channel" => "6",
       "deviceid" => "133524011255618",
       "machine" => "win32",
       "os"=>1,
       "ver" => "v2.3",
       "mod" => "iudatas",
       "act" => "dynamicAdd",
       "mkey" => "10829-ba16de9769dfcf3f5eb440350ffdaec2",
       "sig" => "2604bf2df22edc9b0cb81070246d66f6"
       );
*/
$post_url = "http://app.oa.com/bazi/test.php";
$post_data = array(
			"user_id    "=>2934,
            "user_name  "=>"ViterGao",
            "priv_admin "=> 1,
            "priv_role_node "=> 1,
            "priv_depart_node"=>1,
            "priv_form "=> 1,
            "priv_flow "=> 1,
            "priv_flow_ins"=>1,
            "readable "=> 1,
            "writeable "=> 1,
            "enable"=>1,
            "tips  "=> "123"

);
var_dump(postForm($post_url, $post_data));

/*//拆分url
$url = parse_url($get_url);

print_r($url);
//将请求参数拆分成数组形式
parse_str($url['query'],$output);

print_r($output);*/