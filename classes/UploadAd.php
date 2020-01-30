<?php

class Ad{
    private $con, $sql;
    private $err = array();

    public function __construct($con, $uid){
        $this->con = $con;

        $query = $this->con->prepare("SELECT * FROM ads WHERE uid=:uid");
        $query->bindParam(":uid", $uid);
        $query->execute();

        $this->sql = $query->fetch(PDO::FETCH_ASSOC);
    }

    public function upload($uid, $name, $desc, $tel, $price, $file_name, $file_size, $file_tmp, $file_type, $file_ext){
        $this->validateName($name);
        $this->validateFile($file_name, $file_size, $file_tmp, $file_type, $file_ext);


        if(empty($this->err)){
            $path = "img/$name.$file_ext";
            return $this->insertPost($uid, $name, $desc, $tel, $price, $path, $file_tmp);
        }else{
            return false;
        }
    }

    private function insertPost($uid, $name, $desc, $tel, $price, $path, $file_tmp){
        move_uploaded_file($file_tmp, $path);
        $query = $this->con->prepare("INSERT INTO ads (uid, adName, description, tel, price, path, date) VALUES (:uid, :postName, :description, :tel, :price, :path, NOW())");
        
        $query->bindParam(":postName", ucfirst($name));
        $query->bindParam(":uid", $uid);
        $query->bindParam(":description", ucfirst($desc));
        $query->bindParam(":tel", $tel);
        $query->bindParam(":price", $price);
        $query->bindParam(":path", $path);
        
        return $query->execute();
    }

    private function validateName($name){
        if(empty($name) || empty($name)){
            array_push($this->err, Errors::$emptyName);
            return;
        }
        if(strlen($name) < 3 || strlen($name) > 20){
            array_push($this->err, Errors::$nameLenght);
            return;
        }
    }

    private function validateFile($file_name, $file_size, $file_tmp, $file_type, $file_ext){
        
        $extensions= array("jpeg","jpg","png");

        if(in_array($file_ext,$extensions) === false){
            array_push($this->err, Errors::$uploadAd);
            return;
            
        }
        if($file_size > 50097152) {
            array_push($this->err, Errors::$uploadAd);
            return;
            
        }
        
    }



    public function getError($error){
        if(in_array($error, $this->err)){
            return "<span class='text-danger'>$error</span><br>";
        }
    }

}


?>