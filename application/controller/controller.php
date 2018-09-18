<?php

Class Controller {
//변수
  var $param;
  var $db;
  var $title;
  var $setAjax;
//생성자
  function __construct($param){
    header("Content-type:text/html;charset=utf8");
    $this->param = $param;
    $modelName = "Model_{$this->param->page_type}";
    $this->db = new $modelName($this->param);
    $this->setAjax = false;
    //항상 index 함수를 실행
    $this->index();
  }
//index
  function index(){
    //따로 action 파라미터가 없으면 method == basic
    $method = isset($this->param->action) ? $this->param->action : 'basic';
    //basic 메소드를 포함한 메소드 실행
    if(method_exists($this,$method)) $this->$method();
    $this->getTitle();
    $this->header();
    $this->content();
    $this->footer();
  }
//header
  function header(){
    $this->setAjax || require_once(_VIEW."header.php");
  }
//footer
  function footer(){
    $this->setAjax || require_once(_VIEW."footer.php");
  }
//content
  function content(){
    $this_arr = (array)$this;
    extract($this_arr);
    $dir = _VIEW."{$this->param->page_type}/{$this->param->include_file}.php";
    if(file_exists($dir)) require_once($dir);
  }
//getTitle
  function getTitle(){
    $this->title = '으뜸 파출';
  }
}
?>