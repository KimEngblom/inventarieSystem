<?php
include "includes/config.php";

$inventory = $pdo->prepare('SELECT * FROM inventory');
#$inventory = $stmt->fetchAll();
$inventory->execute();
#$fetch = $inventory->fetchAll();

if (isset($_POST['changeAmount'])){
	// binder variabler som matats in i formuläret
$item = $_POST['item'];
$ID = $_POST['ID'];
//skapar query för att lägga till indo i databasen
//prepared statements med placeholders
$updateArticle = $pdo->prepare('UPDATE inventory
  SET amount = :amount
  WHERE ID  = :ID');
 
 //binder värdena till placeholders
 $updateArticle ->bindParam(":amount" , $amount, pdo::PARAM_STR);
 $updateArticle ->bindParam(":ID" , $ID, pdo::PARAM_STR);
 //kör query
 $updateArticle ->execute();
}

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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="bootstrap-5.3.7/dist/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="bootstrap-5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js" defer></script>

    <title>Document</title>
</head>
<body>
    <p>Visar vad för produkter som finns och hur mycket. Kan även ändra mängd på produkten. + eller - </p>
    <button class="indexButton" href='index.html'> Hem</button>
    
    
    <div class="container-fluid">
        <div class="row pt-3">
            
             

              <?php
                foreach ($inventory as $row):
                  echo '<div class="col-6" >';
                    echo '<div class="card bg-light" data-bs-toggle="modal" data-bs-target="#modal-' . $row ["ID"] .'">';
                      echo '<h5 class="card-title text-center mt-2">' . $row ["item"] . '</h5>';
                      echo '<img src=img/' . $row ["img"] . ' class="card-img-top test" alt="...">';
                      echo '<h4 class="card-title text-center mt-2">' . $row ["amount"] . '</h4>';
                    echo '</div>';
                  echo '</div>';
                ?>

                <!-- Modal -->
                <div class="modal fade" id="modal-<?php echo (int)$row ["ID"]; ?>" tabindex="-1" role="dialog" aria-labelledby="label-<?php echo (int)$row ["ID"]; ?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header row">
                        <h5 class="modal-title col-10"><?php echo $row ["item"]; ?></h5>
                        <button type="button" class="close col-2 justify-content-end" data-bs-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p><?php echo $row ["item"] . ' ' . $row ["amount"]; ?></p>
                        <div class="row mb-3">
                          <button type="button" class="btn btn-danger col-6 justify-content-center">-1</button>
                          <button type="button" class="btn btn-success col-6 justify-content-center">+1</button>
                        </div>
                        <div class="row">
                          <input type="number" class="col-10">
                          <button type="button" class="btn btn-success col-2 justify-content-center">Save</button>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                      </div>
                    </div>
                  </div>
                </div>
              
              <?php endforeach; ?>


              
  </div>




</body>
</html>