<?php
    require 'config.php';
    require 'classes/Error.php';
    require 'classes/UploadAd.php';

    if(isset($_SESSION["userLoggedIn"])){        
        $userLoggedIn = $_SESSION["userLoggedIn"];
        $ad = new Ad($con, $userLoggedIn);
        if(isset($_POST["upload"])){
            $uid = $userLoggedIn;
            $name = strip_tags($_POST["name"]);
            $desc = strip_tags($_POST["desc"]);
            $tel = strip_tags($_POST["tel"]);
            $price = $_POST["price"];
            $file_name = $_FILES['post']['name'];
            $file_size = $_FILES['post']['size'];
            $file_tmp = $_FILES['post']['tmp_name'];
            $file_type = $_FILES['post']['type'];
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

            $success = $ad->upload($uid, $name, $desc, $tel, $price, $file_name, $file_size, $file_tmp, $file_type, $file_ext);

            if($success){
                header("Location: index.php");
                exit();
            }

        }
    }else{
        header("Location: login.php");
        exit();
    }
    



?>

<!doctype html>
<html lang="en">
  <head>
    <title>Upload</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
  </head>
  <body class="bg-light">

    <section>
    <a href="index.php" class="btn btn-danger text-light mt-3 ml-3"><i class="fas fa-long-arrow-alt-left mr-2"></i>Back</a>
                   
        <div class="container-fluid-sm container">
            <div class="row">
                <div class="col">
                <?php echo $ad->getError(Errors::$nameLenght); ?>
                <?php echo $ad->getError(Errors::$uploadAd); ?>
                    <form action="add.php" enctype="multipart/form-data" method="POST">
                        <h4 class="my-2">Ad title</h4>
                        <input type="text" class="form-control" name="name">
                        <h4 class="my-2">Description</h4>
                        <textarea name="desc" class="form-control" rows="3"></textarea>
                        <h4 class="my-2">Phone number</h4>
                        <input type="tel" class="form-control" name="tel">
                        <h4 id="choose" class="my-2">Choose image
                        <input type="file" class="custom-file-input" onchange="postPreview(event)" hidden id="fileInput" aria-describedby="fileInput" name="post">
                        <label for="fileInput"><h4 style="cursor:pointer;" class="btn btn-info ml-3 mt-2">Browse image</h4></label>
                        </h4>
                        <div class="form-group">
                            <label for="formControlRange">Price: <span id="price"></span> $</label>
                            <input type="range" min="0" max="10000" step="50" name="price" value="50" class="slider" id="formControlRange">
                        </div>
                        <button class="btn btn-block btn-info mt-3" name="upload">UPLOAD AD</button>
                    </form>
                </div>
                <div id="prevCol" class="col pl-5">
                    <h4>Preview</h4>
                    <img src="preview.jpg" alt="preview" id="postPreview" style="width:600px;height:400px;">
                </div>
            </div>
        </div>
    </section>
      


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="jquery-3.4.1.min.js"></script>
    <script src="main.js"></script>

    <script>
        var slider = document.getElementById("formControlRange");
        var output = document.getElementById("price");
        output.innerHTML = slider.value; // Display the default slider value

        // Update the current slider value (each time you drag the slider handle)
        slider.oninput = function() {
        output.innerHTML = this.value;
}
    
    var reader = new FileReader();
    function postPreview(event){ 
       var image = document.getElementById('postPreview');
       reader.onload = function(){
           if(reader.readyState == 2){
               image.src = reader.result;
           }
       }
       reader.readAsDataURL(event.target.files[0]);
   }
    
    </script>
  </body>
</html>