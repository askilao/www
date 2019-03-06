<?php
class Contacts {
  private $dsn = 'mysql:dbname=labuke3;host=127.0.0.1';
  private $user = 'root';
  private $password = '';
  private $db = null;

  private function checkContact($id) {

    $sql = 'SELECT * FROM kontaktinfo WHERE id = ?';
    $sth = $dbh->prepare ($sql);
    $sth-> execute (array ($id));
    if ($sth->rowCount()>=1) {
      return true;
    } else {
      return false;
  }
}


  public function __construct() {
   try {
        $this->db = new PDO($this->dsn, $this->user, $this->password);
    } catch (PDOException $e) {
        // NOTE IKKE BRUK DETTE I PRODUKSJON
        echo 'Connection failed: ' . $e->getMessage();
    }
  }

  public function __destruct() {
    if ($this->db!=null) {
      unset ($this->db);
    }
  }

   public function addContact($data) {
    $sql = 'INSERT INTO kontaktinfo (id, navn, telefon, epost) values (?, ?, ?, ?)';
    $sth = $this->db->prepare ($sql);
    $sth-> execute (array ($data['id'], $data['name'], $data['telephone'], $data['email']));

    $res = [];
    if ($sth->rowCount()==1) {
    	$res['status'] = "Contact added";

    } else {
    	$res['status'] = "Failed to add contact";
    }
    return $res;
   }
   public function updateContact($data) {
    $sql = 'UPDATE kontaktinfo SET navn = ?, telefon = ?, epost = ? WHERE id = ?';
    $sth = $this->db->prepare ($sql);
    $sth-> execute (array ($data['name'], $data['telephone'], $data['email'], $data['id']));

    $res = [];
    if ($sth->rowCount()==1) {
    	$res['status'] = "Contact updated!";

    } else {
    	$res['status'] = "Failed to update contact";
    }
    return $res;
 }
   public function showContact() {
    	 $sql = 'SELECT * FROM kontaktinfo';
 		 $sth = $this->db->prepare ($sql);
 		 $sth-> execute ();
  		 $result['contacts'] = $sth->fetchAll();
  		 return $result;	
   }
  public function deleteContact($id) {
    	 $sql = 'DELETE FROM kontaktinfo WHERE id = ?';
 		 $sth = $this->db->prepare ($sql);
         $sth-> execute (array ($id));
         echo $id;
 }

     public function searchContact($keyword) {
    	 $sql = 'SELECT * FROM kontaktinfo WHERE navn LIKE ?';
 		 $sth = $this->db->prepare ($sql);
 		 $sth-> execute (array ("%$keyword%"));

  		 $result['contacts'] = $sth->fetchAll();
  		 return $result;	
 }
    public function getContact($id) {
    	 $sql = 'SELECT * FROM kontaktinfo WHERE id = ?';
 		 $sth = $this->db->prepare ($sql);
 		 $sth-> execute (array ($id));

  		 $result['contacts'] = $sth->fetchAll();
  		 return $result;	
 
    }
  }
?>
