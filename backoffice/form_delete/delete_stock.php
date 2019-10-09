<?php require_once "../../connection.php" ?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="../styles/form.css">
</head>


<?php

/* variables containing messages initialized */
$msgSucc = $msgErr =  '';

/* If the input isn't empty : */
if (!empty($_POST['deleteProduct']) && !empty($_POST['deleteTypeProduct']) && !empty($_POST['deleteSize']) && !empty($_POST['deleteTypeSize'])) {
  if ($_POST['deleteProduct'] === $_POST['deleteTypeProduct'] && $_POST['deleteSize'] === $_POST['deleteTypeSize']) {

    $toDeleteProduct = $_POST['deleteProduct'];
    $toDeleteProduct = mysqli_real_escape_string($conn, $toDeleteProduct);
    $toDeleteSize = $_POST['deleteSize'];
    $toDeleteSize = mysqli_real_escape_string($conn, $toDeleteSize);


    /* As the user select options from select tags, we have to check if the product he wants to delete exists */
    $checkIfExist = "SELECT stock FROM stock WHERE product_id IN (SELECT id FROM product WHERE name = '$toDeleteProduct') AND size_id IN (SELECT id FROM size WHERE name = '$toDeleteSize');";
    $req = mysqli_query($conn, $checkIfExist);
    $donnees = mysqli_fetch_row($req);

    /* If the query return at least one row, or a value equal to 0, it  means that the product isn't registered, or has a stock equal to 0 */
    if ($donnees[0] == NULL  || $donnees[0] == 0) {
      $msgErr .= "<br/> Ce produit n'est pas pas en stock pour cette pointure ( " . $_POST['deleteProduct']." en taille ". $_POST['deleteSize']. " )";
    } else {
      $del = "DELETE FROM stock WHERE product_id IN (SELECT id FROM product WHERE name = '$toDeleteProduct') AND size_id IN (SELECT id FROM size WHERE name = '$toDeleteSize');";
      $req1 = mysqli_query($conn, $del);
      $msgSucc .="<br/> Entrée supprimée avec succès ( " . $_POST['deleteProduct']." en taille ". $_POST['deleteSize']. " )" ;
    }

  } else if ($_POST['deleteProduct'] !== $_POST['deleteTypeProduct']) {
    $msgErr .= "<br/> Les produits ne correspondent pas";
  } else if ($_POST['deleteSize'] !== $_POST['deleteTypeSize']){
    $msgErr .= "<br/> Les pointures ne correspondent pas";
  }
}


/* Here, we will check if the input is empty when the user click on submit. If yes, error message appear */
if(isset($_POST["submit"]) && $msgErr === '') {

  if(empty($_POST["deleteProduct"]) || empty($_POST['deleteTypeProduct'])) {
    $msgErr .= "<br/> Veuillez saisir un produit à supprimer";
  }
  if(empty($_POST["deleteSize"]) || empty($_POST['deleteTypeSize'])) {
    $msgErr .= "<br/> Veuillez saisir une pointure à supprimer";
  }
}

?>


<body>
  <main>
    <h2>Supprimer un produit en stock</h2>
    <div>

      <span class="msgPostSubmit"><?php echo "<font color='red'>$msgErr</font>" ;?></span>
      <span class="msgPostSubmit"><?php echo "<font color='green'>$msgSucc</font>";?></span>

      <form action="delete_stock.php" method="POST">
        <p>
          <label for="deleteProduct">Produit :</label>
          <select name="deleteProduct" id="product">
            <option value="">Sélectionnez un produit</option>

            <?php

            $productName = "SELECT name FROM product ORDER BY name ASC";
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
          <label for="deleteTypeProduct">Saisissez le produit en toute lettre :</label>
          <input type="text" name="deleteTypeProduct">
        </p>
        <p>
          <label for="deleteSize">Pointure :</label>
          <select name="deleteSize" id="size">
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
          <label for="deleteTypeSize">Saisissez la pointure numériquement :</label>
          <input type="text" name="deleteTypeSize">
        </p>
        <input type="submit" name="submit" value="Supprimer" id="buttonDelete">
      </form>
    </div>
    <button>Retour</button>
  </main>
  <script type="text/javascript" src="../scripts/jquery-3.4.1.js"></script>
  <script type="text/javascript" src="../scripts/script.js"></script>
</body>

</html>

