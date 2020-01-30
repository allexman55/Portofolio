<?php
require 'header.php';

?>

<h4 class="text-center text-info my-4">Your ads</h4>


<div id="main" class="d-flex flex-wrap justify-content-center">
<?php
        $query = $con->prepare("SELECT * FROM ads WHERE uid = :uid");
        $query->bindParam(":uid", $userLoggedIn);
        $query->execute();
        if($query->rowCount() > 0){
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $id = $row["id"];
                $user = $row["uid"];
                $title = $row["adName"];
                $tel = $row["tel"];
                $price = $row["price"];
                $path = $row["path"]; ?>

            <a href="ad.php?id=<?php echo $id; ?>" style="text-decoration: none;" class="d-flex flex-column mx-2 text-muted mb-3" id="ad">
                <img src="<?php echo $path; ?>" class="img-fluid" style="height:190px;" alt="ad">
                <h6 class="px-1 pt-1 text-light"><?php echo $title; ?><span class="text-info" style="font-size:15px;float:right;"><?php echo $price; ?>$</span></h6>
                <p class="px-1"><?php echo $user; ?><span style="float:right;"><?php echo $tel; ?></span></p>

            </a>

    <?php }
    }else{
        echo "<p class='text-info text-center'>We couldn't find any ad with this name.</p>";
    } ?>
</div>

<?php
require 'footer.php';
?>