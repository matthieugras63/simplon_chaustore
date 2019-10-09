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
if (!empty($_POST['deleteProduct']) && !empty($_POST['deleteColor']) && !empty($_POST['deleteCategory']) && !empty($_POST['deleteBrand'])) {
  $toDelete = $_POST['deleteProduct'];
  $toDeleteCategory = $_POST['deleteCategory'];
  $toDeleteColor = $_POST['deleteColor'];
  $toDeleteBrand = $_POST['deleteBrand'];
  $toDelete = mysqli_real_escape_string($conn, $toDelete);

  /* As the user select options from select tags, we have to check if the product he wants to delete exists */
  $checkIfExist = "SELECT id FROM product WHERE name = '$toDelete' AND category_id IN (SELECT id FROM category WHERE name = '$toDeleteCategory') AND brand_id IN (SELECT id FROM brand WHERE name = '$toDeleteBrand') AND color_id IN (SELECT id FROM color WHERE name = '$toDeleteColor');";
  $req = mysqli_query($conn, $checkIfExist);
  $donnees = mysqli_fetch_row($req);
  if ($donnees[0] == NULL) {
    $msgErr .= "<br/> Ce produit n'existe pas ( " . $_POST['deleteProduct'].", ". $_POST['deleteCategory'] ." de couleur ". $_POST['deleteColor']. " de la marque ".$_POST['deleteBrand']."  )";
  } else {

    /* here, we have to delete datas from all tables linked to product, , using it as foreign key */
    $delInStock = "DELETE FROM stock WHERE product_id IN (SELECT id FROM product WHERE name = '$toDelete' AND category_id IN (SELECT id FROM category WHERE name = '$toDeleteCategory') AND brand_id IN (SELECT id FROM brand WHERE name = '$toDeleteBrand') AND color_id IN (SELECT id FROM color WHERE name = '$toDeleteColor'));";
    $del = "DELETE FROM product WHERE name = '$toDelete' AND category_id IN (SELECT id FROM category WHERE name = '$toDeleteCategory') AND brand_id IN (SELECT id FROM brand WHERE name = '$toDeleteBrand') AND color_id IN (SELECT id FROM color WHERE name = '$toDeleteColor');";
    $req1 = mysqli_query($conn, $delInStock);
    $req2 = mysqli_query($conn, $del);
    $msgSucc .="<br/> Entrée supprimée avec succès ( " . $_POST['deleteProduct'].", ". $_POST['deleteCategory'] ." de couleur ". $_POST['deleteColor']. " de la marque ".$_POST['deleteBrand']."  )" ;
  }
}

/* Here, we will check if the input is empty when the user click on submit. If yes, error message appear */
if(isset($_POST["submit"]) && $msgErr === '') {
  if(empty($_POST["deleteProduct"])){
    $msgErr .= "<br/> Veuillez saisir un produit à supprimer";
  }
  if(empty($_POST["deleteColor"] && $_POST["deleteColor"] !== "Tous")){
    $msgErr .= "<br/> Veuillez saisir une couleur pour le produit";
  }
  if(empty($_POST["deleteBrand"] && $_POST["deleteColor"] !== "Tous")){
    $msgErr .= "<br/> Veuillez saisir une marque pour le produit";
  }
  if(empty($_POST["deleteCategory"] && $_POST["deleteColor"] !== "Tous")){
    $msgErr .= "<br/> Veuillez saisir une catégorie pour le produit";
  }
}

?>


<body>
  <main>
    <h2>Supprimer un produit</h2>
    <div>

      <span class="msgPostSubmit"><?php echo "<font color='red'>$msgErr</font>" ;?></span>
      <span class="msgPostSubmit"><?php echo "<font color='green'>$msgSucc</font>";?></span>

      <form action="delete_product.php" method="POST">
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
          <label for="deleteCategory">Catégorie :</label>
          <select name="deleteCategory" id="category">
            <option value="">Sélectionnez une catégorie</option>

            <?php

            $sizeName = "SELECT name FROM category ORDER BY id ASC";
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
          <label for="deleteBrand">Marque :</label>
          <select name="deleteBrand" id="brand">
            <option value="">Sélectionnez une marque</option>

            <?php

            $sizeName = "SELECT name FROM brand ORDER BY id ASC";
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
          <label for="deleteColor">Couleur :</label>
          <select name="deleteColor" id="color">
            <option value="">Sélectionnez une couleur</option>

            <?php

            $sizeName = "SELECT name FROM color ORDER BY id ASC";
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

        <input type="submit" name="submit" value="Supprimer" id="buttonDelete">
      </form>
    </div>
    <button>Retour</button>
  </main>
  <script type="text/javascript" src="../scripts/jquery-3.4.1.js"></script>
  <script type="text/javascript" src="../scripts/script.js"></script>
</body>

</html>

