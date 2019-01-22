<?php
// Check to see if we need the database (creating user/logging in)
if (isset($_POST['createNewUser'])||isset($_POST['login'])) {

  $dsn = 'mysql:dbname=labuke3;host=10.212.136.233:3306';
  $user = 'root';
  $password = 'fittetryne';

  try {
      $dbh = new PDO($dsn, $user, $password);
  } catch (PDOException $e) {
      // NOTE IKKE BRUK DETTE I PRODUKSJON
      echo 'Connection failed: ' . $e->getMessage();
  }

  if (isset($_POST['createNewUser'])) { // Create new user
    $sql = 'INSERT INTO kontaktinfo (navn) values (?)';
    $sth = $dbh->prepare ($sql);
    // Use password_hash to encrypt password : http://php.net/manual/en/function.password-hash.php
    if ($sth->rowCount()==1) {
      $createUserStatus = 'Ny bruker er opprettet';
    } else {
      $createUserStatus = 'Ny bruker kunne ikke opprettes';
    }
  } else if (isset($_POST['login'])) {  // Log in user
    $sql = 'SELECT password, id FROM user WHERE username=:username';
    $sth = $dbh->prepare ($sql);
    $sth->bindParam(':username', $_POST['username']);
    $sth->execute();
    if ($row = $sth->fetch()) { // get id and hashed password for given user
      // Use password_verify to check given password : http://php.net/manual/en/function.password-verify.php
      if (password_verify($_POST['pwd'], $row['password'])) {
        $loginStatus = "Bruker logget inn med brukerid={$row['id']}";
      } else {
        $loginStatus = 'Feil passord';
      }
    } else {
      $loginStatus = 'Ingen bruker med det brukernavnet';
    }
  }
}

 ?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Bruk av databaser, passord</title>
  <style media="screen">
    label {
      display: inline-block;
      width: 85px;
      float: left;
    }

    input {
      display: inline-block;
      width; 150px;
    }
  </style>
</head>
<body>
  <h1>Registrer ny bruker</h1>
  <?php
    if (isset($createUserStatus)) {
      echo "<h2>$createUserStatus</h2>";
    }
   ?>
  <form action="oppgave6.php" method="post">
    <label for="usernameNew">Brukernavn: </label><input type="text" name="username" id="usernameNew"><br/>
    <label for="pwdNew">Passord: </label><input type="password" name="pwd" id="pwdNew"><br/>
    <input type="submit" name="createNewUser" value="Registrer ny bruker">
  </form>
  <h1>Logg inn</h1>
  <?php
    if (isset($loginStatus)) {
      echo "<h2>$loginStatus</h2>";
    }
   ?>
  <form action="oppgave6.php" method="post">
    <label for="username">Brukernavn: </label><input type="text" name="username" id="username"><br/>
    <label for="pwd">Passord: </label><input type="password" name="pwd" id="pwd"><br/>
    <input type="submit" name="login" value="Logg inn">
  </form>
</body>
</html>
