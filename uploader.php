<?php
require_once('db_config.php');
<<<<<<< HEAD
define('root_dir', '/var/www/html/upload/');
=======
define('root_dir', '/var/www/html/wp-content/upload/');
>>>>>>> 2fd46f7666bf32defbab2975aac850fa99f54115
define('hd', 'hd');
try{
 $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);
}
catch(PDOException $e){
  die('not created '.$e->getMessage);
}
$inputSize= sizeof($_FILES['files']['name']);
$uploads = array();
for ($i=0; $i<$inputSize; $i++){
  $filename = $_FILES['files']['name'][$i];
  $file= $_FILES['files']['tmp_name'][$i];
  $error =$_FILES['files']['error'][$i];
  $filetype= $_FILES['files']['type'][$i];
  $filesize =$_FILES['files']['size'][$i];
  $filenameQuality=preg_replace('/\./','_', $filename);
  $fileQuality= $_POST[$filenameQuality.'_quality'];
  $fileArr= ["name"=>$filename, "file"=>$file,"quality"=>strtolower($fileQuality), "error"=> $error, "filetype"=>$filetype, "size"=>$filesize];
  array_push( $uploads, $fileArr);
}
$status =upload($uploads, $conn);
echo json_encode($status);

function upload($uploads,$conn){
  $errors = array();
  foreach ($uploads as $upload){
    if( $upload["quality"]==hd){
     $error = hdUpload($upload, $conn);
    }
    else{
       $error=nonHdUpload($upload, $conn);
    }
    array_push($errors, $error);
  }
  return $errors;
}
function hdUpload($upload, $conn){
  $file = $upload["file"];
  $filename=$upload["name"];
  $filetype = $upload['filetype'];
  $filesize=$upload['size'];
  $dir = root_dir.'uploads/HD/'. $filename;
  if($filesize<1 || $filename ==null || $filetype ==null){
    return 'there was an error uploading one of your files, check the files and try again';
  }
  if(move_uploaded_file($file, $dir)){
    $error = SQLinsert($conn, $filename, 1, 0, $filetype);
     return $error ? 'file '.$filename.' uploaded successfully':'file '.$filename.' not uploaded successfully';
  }
  else{
    return 'there was an error uploading one of your files '.$filename.', please try again later or contact the admin';
 }
}
function nonHdUpload($upload, $conn){
  $file = $upload["file"];
  $filename=$upload["name"];
  $filetype = $upload['filetype'];
  $filesize=$upload['size'];
<<<<<<< HEAD
  $dir = root_dir.'uploads/NHD'.'/'. $filename;
=======
  $dir = root_dir.'/uploads/NHD'.'/'. $filename;
>>>>>>> 2fd46f7666bf32defbab2975aac850fa99f54115
   if($filesize<1 || $filename ==null || $filetype ==null){
    return 'their was an error uploading one of your files, check the files and try again';
  }
  if(move_uploaded_file($file, $dir)){
    $error = SQLinsert($conn, $filename, 0, 1, $filetype);
     return $error ? 'file '.$filename.' uploaded successfully':'file '.$filename.' not uploaded successfully';
  }
  else{
    return 'their was an error uploading one of your files, '.$filename.' please try again later or contact the admin';
 }
}
function SQLinsert ($conn, $Name, $HD, $nHD, $ext) {
  $sql ='INSERT INTO VIDEOS (Name, HD, nHD, ext) VALUES("'.$Name.'","'.$HD.'","'.$nHD.'","'.$ext.'")';
  $insert = $conn->exec($sql);
  if($insert>0){
    return true;
  }
  return false;
}

?>
