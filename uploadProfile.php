<?php

require 'config.php';

$id = $_GET["id"];
$pic = $_FILES["pic"];

$query = $con->prepare("SELECT * FROM users WHERE id = :id");
$query->bindParam(":id", $id);
$query->execute();
$row = $query->fetch(PDO::FETCH_ASSOC);
$name = $row["uid"];

    $errors= array();
    $file_name = $_FILES['pic']['name'];
    $file_size = $_FILES['pic']['size'];
    $file_tmp = $_FILES['pic']['tmp_name'];
    $file_type = $_FILES['pic']['type'];
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
      
    $extensions= array("jpeg","jpg","png");
      
    if(in_array($file_ext,$extensions) === false){
        $errors[]="Extension not allowed, please choose a JPEG or PNG file.";
        header("Location: index.php?id=$id&err=ext");
        exit();
    }
    if($file_size > 50097152) {
        $errors[]='File size must be excately less then 50 MB';
        header("Location: index.php?id=$id&err=size");
        exit();
    }
    
    $fileName = "profilePic/".$name.".".$file_ext;
    if(file_exists($file_name)) {
        unlink($fileName);
    }

    if(empty($errors)==true) {
        move_uploaded_file($file_tmp,"profilePic/".$name.".".$file_ext);
        $query = $con->prepare("UPDATE users SET profile = :profile WHERE id = :id");
        $query->bindParam(":profile", $fileName);
        $query->bindParam(":id", $id);
        $query->execute();
        header("Location: index.php?id=$id");
        exit();
        return "Success";
    }
?>