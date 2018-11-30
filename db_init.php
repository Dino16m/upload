<?php
require_once('db_config.php');
try{
 $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);
 $sql = "INSERT INTO VIDEOS (id,Name, HD, nHD, ext) VALUES(1,'inie', 'HD', 'nHD', 'ext')";
 $insert = $conn->exec($sql);
 echo 'connected<br>'.$insert;
}
catch (PDOException $e){
  die("couldnt connect to database<br>".$e->getMessage());
}
$createTableQuery = "CREATE TABLE VIDEOS(id INT UNIQUE NOT NULL AUTO_INCREMENT,Name VARCHAR(255) NOT NULL, HD INT(1), nHD INT(1), ext VARCHAR(10), Primary key (id))";
try{
$createTable= $conn->exec($createTableQuery);
}catch (PDOException $e){
  die("couldn't add the table".$e->getMessage());
}
$conn = null;
echo 'database created';

?>
