<?php
class Account{
    private $con;
    private $errorArray = array();

    public function __construct($con){
        $this->con = $con;
    }
    public function login($uid, $pwd){
        $pwd = hash("sha512", $pwd);
        $query = $this->con->prepare("SELECT * FROM users WHERE uid = :uid AND pwd = :pwd");
        $query->bindParam(":uid", $uid);
        $query->bindParam(":pwd", $pwd);
        $query->execute();

        if($query->rowCount() == 1){
            return true;
        }else{
            array_push($this->errorArray, Errors::$login);
            return false;
        }
    }
    public function register($fname, $lname, $uid, $mail, $pwd, $pwd2){
        $this->validateName($fname, $lname);
        $this->validateUid($uid);
        $this->validateMail($mail);
        $this->validatePwd($pwd, $pwd2);

        if(empty($this->errorArray)){
            return $this->insertUser($fname, $lname, $uid, $mail, $pwd);
        }else{
            return false;
        }
    }
    public function insertUser($fname, $lname, $uid, $mail, $pwd){
        $pwd = hash("sha512", $pwd);
        $fname = ucfirst($fname);
        $lname = ucfirst($lname);
        $ip = $_SERVER["REMOTE_ADDR"];
        
        $query = $this->con->prepare("INSERT INTO users (fname, lname, uid, mail, pwd, profile, ip, date) 
                                    VALUES (:fname, :lname, :uid, :mail, :pwd, 'profilePic/default.jpg', :ip, NOW())");
        
        $query->bindParam(":fname", $fname);
        $query->bindParam(":lname", $lname);
        $query->bindParam(":uid", $uid);
        $query->bindParam(":mail", $mail);
        $query->bindParam(":pwd", $pwd);
        $query->bindParam(":ip", $ip);
        
        return $query->execute();
    }
    private function validateName($fname, $lname){
        if(empty($fname) || empty($lname)){
            array_push($this->errorArray, Errors::$emptyName);
            return;
        }
    }
    private function validateUid($uid){
        if(strlen($uid) < 5 || strlen($uid) > 25){
            array_push($this->errorArray, Errors::$uidLenght);
            return;
        }
        
        $query = $this->con->prepare("SELECT * FROM users WHERE uid = :uid");
        $query->bindParam(":uid", $uid);
        $query->execute();
        
        if($query->rowCount() != 0){
            array_push($this->errorArray, Errors::$uidTaken);
        }
    }

    private function validateMail($mail){
        if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
            array_push($this->errorArray, Errors::$invalidMail);
            return;
        }

        $query = $this->con->prepare("SELECT mail FROM users WHERE mail = :mail");
        $query->bindParam(":mail", $mail);
        $query->execute();
        
        if($query->rowCount() != 0){
            array_push($this->errorArray, Errors::$mailTaken);
        }
    }
    private function validatePwd($pwd, $pwd2){
        if(strlen($pwd) < 5 || strlen($pwd) > 30){
            array_push($this->errorArray, Errors::$pwdLenght);
            return;
        }

        if(preg_match("/[^A-Za-z0-9]/", $pwd)){
            array_push($this->errorArray, Errors::$pwdChr);
            return;
        }
        if($pwd != $pwd2){
            array_push($this->errorArray, Errors::$pwdMatch);
            return;
        }
    }
   
   
    public function getError($error){
        if(in_array($error, $this->errorArray)){
            return "<span class='text-danger'>$error</span><br>";
        }
    }
}



?>