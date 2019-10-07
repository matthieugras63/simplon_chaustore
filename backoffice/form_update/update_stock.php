<?php require_once "../connection.php" ?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="../styles/form.css">
</head>


<?php

$msgSucc = $msgErr =  '';

if (!empty($_POST['updateProd']) && !empty($_POST['updateSize']) && !empty($_POST['updateType1']) && !empty($_POST['updateType2'])) {
  if ($_POST['updateType1'] === $_POST['updateType2']) {

    $prodToUpdate = $_POST['updateProd'];
    $numberUpdated = $_POST['updateType1'];
    $sizeToUpdate = $_POST['updateSize'];
    $prodToUpdate = mysqli_real_escape_string($conn, $prodToUpdate);
    $numberUpdated = mysqli_real_escape_string($conn, $numberUpdated);
    $checkIfExist = "SELECT stock FROM stock WHERE product_id IN (SELECT id FROM product WHERE name = '$prodToUpdate') AND size_id IN (SELECT id FROM size WHERE name = '$sizeToUpdate');";
    $req = mysqli_query($conn, $checkIfExist);
    $donnees = mysqli_fetch_row($req);
    if ($donnees[0] == NULL  || $donnees[0] == 0) {
      $msgErr .= "<br/> Ce produit n'est pas pas en stock pour cette pointure ( " . $_POST['updateProd']." en taille ". $_POST['updateSize']. " ). Il est possible de le créer en allant sur <a href=\"../form_add/add_stock.php\"> cette page </a>";
    } else {
      $update = "UPDATE stock SET stock = '$numberUpdated' WHERE product_id IN (SELECT id FROM product WHERE name = '$prodToUpdate') AND size_id IN (SELECT id FROM size WHERE name = '$sizeToUpdate');";
      $req = mysqli_query($conn, $update);
    }
  }else {
    $msgErr .= "<br/> Les deux entrées ne correspondent pas";
  }
}

if(isset($_POST["submit"]) && $msgErr === '') {

  if(empty($_POST["updateSize"]) || empty($_POST["updateProd"]) || empty($_POST['updateType1']) || empty($_POST['updateType2'])) {
    $msgErr .= "<br/> Veuillez saisir la modification à effectuer";
  } else {
    $msgSucc .="<br/> Le stock du produit " . $_POST['updateProd']." en taille " . $_POST['updateSize']. " a bien été modifiée avec succès. Il y a donc " . $_POST['updateType1']." produits en stock " ;
  }
}
?>


<body>
  <main>
    <h2>Modifier un stock</h2>
    <div>

      <span class="msgPostSubmit"><?php echo "<font color='red'>$msgErr</font>" ;?></span>
      <span class="msgPostSubmit"><?php echo "<font color='green'>$msgSucc</font>";?></span>

      <form action="update_stock.php" method="POST">
        <p>
          <label for="updateProd">Produit :</label>
          <select name="updateProd" id="brand">
            <option value="">Sélectionnez un produit</option>

            <?php

            $productName = "SELECT name FROM product ORDER BY id ASC";
            $req = mysqli_query($conn, $productName);

            while ($result = mysqli_fetch_row($req)){
              for ($i=0; $i < count($result) ; $i++) {
                ?>
                <option value="<?php echo $result[$i]; ?>"> <?php echo $result[$i]; ?></option>
                <?php
              }
            }
            ?>
          </select>
        </p>
        <p>
          <label for="updateSize">Pointure :</label>
          <select name="updateSize" id="size">
            <option value="">Sélectionnez une pointure</option>

            <?php

            $sizeName = "SELECT name FROM size ORDER BY id ASC";
            $req = mysqli_query($conn, $sizeName);

            while ($result = mysqli_fetch_row($req)){
              for ($i=0; $i < count($result) ; $i++) {
                ?>
                <option value="<?php echo $result[$i]; ?>"> <?php echo $result[$i]; ?></option>
                <?php
              }
            }
            ?>
          </select>
        </p>
        <p>
          <label for="updateType1">Saisissez le changement de stock numériquement :</label>
          <input type="text" name="updateType1">
        </p>
        <p>
          <label for="updateType2">Confirmez le changement de stock numériquement :</label>
          <input type="text" name="updateType2">
        </p>
        <input type="submit" name="submit" value="Modifier">
      </form>
    </div>
    <button>Retour</button>
  </main>
  <script type="text/javascript" src="../scripts/jquery-3.4.1.js"></script>
  <script type="text/javascript" src="../scripts/script.js"></script>
</body>

</html>

