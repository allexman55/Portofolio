<?php
require_once("config.php");
require_once("classes/Account.php");
require_once("classes/FormSanitize.php");
require_once("classes/Error.php");

$account = new Account($con);

if(isset($_POST["login"])){
    $uid = FormSanitize::sanitizeText($_POST["log_uid"]);
    $pwd = FormSanitize::sanitizeText($_POST["log_pwd"]);

    $success = $account->login($uid, $pwd);

    if($success){
        $_SESSION["userLoggedIn"] = $uid;
        header("Location: index.php");
    }
}


if(isset($_POST["register"])){
    if(isset($_POST["therms"]) && $_POST["therms"] == "yes"){
        $fname = FormSanitize::sanitizeText($_POST["reg_fname"]);
        $lname = FormSanitize::sanitizeText($_POST["reg_lname"]);
        $uid = FormSanitize::sanitizeText($_POST["reg_uid"]);
        $mail = FormSanitize::sanitizeText($_POST["reg_mail"]);
        $pwd = FormSanitize::sanitizePwd($_POST["reg_pwd"]);
        $pwd2 = FormSanitize::sanitizePwd($_POST["reg_pwd2"]);
        
        $success = $account->register($fname, $lname, $uid, $mail, $pwd, $pwd2);

        if($success){
            $_SESSION["userLoggedIn"] = $uid;
            header("Location: index.php");
        }
        
    }else{
        header("Location: login.php?therms=no");
        exit();
    }
    
}
function getValue($name){
    if(isset($_POST[$name])){
        echo $_POST[$name];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
<style>
.width{
    width:30%
}
@media (max-width: 576px) {
    .width{
        width: 100%;        
    }
}
@media (max-width: 768px) {
    .width{
        width: 80%;        
    }
}
@media (min-width: 768px) {
    .width{
        width: 40%;        
    }
}

</style>
<div class="container-sm">
    
    <form action="login.php" class="mt-5 mx-auto width"  method="POST">
    
    <ul class=" nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Log in</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Register</a>
        </li>
    </ul>
    <hr>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <?php echo $account->getError(Errors::$login); ?>
            <div class="form-group">
                    <label >Username</label>
                    <input type="text" name="log_uid"  value="<?php getValue("log_uid"); ?>" class="form-control" aria-describedby="username">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="log_pwd" class="form-control" id="exampleInputPassword2">
                </div>
                <button type="submit" name="login" class="btn btn-info">Login</button>
            </div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <?php echo $account->getError(Errors::$emptyName); ?>
                <div class="form-group row">
                    <div class="col">
                        <label>Frist Name</label>
                        <input type="text" name="reg_fname" class="form-control" value="<?php getValue("reg_fname"); ?>" aria-describedby="fname">
                    </div>
                    <div class="col">
                        <label>Last Name</label>
                        <input type="text" name="reg_lname" class="form-control" value="<?php getValue("reg_lname"); ?>" aria-describedby="lname">
                    </div>
                </div>
                <?php echo $account->getError(Errors::$uidLenght); ?>
                <?php echo $account->getError(Errors::$uidTaken); ?>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="reg_uid" class="form-control" value="<?php getValue("reg_uid"); ?>" aria-describedby="username">
                </div>
                <?php echo $account->getError(Errors::$invalidMail); ?>
                <?php echo $account->getError(Errors::$mailTaken); ?>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="text" name="reg_mail" class="form-control" value="<?php getValue("reg_mail"); ?>" aria-describedby="emailHelp">
                </div>
                <?php echo $account->getError(Errors::$pwdLenght); ?>
                <?php echo $account->getError(Errors::$pwdChr); ?>
                <?php echo $account->getError(Errors::$pwdMatch); ?>
                <div class="form-group">
                    <label for="InputPassword1">Password</label>
                    <input type="password" name="reg_pwd" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword2">Confirm Password</label>
                    <input type="password" name="reg_pwd2" class="form-control">
                </div>
                <?php if(isset($_GET["therms"])){
                    echo "<span class='text-danger'>You need to accept <strong>Therms and conditions</strong></span><br>";
                } ?>
                <div class="form-group form-check">
                    <input type="checkbox" name="therms" value="yes" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label"  for="exampleCheck1">Accept <a href="#">Therms and conditions</a></label>
                </div>
                <button type="submit" name="register" class="btn btn-info">Register</button>
                </div>
        </div>
    </div>

        
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>