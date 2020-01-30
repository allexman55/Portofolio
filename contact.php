<?php 

$name = strip_tags(ucfirst($_POST["name"]));
$mail = strip_tags($_POST["mail"]);
$msg = strip_tags($_POST["msg"]);
$userEmail = strip_tags($_POST["userEmail"]);

$to = $userEmail;
$sub = "$name - $mail";
$content = $msg;
$headers = 'From: office@raffe.ro' . "\r\n" .
    "Reply-To: $userEmail" . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
mail($to, $sub, $content, $headers);



header("Location: index.php?mailSucc=1");


?>