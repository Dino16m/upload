<!DOCTYPE html>
<html>
<head>
    <title>
    Barebones uploader        
    </title>
</head>
<body>
<form enctype="multipart/form-data" method="POST" action='<?php $_PHP_SELF?>' >
    
    <input type="file" name="video"><br>
            <input type="submit"><br>
</form>
</body>
</html>


<?php 

define( 'root_dir', 'uploads/');
if($_FILES['video']!=null){
    $video = $_FILES['video']['tmp_name'];
    $name = $_FILES['video']['name'];
}
else
{
    die( "there either wasn't any file uploaded or something went really wrong");
}
$dir = root_dir.$name;
$uploadStatus = move_uploaded_file($video, $dir);
echo $uploadStatus ? $name.' was uploaded': $name. ' wan not uploaded'; 
?>