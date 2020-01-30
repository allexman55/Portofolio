<?php
require 'header.php';
require 'classes/Post.php';

if(!isset($userLoggedIn)){
    header("Location: login.php");
    exit();
}

?>

<h4 class="text-center text-info mt-4">Your favorite ads</h4>

<div id="main" class="d-flex flex-wrap justify-content-center mt-5">
<?php

$query = $con->prepare("SELECT * FROM favorite WHERE uid = :uid");
$query->bindParam(":uid", $userLoggedIn);
$query->execute();
if($query->rowCount() > 0){
    while($row = $query->fetch(PDO::FETCH_ASSOC)){
        $postId = $row["postId"];
        $favPost = new Post($con, $postId);
        ?>
        <a href="ad.php?id=<?php echo $favPost->getId(); ?>" style="text-decoration: none;" class="d-flex flex-column mx-2 text-muted mb-3" id="ad">
                <img src="<?php echo $favPost->getPath(); ?>" style="height:200px;" alt="ad">
                <h5 class="px-1 pt-1 text-light"><?php echo $favPost->getAdName(); ?><span class="text-info" style="font-size:20px;float:right;"><?php echo $favPost->getPrice(); ?>$</span></h5>
                <p class="px-1"><?php echo $favPost->getUid(); ?><span style="float:right;"><?php echo $favPost->getTel(); ?></span></p>
        </a>
        
        <?php
    }

}else{ ?>
    <h4 class="text-center text-info mt-5">You did not saved any ads.</h4>
<?php } ?>
</div>



<?php

require 'footer.php';

?>