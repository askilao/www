<?php

class User {
    private $uid = -1;
    private $userdata = [];
    private $db;

  public function __construct($db) {
    $this->db = $db;

     if (isset($_POST['username'])) {
      $this->login($_POST['username'], $_POST['password']);

    } else if (isset($_POST['logout'])) {
      unset($_SESSION['uid']);
    } else if (isset($_SESSION['uid'])) {
      $this->uid = $_SESSION['uid'];
    }
  }

  public function loggedIn() {
    return $this->uid>=1;
  }

  public function addUser($userdata) {
    $sql = 'INSERT INTO contacts (username, password';
    $extra = '';

    if (isset($userdata['optional'])) {
        $sql.= ', optional';
        $extra = ', ?';
    }
    $sql .= ") VALUES (?, ?$extra)";
    
    $sth = $this->db->prepare($sql);
    $tmp['sql'] = $sql;
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
  public function login($username, $password){

    $sql = 'SELECT id, username, password, optional FROM contacts WHERE username = ?';
    $sth = $this->db->prepare($sql);
    $sth-> execute (array ($username));
    if ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
      if(password_verify($password, $row['password'])){
        $this->userdata = $row;
        $_SESSION['uid'] = $row['id'];
        $this->uid = $row['id'];
        return array('status'=>'OK');
      } else {
        return array('status'=>'FAIL', 'errmsg' => 'Wrong password');
      }
    } else {
      return array('status'=>'FAIL', 'errmsg' => 'User not found');
    } 
  }

  public function deleteUser($id){
    $sql = 'DELETE FROM contacts WHERE id=?';
    $sth = $this->db->prepare($sql);
    $sth-> execute(array($id));
     if ($sth->rowCount()==1) {
      $tmp['status'] = 'OK';
    } else {
      $tmp['status'] = 'FAIL';
    }
    return $tmp;
  }

}