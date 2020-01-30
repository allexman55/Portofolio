<?php
class User{
    private $con, $sql;
    public function __construct($con, $uid){
        $this->con = $con;

        $query = $this->con->prepare("SELECT * FROM users WHERE uid=:uid");
        $query->bindParam(":uid", $uid);
        $query->execute();

        $this->sql = $query->fetch(PDO::FETCH_ASSOC);
    }

    public static function isLoggedIn(){
        return isset($_SESSION["userLoggedIn"]);
    }
    public function getMail(){
        return $this->sql["mail"];
    }
    public function getUid(){
        return $this->sql["uid"];
    }
    public function getId(){
        return $this->sql["id"];
    }
    public function getName(){
        return $this->sql["fname"]." ".$this->sql["lname"];
    }
    public function getProfile(){
        return $this->sql["profile"];
    }

}


?>