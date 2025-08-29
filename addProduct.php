<?php
//includerar config.php där datainformationen finns
//kan ej koppla till databas utan denna
include "includes/config.php";
include "includes/fileUpload.php";
//isset kollar ifall submit knappen blivigt tryckt
if (isset($_POST['submitItem'])){
	// binder variabler som matats in i formuläret
$item = $_POST['item'];
$amount = $_POST['amount'];
$catagory = $_POST['catagory'];
$img = $_FILES['image']['name'];
//skapar query för att lägga till indo i databasen
//prepared statements med placeholders
$addArticle = $pdo->prepare('INSERT INTO inventory
 (item , amount , catagory , img )
 VALUES (:item, :amount , :catagory, :img)');
 //binder värdena till placeholders
 $addArticle ->bindParam(":item" , $item, pdo::PARAM_STR);
 $addArticle ->bindParam(":amount" , $amount, pdo::PARAM_STR);
 $addArticle ->bindParam(":catagory" , $catagory, pdo::PARAM_STR);
 $addArticle ->bindParam(":img" , $img, pdo::PARAM_STR);
 //kör query
 $addArticle ->execute();
}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="bootstrap-5.3.7/dist/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/script.js" defer></script>
    <script src="bootstrap-5.3.7/dist/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
<body>
    <p>clubbis ska kunna lägga till produkter här och endast klubbis ska komma åt detta</p>
    <button class="indexButton" href='index.html'> Hem</button>

    <div class="wrapper center">
  <form method="post" action=""  enctype="multipart/form-data">
    Item:<br>
    <input type="text" name="item" required><br>
    Amount:<br>
    <input type="text" name="amount" required><br>
    Catagory:<br>
    <input type="text" name="catagory" required><br>
    Picture:<br>
    <input type="file" name="image" id="image"><br>

    <input type="submit" name="submitItem" value="Add item"><br><br>

  </form>


</body>
</html>