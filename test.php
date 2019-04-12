<?php

/*class BinTree{

        public $data;

        public $left;

        public $right;

}

//前序遍历生成二叉树

function createBinTree(){

        $handle=fopen("php://stdin","r");

        $e=trim(fgets($handle));
       
        if($e=="#"){

                $binTree=null;

        }else{

                $binTree=new BinTree();

                $binTree->data=$e;

                $binTree->left=createBinTree();

                $binTree->right=createBinTree();

        } 

        return $binTree;

}  

   

$tree=createBinTree();

   

var_dump($tree);

#

object(BinTree)#1 (3) {

  ["data"]=>

  string(1) "A"

  ["left"]=>

  object(BinTree)#2 (3) {

    ["data"]=>

    string(1) "B"

    ["left"]=>

    NULL

    ["right"]=>

    object(BinTree)#3 (3) {

      ["data"]=>

      string(1) "D"

      ["left"]=>

      NULL

      ["right"]=>

      NULL

    }

  }

  ["right"]=>

  object(BinTree)#4 (3) {

    ["data"]=>

    string(1) "C"

    ["left"]=>

    NULL

    ["right"]=>

    NULL

  }

}*/

exec('chcp 936');
echo php_sapi_name();
$fh = fopen('php://stdin', 'r');
echo "[php://stdin]请输入任意字符:";
$str = fread($fh, 1000);
echo "[php://stdin]您输入的是:".$str;
fclose($fh);
echo "[STDIN]请输入任意字符:";
$str = fread(STDIN, 1000);
echo "[STDIN]您输入的是:".$str;



/*$str = "Shanghai";
echo sha1($str);

if (sha1($str) == "b99463d58a5c8372e6adbdca867428961641cb51")
  {
  echo "<br>I love Shanghai!";
  exit;
  }
?>*/