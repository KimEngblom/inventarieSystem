editcar

<?php
include "includes/config.php";
include "includes/fileUpload.php";
//skapar ny qyery som hämtar all info om bilen


  $RegNr = $_GET['carID'];
  $selectCar = $pdo->prepare('SELECT bilar.RegNr , bilar.marke , bilar.modell , bilar.ar , bilar.medkord , bilar.beskrivning , bilar.vaxellada , bilar.bild , bilar.pris , bilar.forsaljare , bilar.plats , Kunder.kunder_fornamn , Kunder.kunder_efternamn , Kunder.kunder_telefon
  FROM bilar INNER JOIN kunder ON
  bilar.forsaljare=kunder.kunder_ID Where RegNr = :reg');
  $selectCar->bindParam(":reg", $RegNr, PDO::PARAM_STR);
  $selectCar->execute();
  $fetch = $selectCar->fetch();

 ?>

<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>Netti auto lite</title>
	<link rel="stylesheet" type="text/css" href="/upg5-8+/upg10/css/style.css">
  <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>tinymce.init({selector:'textarea'});</script>
</head>
<body>
  <div id='header'>
  <h2> Nettiauto <br /> Lite </h2>
  </div>
<div class='wrapper'>
	<div id="textbox">

<form method="post" action="newcar.php"  enctype="multipart/form-data">
  <input type="hidden" name="carexsists" value="1">
  <input type="hidden" name="oldImg" value="<?php echo $fetch['bild']; ?>">
  <input type="hidden" name="oldReg" value= "<?php echo $fetch['RegNr']; ?>">
  Bilens registrerings nummer:<br>
  <input type="text" value= "<?php echo $fetch['RegNr']; ?>" name="RegNr" ><br>
  Märke:<br>
  <input type="text" value= "<?php echo $fetch['marke'];?>" name="marke" ><br>
  Modell:<br>
  <input type="text" value= "<?php echo $fetch['modell'];?>" name="modell" ><br>
  Medkörd: <br>
  <input type="text" value= "<?php echo $fetch['medkord']; ?>" name="medkord" ><br>
  Års modell: <br>
  <input type="text" value= "<?php echo $fetch['ar']; ?>" name="ar" ><br>
  Beskrivning:<br>
  <textarea   name="beskrivning"> <?php echo $fetch['beskrivning']; ?> </textarea><br>
  Växel låda <br>
  <input type="radio" name="vaxellada" value="1" <?php if($fetch['vaxellada']==1){echo "checked='checked'";} ?> > Manual <br>
  <input type="radio" name="vaxellada" value="0" <?php if($fetch['vaxellada']==0){echo "checked='checked'";} ?> > Automat <br>
  Bild:<br>
  <img class="thumbnail" src="img/<?php echo $fetch['bild']; ?>">
  <input type="file" value= "<?php echo $fetch['bild']; ?>" name="bild" id="image"><br>
  Pris:<br>
  <input type="text" value= "<?php echo $fetch['pris']; ?>" name="pris" ><br>
  Plats:<br>
  <input type="text" value= "<?php echo $fetch['plats']; ?>" name="plats" ><br>

  <input type="submit" name="submit-Car" value="Redigera"><br><br>

	</div>
  <br />
</div>
</body>
</html>


index

<?php
include "includes/config.php";
include "includes/fileUpload.php";
$stmt = $pdo->prepare('SELECT bilar.RegNr , bilar.marke , bilar.modell , bilar.ar , bilar.medkord , bilar.beskrivning , bilar.vaxellada , bilar.bild , bilar.pris , bilar.forsaljare , bilar.plats , Kunder.kunder_fornamn , Kunder.kunder_efternamn , Kunder.kunder_telefon
FROM bilar INNER JOIN kunder ON
bilar.forsaljare=kunder.kunder_ID ORDER BY pris DESC;');
$stmt->execute();

 ?>

<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>Netti auto lite</title>
	<link rel="stylesheet" type="text/css" href="/upg5-8+/upg10/css/style.css">
</head>
<body>
  <div id='header'>
  <h2> Nettiauto <br /> Lite </h2>
  </div>
<div class='wrapper'>
	<div id="textbox">
    <a href="http://localhost/upg5-8+/upg10/newcar.php">Lägg till bil</a>
<br />

		<?php
		 foreach ($stmt as $row)
		{
    echo  "<div class='wrapperbil'>";
    echo  "<div id='bilWrapper'>";

      echo  "<div id='bildImg'>";
       echo "<img src='img/". $row['bild'] . "'\n>";
      echo "</div>";

      echo  "<div class='info'>";
    	 echo "<p class='infoText'>märke: " . $row['marke'] . "<p>";
       echo "<p class='infoText'>Modell: " . $row['modell'] . "<p>";
       echo "<p class='infoText'>Års modell: " . $row['ar'] . "<p>";
       echo "<p class='infoText'>Medkörd: " . $row['medkord'] . "<p>";
       echo "<p class='infoText'> växellåda: " . $row['vaxellada'] . "</p>";
       echo "<p class='infoText'>Pris: " . $row['pris'] . "€<p>";
      echo  "</div>";

      echo "<div class='brodText'>Beskrivning:<br />";
        echo "<p>" . $row['beskrivning'] . "</p>";
      echo "</div>";

      echo "<div id='carspecs'>";
       echo "<p> Registrerings nummer: " . $row['RegNr'] . "</p>";
       echo "<p>Namn: " . $row['kunder_fornamn'] . " " . $row['kunder_efternamn'] . "</p>";
       echo "<p>Telefon nummer: " . $row['kunder_telefon'] . "</p>";
       echo "<p>Plats: " . $row['plats'] . "</p>";
      echo "</div>";
      echo "<button><a href='carInfo.php?carID=". $row['RegNr'] ."'> Mer info </a> </button>";

    echo "</div>";
    echo "</div>";

		} ?>
	</div>
  <br />
</div>
</body>
</html>


new car
<?php
//includerar config.php där datainformationen finns
//kan ej koppla till databas utan denna
include "includes/config.php";
include "includes/fileUpload.php";
//isset kollar ifall submit knappen blivigt tryckt
if (isset($_POST['submit-Car']) && $_FILES['bild']) {
	// binder variabler som matats in i formuläret
$RegNr = $_POST['RegNr'];
$marke = $_POST['marke'];
$modell = $_POST['modell'];
$ar = $_POST['ar'];
$medkord = $_POST['medkord'];
$beskrivning = $_POST['beskrivning'];
$vaxellada = $_POST['vaxellada'];

if ($_FILES['bild']['name'] != "") {
$bild = $_FILES['bild']['name'];
}
else {
$bild = $_POST['oldImg'];
}
$pris = $_POST['pris'];
$plats = $_POST['plats'];

if(isset($_POST['carexsists'])){
  $oldReg = $_POST['oldReg'];
  $UpdateCar = $pdo->prepare('UPDATE bilar
   SET RegNr = :RegNr , marke = :marke , modell = :modell , ar = :ar , medkord = :medkord , beskrivning = :beskrivning , vaxellada = :vaxellada , bild = :bild , pris = :pris , plats = :plats
   Where RegNr = :oldReg');
   //binder värdena till placeholders
   $UpdateCar ->bindParam(":RegNr" , $RegNr, pdo::PARAM_STR);
   $UpdateCar ->bindParam(":marke" , $marke, pdo::PARAM_STR);
   $UpdateCar ->bindParam(":modell" , $modell, pdo::PARAM_STR);
   $UpdateCar ->bindParam(":ar" , $ar, pdo::PARAM_STR);
   $UpdateCar ->bindParam(":medkord" , $medkord, pdo::PARAM_STR);
   $UpdateCar ->bindParam(":beskrivning" , $beskrivning, pdo::PARAM_STR);
   $UpdateCar ->bindParam(":vaxellada" , $vaxellada, pdo::PARAM_STR);
   $UpdateCar ->bindParam(":bild" , $bild, pdo::PARAM_STR);
   $UpdateCar ->bindParam(":pris" , $pris, pdo::PARAM_STR);
   $UpdateCar ->bindParam(":plats" , $plats, pdo::PARAM_STR);
   $UpdateCar ->bindParam(":oldReg" , $oldReg, pdo::PARAM_STR);
   //kör query
   $UpdateCar ->execute();

}

else{


  $kunder_fornamn = $_POST['kunder_fornamn'];
  $kunder_efternamn = $_POST['kunder_efternamn'];
  $kunder_telefon = $_POST['kunder_telefon'];
  //skapar query för att lägga till into i databasen
  //prepared statements med placeholders
  $addKund = $pdo->prepare('INSERT INTO kunder
  ( kunder_fornamn, kunder_efternamn, kunder_telefon)
  VALUES (:fornamn, :efternamn, :telefon)');

  $addKund ->bindParam(":fornamn" , $kunder_fornamn, pdo::PARAM_STR);
  $addKund ->bindParam(":efternamn" , $kunder_efternamn, pdo::PARAM_STR);
  $addKund ->bindParam(":telefon" , $kunder_telefon, pdo::PARAM_STR);
  $addKund ->execute();

  //hämtar den ny tillägda försäljarens ID ur databasen
  $getLastCust = $pdo->prepare('SELECT MAX(kunder_ID) AS kunder_ID FROM kunder');
  $getLastCust->execute();

  $kunderRow = $getLastCust->fetch();
  //binder id till senaste egaren
  $lastIncertedOwner = $kunderRow["kunder_ID"];
$addCar = $pdo->prepare('INSERT INTO bilar
 (RegNr , marke , modell , ar , medkord , beskrivning , vaxellada , bild , pris, plats)
 VALUES (:RegNr, :marke,:modell, :ar, :medkord,:beskrivning, :vaxellada, :bild, :pris, :plats)');
 //binder värdena till placeholders
 $addCar ->bindParam(":RegNr" , $RegNr, pdo::PARAM_STR);
 $addCar ->bindParam(":marke" , $marke, pdo::PARAM_STR);
 $addCar ->bindParam(":modell" , $modell, pdo::PARAM_STR);
 $addCar ->bindParam(":ar" , $ar, pdo::PARAM_STR);
 $addCar ->bindParam(":medkord" , $medkord, pdo::PARAM_STR);
 $addCar ->bindParam(":beskrivning" , $beskrivning, pdo::PARAM_STR);
 $addCar ->bindParam(":vaxellada" , $vaxellada, pdo::PARAM_STR);
 $addCar ->bindParam(":bild" , $bild, pdo::PARAM_STR);
 $addCar ->bindParam(":pris" , $pris, pdo::PARAM_STR);
 $addCar ->bindParam(":plats" , $plats, pdo::PARAM_STR);
 //kör query
 $addCar ->execute();
}
}


 ?>

<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>HTML5 page</title>
	<link rel="stylesheet" type="text/css" href="/upg5-8+/upg10/css/style.css">
  <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>tinymce.init({selector:'textarea'});</script>
</head>
<body>
<div class="wrapper center">


  <form method="post" action=""  enctype="multipart/form-data">
    FörNamn:<br>
    <input type="text" name="kunder_fornamn" required><br>
    Efternamn:<br>
    <input type="text" name="kunder_efternamn" required><br>
    Kund tele: <br>
    <input type="text" name="kunder_telefon" required><br>
    Bilens registrerings nummer:<br>
    <input type="text" name="RegNr" required><br>
    Märke:<br>
    <input type="text" name="marke" required><br>
    Modell:<br>
    <input type="text" name="modell" required><br>
    Medkörd: <br>
    <input type="text" name="medkord" required><br>
    Års modell: <br>
    <input type="text" name="ar" required><br>
    Beskrivning:<br>
    <textarea name="beskrivning"> </textarea><br>
    Växel låda <br>
    <input type="radio" name="vaxellada" value="1"> Manual <br>
    <input type="radio" name="vaxellada" value="0"> Automat <br>
    Bild:<br>
    <input type="file" name="bild" id="image"><br>
    Pris:<br>
    <input type="text" name="pris" required><br>
    Plats:<br>
    <input type="text" name="plats" required><br>

    <input type="submit" name="submit-Car" value="skapa artikel"><br><br>

  </form>
  <a href="http://localhost/upg5-8+/upg10/">Tillbacks till shoppen</a>
</div>
</body