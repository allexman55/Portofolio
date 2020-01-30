<?php

require_once "config.php";
require_once "classes/User.php";

if(!isset($_SESSION["userLoggedIn"])){
    header("Location: logout.php");
    exit();
}


?>
<!doctype html>
<html lang="en">
  <head>
    <title>Admin</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://fonts.googleapis.com/css?family=Prompt|Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
  <body class="bg-light">

<a href="index.php" class="btn btn-danger text-light mt-3 ml-3"><i class="fas fa-long-arrow-alt-left mr-2"></i>Back</a>
    
<section>
    <div class="container-fluid-sm">
        <div class="d-flex flex-column align-items-center">
            <?php
            if(isset($_GET["mail"]) || isset($_GET["empty"])){
                $error = isset($_GET["mail"]) ? "Email is already in use!" : "Input empty!";
                ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong><?php echo $error; ?></strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
            }
            ?>
            <form class="form-inline" action="adminProcessor.php" method="POST">
                <input type="text" name="fname" style="width:150px;" placeholder="Frist Name" class="form-control m-2">
                <input type="text" name="lname" style="width:150px;" placeholder="Last Name" class="form-control m-2">
                <input type="text" name="uid" placeholder="Username" class="form-control m-2">
                <input type="text" name="mail" placeholder="Email Address" class="form-control m-2">
                <button class="btn btn-info m-2" name="insert">Add user</button>
            </form>
            <div class="table-responsive-sm">
            <table class="table table-dark mt-4">
                <thead>
                    <tr>
                    <th scope="col-2">Id#</th>
                    <th scope="col-2">First Name</th>
                    <th scope="col-2">Last Name</th>
                    <th scope="col-2">Username</th>
                    <th scope="col-4">Email address</th>
                    <th scope="col-4">Options</th>
                    </tr>
                </thead>
                <tbody>
        <?php
        $query = $con->prepare("SELECT * FROM users");
        $query->execute();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $id = $row["id"];
            $fname = $row["fname"];
            $lname = $row["lname"];
            $uid = $row["uid"];
            $mail = $row["mail"];
        ?>
            <tr>
                <th scope="row"><?php echo $id; ?></th>
                <td><?php echo $fname; ?></td>
                <td><?php echo $lname; ?></td>
                <td><?php echo $uid; ?></td>
                <td><?php echo $mail; ?></td>
                <td class="d-flex">
                <button class="btn btn-light edit" id="<?php echo $id; ?>">Edit</button>
                    <form action="#" method="POST">
                        <button class="btn btn-danger delete ml-1"  id="<?php echo $id; ?>">Delete</button>
                    </form>
                </td>
            </tr>
            
        <?php
        }
        ?>
        </tbody>
    </table>
    </div>
        </div>
    </div>
</section>
    <div id="dialog" class="bg-light" title="Edit">
        <form  action="adminProcessor.php" method="POST">
            <?php
        if(isset($_GET["emptySave"])){
                ?>
                
                    <strong class="text-danger mx-auto"><?php echo "Input empty!"; ?></strong><br>
                    
                <?php
            }
            ?>
            First Name:
            <input type="text" name="fname" id="fname" class="form-control my-1">
            Last Name:
            <input type="text" name="lname" id="lname" class="form-control mt-1">
            Username:
            <input type="text" name="uid" id="uid" class="form-control my-1">
            Email:
            <input type="text" name="mail" id="mail" class="form-control mt-1">
            <input type="text" class="id" hidden name="select">
            <button class="btn btn-dark mt-2 float-right save" name="save">Save</button>
        </form>
    </div>
<div id="result"></div>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="jquery-3.4.1.min.js"></script>
    <script src="jquery-ui.min.js"></script>
<script>
    $(document).ready(function(){
        
        $( "#dialog" ).dialog({
            autoOpen: false
        });

        $(".delete").click(function(){
            var del = $(this).attr("id");
            $.post("adminProcessor.php", {del: del}).done(function(data){
                $("#result").html(data);
            });
        });

        $(".edit").click(function(){
            $( "#dialog" ).dialog("open");
            var id = $(this).attr("id");
            var action = "data";
            $.ajax({
                url: "adminProcessor.php",
                method: "POST",
                data: {id:id, action:action},
                dataType: "json",
                success:function(data){
                    $("#fname").val(data.fname);
                    $("#lname").val(data.lname);
                    $("#uid").val(data.uid);
                    $("#mail").val(data.mail);
                    $(".id").val(id);
                    $("#dialog").dialog("open");
                }
            });
        });



    });
</script>
</body>
</html>