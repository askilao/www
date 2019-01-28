<?php

class User {
    private $uid = -1;
    private $userdata = [];
    private $db;

  public function __construct($db) {
    $this->db = $db;

    if (isset($_POST['login'])) {
      $this->uid = 1;
      $_SESSION['uid'] = 1;
    } else if (isset($_POST['logout'])) {
      unset($_SESSION['uid']);
    } else if (isset($_SESSION['uid'])) {
      $this->uid = 1;
    }
  }

  public function loggedIn() {
    return $this->uid==1;
  }

  public function addUser($userdata) {
    $sql = 'INSERT INTO contact_registry (username, password';
    $extra = '';

    if (isset($userdata['optional'])) {
        $sql.= ', optional';
        $extra = ',? ';
    }
    $sql .= ") VALUES (?, ?$extra)";
    
    $sth = $this->db->prepare($sql);

    $sqldata = array ($userdata['username'], password_hash($userdata['password'], PASSWORD_DEFAULT));
    if(isset($userdata['optional'])) {
        array_push ($sqldata, $userdata['optional']);
    }
    $sth->execute ($sqldata);
    if ($sth->rowCount()==1) {
      $tmp['status'] = 'OK';
      $tmp['id'] = $this->db->lastInsertId();
    } else {
      $tmp['status'] = 'FAIL';
      $tmp['errorMessage'] = 'Username already taken';
    }
    if ($this->db->errorInfo()[1]!=0) { // Error in SQL??????
      $tmp['errorMessage'] = $this->db->errorInfo()[2];
    }
    return $tmp; 
  }
}
