<?php
//script functions
function alert($str){echo "<script>alert('{$str}');</script>";}
function getLog($str){echo "<script>console.log('{$str}');</script>";}
function test($str){echo "<script>alert('{$str}');</script>";echo "<script>console.log('{$str}');</script>";echo $str;
}
//move
function move($str = false){
  echo "<script>";
  echo $str ? "document.location.replace('{$str}');" : "history.back();";
  echo "</script>";
  exit;
}
//access
function access($bool,$msg,$url = false){
  if(!$bool){
    alert($msg);
    move($url);
  }
}

//클래스 자동로딩 함수
function __autoload($className){
  $className = strtolower($className);
  $className2 = preg_replace('/(model|application)(.*)/',"$1",$className);
  switch($className2){
    case 'application'  : $dir = _APP; break;         //
    case 'model'        : $dir = _MODEL; break;       //
    default             : $dir = _CONTROLLER; break;  //
  }
  require_once("{$dir}{$className}.php");
}