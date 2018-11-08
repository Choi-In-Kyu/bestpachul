<?php
//Script Functions
function alert($str){echo "<script>alert('{$str}');</script>";}
function getLog($str){echo "<script>console.log('{$str}');</script>";}
function move($str = false){echo "<script>";echo $str ? "document.location.replace('{$str}');" : "history.back();";echo "</script>";exit;}

//Class Auto Load
function __autoload($className){
  $className = strtolower($className);
  $className2 = preg_replace('/(model|application)(.*)/',"$1",$className);
  switch($className2){
    case 'application'  : $dir = _APP; break;
    case 'model'        : $dir = _MODEL; break;
    default             : $dir = _CONTROLLER; break;
  }
  require_once("{$dir}{$className}.php");
}

$today = date("Y-m-d");
$tomorrow = date("Y-m-d", strtotime('+1 day'));
