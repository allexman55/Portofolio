<?php
require_once 'config.php';
require 'classes/User.php';

if(isset($_SESSION["userLoggedIn"])){        
    $userLoggedIn = $_SESSION["userLoggedIn"];
    $user = new User($con, $userLoggedIn);
    $id = $user->getId();
    $name = $user->getName();;
    $uid = $user->getUid();; 
    $mail = $user->getMail();;
    $profile = $user->getProfile();;
}


?>
<!doctype html>
<html lang="en">
  <head>
    <title>Anunt</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Prompt|Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
      
  <!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<body>

<nav class="sticky-top" style="width:100%;">
    <div class="container-fluid-md">
        <div class="d-flex bg-light">
            <a href="index.php" class="flex-grow-1" style="text-decoration: none;"><h3 class="text-info p-3 pl-5">CarAds</h5></a>
            <?php
            if(!isset($userLoggedIn)){ ?>
                <a href="login.php" style="text-decoration: none;" class="text-dark float-right p-4">Login</a>
                <a href="login.php" style="text-decoration: none;" class="text-dark float-right p-4">Register</a>
                <a href="anunt.php" style="text-decoration: none;" class="text-dark float-right p-3"><button class="btn btn-outline-info">Add an ad</button></a> 
        <?php  }elseif($userLoggedIn == "admin"){ ?>
                <a href="admin.php" style="text-decoration: none;" class="text-dark float-right p-4">Admin</a>
                <a href="logout.php" style="text-decoration: none;" class="text-dark float-right p-3"><button class="btn btn-outline-info">Logout</button></a> 
        <?php }else{
            ?>
            
            <div class="text-dark p-0 pt-3"  style="cursor:pointer;"  data-toggle="modal" data-target="#changeProfile">
                <img src="<?php echo $profile; ?>" style="width:40px;height:40px;border-radius:50%;" class="" alt="profile">
                <?php echo $name; ?>
        </div>
            <a href="myAds.php" style="text-decoration: none;" class="text-dark float-right p-4">My Ads</a>
            <a href="favorite.php" style="text-decoration: none;" class="text-dark float-right p-4">Favorite</a>
            <a href="add.php" style="text-decoration: none;" class="text-dark float-right py-4">Add an ad</a>
            <a href="logout.php" style="text-decoration: none;" class="text-dark float-right p-3"><button class="btn btn-outline-info">Logout</button></a> 
     
            
            
            <?php
        }
            ?>
            
        </div>
    </div>
</nav>

<div id="nav" style="z-index:10;">
    <div class="fa fa-bars"></div>
</div>
<div id="nav-body" class="d-flex flex-column">
    <div class="upper-menu bg-dark w-100 d-flex flex-column">
        <div id="close-nav" class="m-2 ml-auto">+</div>
        
        <button type="button" class="btn text-dark p-0"  data-toggle="modal" data-target="#changeProfile">
            <img src="<?php echo $src = isset($userLoggedIn) ? $profile : "profilePic/default.jpg"; ?>" style="width:50%!important;border-radius:50%!important;" class="rounded mx-auto d-block" alt="default">
        </button>
        <?php
        if(isset($userLoggedIn)){?>
            <p style="font-size:1.3em;" class="text-info text-center p-4"><?php echo $name; ?></p>
            <?php }else{ ?>
        <a href="login.php" style="text-decoration: none;font-size:1.3em;" class="text-info text-center p-4">Login</a>
            <?php } ?>
    </div>
    <div class="lower-menu">
        <a href="index.php" style="text-decoration: none;font-size:1.3em;" class="text-info text-center"><p class="mt-4">Home</p></a>
        <?php if($userLoggedIn !== "admin"){ ?>
        <a href="myAds.php" style="text-decoration: none;font-size:1.3em;" class="text-dark text-center"><p>My Ads</p></a>
        <a href="favorite.php" style="text-decoration: none;font-size:1.3em;" class="text-dark text-center"><p>Favorite</p></a>
        <a href="add.php" style="text-decoration: none;font-size:1.3em;" class="text-dark text-center"><p>Add an ad</p></a>
        <?php
        }else{ ?>
            <a href="admin.php" style="text-decoration: none;font-size:1.3em;" class="text-dark text-center"><p>Admin</p></a>
        <?php }
         if(isset($userLoggedIn)){ ?>
            <a href="logout.php" style="text-decoration: none;font-size:1.3em;" class="text-danger text-center"><p>Logout</p></a>
            <?php } ?>
    </div>
</div>


<?php    
        if(isset($_GET["err"])){
        ?>
        <div style="position:absolute;top:30%;left:50%;z-index:10;transform:translateX(-50%);" class="alert alert-danger alert-dismissible fade show" role="alert">
            Error: something went wrong changing profile picture. Please try again!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
            </button>
        </div>
<?php } ?>


<div class="modal fade" id="changeProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Profile Picture</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="uploadProfile.php?id=<?php echo $id; ?>" enctype="multipart/form-data" method="POST">
                <div class="modal-body">   
                    <div class="mx-auto" style="width:200px">
                        <h5 class="mt-1">Preview</h5>
                        <img src="<?php echo $profile; ?>" alt="Preview" id="imagePreview" style="width:200px;height:200px;border-radius:50%;">
                    
                        <h5 class="mt-1">Select pricture</h5>
                        <input type="file" id="profilePic" onchange="imgPreview(event)" hidden name="pic">
                        <label for="profilePic"><h4 style="cursor:pointer;" class="btn btn-info">Browse profile image</h4></label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="<?php echo $id; ?>"  class="change btn btn-info">Change</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <script>
    var reader = new FileReader();
function imgPreview(event){ 
   var image = document.getElementById('imagePreview');
   reader.onload = function(){
       if(reader.readyState == 2){
           image.src = reader.result;
       }
   }
   reader.readAsDataURL(event.target.files[0]);
}
    </script>