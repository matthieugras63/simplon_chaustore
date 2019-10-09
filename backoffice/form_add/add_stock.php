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
if (!empty($_POST['stock']) && !empty($_POST['product'])) {
  $product =$_POST['product'];
  $size =$_POST['size'];
  $stock = $_POST['stock'];

  /* Here, we will check if the brand the user want to register isn't already in the database */
  $checkIfExist = "SELECT product_id, size_id FROM stock WHERE stock > 0 AND product_id = (SELECT id FROM product WHERE name = '$product') AND size_id = (SELECT id FROM size WHERE name = '$size');";
  $req = mysqli_query($conn, $checkIfExist);
  $donnees = mysqli_fetch_row($req);


  /* If the query return at least one row, it  means that the stock is already registered */
  if ($donnees[0] !== NULL) {
    $howMuchStock = "SELECT stock FROM stock WHERE product_id = (SELECT id FROM product WHERE name = '$product') AND size_id = (SELECT id FROM size WHERE name = '$size');";
    $req2 = mysqli_query($conn, $howMuchStock);
    $donnees2 = mysqli_fetch_row($req2);
    $msgErr .= "<br/> Il y a déjà ".$donnees2[0]." " . $_POST['product']." en taille  ". $_POST['size'] ."  en stock . Vous pouvez modifier ce stock en suivant ce <a href=\"../form_update/update_stock.php\"> lien </a>";
  } else {

    /* If not, we insert the value into the database */
    $add = "INSERT INTO stock (product_id, size_id, stock) VALUES ((SELECT id FROM product WHERE name = '$product'), (SELECT id FROM size WHERE name = '$size'), $stock);";
    $req = mysqli_query($conn, $add);
    $msgSucc .="<br/> Entrée ajoutée avec succès ( ". $_POST['stock'] . " ". $_POST['product']."  disponibles en taille ". $_POST['size']. ")" ;
  }
}

/* Here, we will check if the input is empty when the user click on submit. If yes, error message appear */
if (isset($_POST["submit"])) {

  if (empty($_POST["size"] )) {
    $msgErr .= "<br/> Veuillez saisir une pointure pour le produit";
  }
  if (empty($_POST["stock"] )) {
    $msgErr .= "<br/> Veuillez saisir un nombre de produits disponibles";
  }
}

?>


<body>
  <main>
    <h2>Ajouter un stock</h2>
    <div>

      <span class="msgPostSubmit"><?php echo "<font color='red'>$msgErr</font>" ;?></span>
      <span class="msgPostSubmit"><?php echo "<font color='green'>$msgSucc</font>";?></span>

      <form method="POST" action="add_stock.php">


        <!-- This select contains the values inserted in the product table, by name. Problem if 2 products have the same name -->
        <p>
          <label for="product">Produit : </label>  <select name="product" id="product">
            <option value="">Sélectionnez un produit</option>

            <?php

            $productName = "SELECT DISTINCT name FROM product ORDER BY name ASC";
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


        <!-- This select contains the values inserted in the size table, by name -->
        <p>
          <label for="size">Pointure :</label>   <select name="size" id="size">

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
          <label for="stock">Nombre en stock : </label>
          <input type="number" step="1" name="stock" id="stock" autocomplete="off">
        </p>
        <input type="submit" name="submit" id="submit_button">
      </form>
    </div>
    <button>Retour</button>
  </main>
  <script type="text/javascript" src="../scripts/jquery-3.4.1.js"></script>
  <script type="text/javascript" src="../scripts/script.js"></script>
</body>

</html>
