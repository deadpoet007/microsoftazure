<?php
session_start();
$height=$_POST['scale'];
$file_name=$_SESSION['file'];
$withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file_name);
$_SESSION['load']=$withoutExt.".stl";
$filename="jsc3d/demos/uploads/".$file_name;
//echo $file_name;
exec('openscad -o jsc3d/demos/models/"'.$withoutExt.'".stl -D height="'.$height.'" -D filen=\"'.$filename.'\" Untitled.scad');
header('Location: http://localhost/open/jsc3d/demos/test.php');
?>