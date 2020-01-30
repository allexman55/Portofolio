<?php
class Post{
    private $con, $sql;
    public function __construct($con, $id){
        $this->con = $con;

        $query = $this->con->prepare("SELECT * FROM ads WHERE id=:id");
        $query->bindParam(":id", $id);
        $query->execute();

        $this->sql = $query->fetch(PDO::FETCH_ASSOC);
    }
    public function getAdName(){
        return $this->sql["adName"];
    }
    public function getUid(){
        return $this->sql["uid"];
    }
    public function getId(){
        return $this->sql["id"];
    }
    public function getDesc(){
        return $this->sql["description"];
    }
    public function getTel(){
        return $this->sql["tel"];
    }
    public function getPath(){
        return $this->sql["path"];
    }
    public function getPrice(){
        return $this->sql["price"];
    }
    public function getDate(){
        return $this->sql["date"];
    }

}


?>