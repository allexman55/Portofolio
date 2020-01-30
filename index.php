<?php
include 'header.php';

?>
<section class="container-fluid-sm container-lg">
    <form class="d-flex flex-row mx-auto py-3" id="search" action="index.php" method="POST">
        <input type="text" name="search" class="form-control" placeholder="Search">
        <button name="searchBtn" class="btn btn-info ml-1">Search</button>
    </form>
    <div class="d-flex flex-row justify-content-center" id="cat">
        <a href="index.php?new=1" class="btn btn-info ml-1" style="text-decoration: none;">New</a>
        <a href="index.php?old=1" class="btn btn-info ml-1" style="text-decoration: none;">Old</a>
        <a href="index.php?che=1" class="btn btn-info ml-1" style="text-decoration: none;">Price <div class="fa fa-caret-up"></div></a>
        <a href="index.php?exp=1" class="btn btn-info ml-1" style="text-decoration: none;">Price <div class="fa fa-caret-down"></div></a>
    </div>
</section>
<hr>


<div id="main" class="d-flex flex-wrap justify-content-center">
<?php
    if(!isset($_POST["searchBtn"])){
        if(isset($_GET["new"])){
            $order = "id DESC";
        }elseif(isset($_GET["old"])){
            $order = "id";
        }elseif(isset($_GET["che"])){
            $order = "price";
        }elseif(isset($_GET["exp"])){
            $order = "price DESC";
        }else{
            $order = "id DESC";
        }
        $query = $con->prepare("SELECT * FROM ads ORDER BY $order");
        $query->execute();
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
        $search = strip_tags($_POST["search"]);
        $query = $con->prepare("SELECT * FROM ads WHERE adName LIKE '%$search%'");
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
                <img src="<?php echo $path; ?>" style="height:200px;" alt="ad">
                <h5 class="px-1 pt-1 text-light"><?php echo $title; ?><span class="text-info" style="font-size:20px;float:right;"><?php echo $price; ?>$</span></h5>
                <p class="px-1"><?php echo $user; ?><span style="float:right;"><?php echo $tel; ?></span></p>

            </a>

    <?php
            }
        }else{
            echo "<p class='text-info text-center'>We couldn't find any ad with this name.</p>";
        }

    }

?>
</div>
<?php
    if(isset($_GET["mailSucc"])){ ?>
        <div class="alert alert-info alert-dismissible fade show" style="position:absolute;top:15%;left:40%;z-index:10;" role="alert">
            Your message was sent.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>        
<?php } ?>

<?php
include 'footer.php';
?>



    
    