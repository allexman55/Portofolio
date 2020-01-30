<?php

require 'config.php';

if(isset($_POST["val"])){
    $val = $_POST["val"];
    $postId = $_POST["check"];
    $uid = $_POST["uid"];
    if($val == "add"){
        $query = $con->prepare("INSERT INTO favorite(uid, postId) VALUES(:uid, :postId)");
        $query->bindParam(":uid", $uid);
        $query->bindParam(":postId", $postId);
        $query->execute();
        header("Location: ad.php?$postId");
        exit();

    }elseif($val == "remove"){
        $query = $con->prepare("DELETE FROM favorite WHERE postId = :postId AND uid = :uid");
        $query->bindParam(":postId", $postId);
        $query->bindParam(":uid", $uid);
        $query->execute();
        header("Location: ad.php?$postId");
        exit();
    }
}
if(isset($_GET["action"])){
    if($_GET["action"] == "deleteAd"){
        $postId = $_POST["postId"];
        $query = $con->prepare("DELETE FROM ads WHERE id = :id");
        $query->bindParam(":id", $postId);
        $query->execute();
        header("Location: index.php");
        exit();
    }
}



?>