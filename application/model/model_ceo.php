<?php
  
  //test(json_encode($_COOKIE));
  class Model_ceo extends Model
  {
    var $userID;
    var $companyID;

    function __construct($param)
    {
      parent::__construct($param);
    }
    
    function ifValue($post,$glue){
      foreach ($post as $value){
        $newPost[] = $glue.$value.$glue;
      }
      return $newPost;
    }
    
    function arrayToString($post){
      array_shift($post);
      $string = implode(',',$post);
      return $string;
    }
    
    function action()
    {
      if (isset($_COOKIE['userID'])) {
        $this->userID = $_COOKIE['userID'];
      } else {
        move("login");
      }
      
      switch ($_POST['action']) {
        case 'call':
          $_POST['companyID'] = $this->getTable("SELECT * FROM user WHERE `userID`= '{$this->userID}' LIMIT 1")[0]['companyID'];
          $columns = $this->arrayToString($this->ifValue(array_keys($_POST),"`"));
          $values = $this->arrayToString($this->ifValue($_POST,"'"));
          $this->executeSQL("INSERT INTO `call` ({$columns}) VALUES ($values)");
          break;
        case 'delete':
          break;
      }
      unset($_POST);
      move('ceo');
    }
  }