<?php
function dbConnect($usertype, $connectionType = 'mysqli') {
  //$host = 'rawdesigns.db.7625389.hostedresource.com';
  $host = 'localhost';  
  $db = 'rawdesigns';
  if ($usertype  == 'read') {
	$user = 'rdread01';
	$pwd = 'Password#23';
  } elseif ($usertype == 'write') {
  	$user = 'rawdesigns';
	$pwd = 'Forever#23';
  } else {
	exit('Unrecognized connection type');
  }
  if ($connectionType == 'mysqli') {
	$result = new mysqli($host, $user, $pwd, $db) ;
	if (!$result) die ('Cannot connect to database');
	return $result;
  } else {
    try {
      return new PDO("mysql:host=$host;dbname=$db", $user, $pwd);
    } catch (PDOException $e) {
      echo 'Cannot connect to database';
      exit;
    }
  }
}
