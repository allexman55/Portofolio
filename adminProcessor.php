<?php

include_once("config.php");

// -------------------------------------INSERT-----------------------------------------


if(isset($_POST["insert"])){
    $fname = strip_tags($_POST["fname"]);
    $lname = strip_tags($_POST["lname"]);
    $uid = strip_tags($_POST["uid"]);
    $mail = strip_tags($_POST["mail"]);
    $pwd = "admin";
    $pwd = hash("sha512", $pwd);
    $ip = $_SERVER["REMOTE_ADDR"];

    if(empty($uid) || empty($mail)){
        header("Location: admin.php?empty=1");
        exit();
    }
    $query = $con->prepare("SELECT mail FROM users WHERE mail = :mail");
    $query->bindParam(":mail", $mail);
    $query->execute();
    if($query->rowCount() > 0){
        header("Location: admin.php?mail=tk");
        exit();
    }else{
        $query = $con->prepare("INSERT INTO users(fname, lname, uid, mail, pwd, profile, ip, date) VALUES(:fname, :lname, :uid, :mail, :pwd, 'profilePic/default.jpg', :ip, NOW())");
        $query->bindParam(":fname", $fname);
        $query->bindParam(":lname", $lname);
        $query->bindParam(":uid", $uid);
        $query->bindParam(":mail", $mail);
        $query->bindParam(":pwd", $pwd);
        $query->bindParam(":ip", $ip);
        $query->execute();
        header("Location: admin.php");
        exit();
        
    }


}
// --------------------------------EDIT------------------------------------------

if(isset($_POST["action"])){
    if($_POST["action"] == "data"){
        $id = $_POST["id"];
        $query = $con->prepare("SELECT * FROM users WHERE id = :id");
        $query->bindParam(":id", $id);
        $query->execute();
        $result = $query->fetchAll();
        foreach($result as $row){
            $output["fname"] = $row["fname"];
            $output["lname"] = $row["lname"];
            $output["uid"] = $row["uid"];
            $output["mail"] = $row["mail"];
        }
        echo json_encode($output);
    }
    
}
if(isset($_POST["save"])){
    $id = $_POST["select"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $uid = $_POST["uid"];
    $mail = $_POST["mail"];

    if(empty($fname) || empty($lname) || empty($uid) || empty($mail)){
        header("Location: admin.php?emptySave=1");
        exit();
    }
    
        $query = $con->prepare("UPDATE users SET fname = :fname, lname = :lname, uid = :uid,mail = :mail WHERE id = :id");
        $query->bindParam(":fname", $fname);
        $query->bindParam(":lname", $lname);
        $query->bindParam(":uid", $uid);
        $query->bindParam(":mail", $mail);
        $query->bindParam(":id", $id);
        $query->execute();
        header("Location: admin.php");
        exit();
}
// -------------------------------DELETE-----------------------------------------

if(isset($_POST["del"])){
    $delId = $_POST["del"];
    $query = $con->prepare("DELETE FROM users WHERE id = :id");
    $query->bindParam(":id", $delId);
    $query->execute();
}

?>