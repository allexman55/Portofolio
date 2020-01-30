<?php
require 'header.php';
require 'classes/Post.php';

if(!isset($_GET["id"])){
    header("Location: index.php");
    exit();
}

$getId = $_GET["id"];
$post = new Post($con, $getId);

if(isset($userLoggedIn)){
    $query = $con->prepare("SELECT * FROM favorite WHERE postId = :postId AND uid = :uid");
    $query->bindParam(":uid", $userLoggedIn);
    $query->bindParam(":postId", $getId);
    $query->execute();
    // $row = $query->fetch(PDO::FETCH_ASSOC);
    if($query->rowCount() > 0){
        $class = "text-danger";
        $text = "Remove from favorite";
    }else{
        $class = "text-dark";
        $text = "Add to favorite";
    }
    // $class = $uid == $userLoggedIn ? "text-danger" : "text-dark";
    // $text = $uid == $userLoggedIn ? "Remove from favorite" : "Add to favorite";
}

?>
 

<!-- <section id="section" class="container-fluid-sm container"> -->
    <div id="adOrder" class="d-flex justify-content-center mt-2">
        <div style="z-index:1;" class="col">
            <img src="<?php echo $post->getPath(); ?>" style="width:100%;" alt="img">
            <h6 id="date" class="float-right text-secondary">Posted on: <?php echo $post->getDate(); ?></h6>
            <h5 class=" p-1">
            <?php if(isset($userLoggedIn)){ ?>
                <input class="form-control" type="checkbox"  name="check" value="<?php echo $getId; ?>" hidden id="check">
                <input type="text" hidden id="uid" value="<?php echo $userLoggedIn; ?>">
                <label for="check" style="cursor:pointer;">
                    <span id="heart" class="fa fa-heart <?php echo $class; ?>"></span><span id="text" class="pl-1 <?php echo $class; ?>"><?php echo $text;?> </span> 
                </label>
            <?php } ?>
            </h5>
        </div>
        <div style="z-index:5;display:block" class="col mt-2">
            <h3><?php echo $post->getAdName(); ?></h3>
            <h4 class="text-info">Price: <?php echo $post->getPrice(); ?>$</h4>
            <h6><?php echo $post->getDesc(); ?></h6>
            <h6>Posted by: <?php echo $post->getUid(); ?></h6>
            <h6>Tel: <?php echo $post->getTel(); ?></h6>
            <?php
            if($post->getUid() == $userLoggedIn){ ?>
                <form action="ajax.php?action=deleteAd" method="POST">
                    <input type="text" hidden name="postId" value="<?php echo $getId; ?>">
                    <button id="deleteAd" class="btn btn-danger">Delete this ad</button>
                </form>
        <?php } ?>
            <hr>
            <form action="contact.php" method="POST">
                <p>Write a message to <?php echo $post->getUid(); ?>:</p>
                <input type="text" name="name" class="form-control" placeholder="Your name">
                <input type="text" name="mail" class="form-control mt-2" placeholder="Your email address">
                <textarea name="msg" name="msg" class="form-control mt-2" placeholder="Your message" rows="3"></textarea>
                <input type="text" name="userEmail" hidden value="<?php echo $user->getMail(); ?>">
                <button class="btn btn-info mt-2">Send</button>
            </form>
        </div>
    </div>
<!-- </section> -->


<?php 
require 'footer.php';
?>