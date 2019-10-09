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


/* If input iaren't empty : */
if (!empty($_POST['addName']) && !empty($_POST['addPrice']) && !empty($_POST['cat']) && !empty($_POST['brand']) && !empty($_POST['color'])) {

  $productName =$_POST['addName'];
  $brandName =$_POST['brand'];
  $colorName =$_POST['color'];
  $catName =$_POST['cat'];
  $price =floatval($_POST['addPrice']);
  $gender =$_POST['addGender'];

  /* Here, we check if the product the user want to add isn't already in the database */
  $checkIfExist = "SELECT name, brand_id, color_id, category_id,price, gender FROM product WHERE name = '$productName' AND brand_id = (SELECT id FROM brand WHERE name = '$brandName') AND color_id = (SELECT id FROM color WHERE name = '$colorName') AND category_id = (SELECT id FROM category WHERE name = '$catName') AND price = '$price' AND gender = '$gender';";
  $req = mysqli_query($conn, $checkIfExist);
  $donnees = mysqli_fetch_row($req);


  /* If the query return at least one row, it  means that the product is already registered */
  if ($donnees[0] !== NULL) {
    $msgErr .= "<br/> Ce produit est déjà référencé ( " . $_POST['addName'].", ". $_POST['cat'] ." de couleur ". $_POST['color']. " de la marque ".$_POST['brand']." pour ".$_POST['addGender']."  )";
  } else {

    /* If not, we insert the value into the database */
    $add = "INSERT INTO product (name, brand_id, color_id, category_id, price, gender) VALUES ('$productName', (SELECT id FROM brand WHERE name = '$brandName'), (SELECT id FROM color WHERE name = '$colorName'), (SELECT id FROM category WHERE name = '$catName'), $price, '$gender');";
    $req = mysqli_query($conn, $add);
    $msgSucc .="<br/> Entrée ajoutée avec succès ( " . $_POST['addName'].", ". $_POST['cat']." ". $_POST['color']. " pour ". $_POST['addGender']. " de la marque ". $_POST['brand']. " au prix de ". $_POST['addPrice']. "€ )" ;
  }
}

/* Here, we will check if the input is empty when the user click on submit. If yes, error message appear according to the empty input/select */
if (isset($_POST["submit"])) {

  if (empty($_POST["addName"] )) {
    $msgErr .= "<br/> Veuillez saisir un nom de produit à ajouter";
  }
  if (empty($_POST["cat"] )) {
    $msgErr .= "<br/> Veuillez choisir une catégorie pour le produit à ajouter";
  }
  if (empty($_POST["brand"] )) {
    $msgErr .= "<br/> Veuillez choisir une marque pour le produit à ajouter";
  }
  if (empty($_POST["color"] )) {
    $msgErr .= "<br/> Veuillez choisir une couleur";
  }
  if (empty($_POST["addPrice"] )) {
    $msgErr .= "<br/> Veuillez saisir un prix pour le produit à ajouter";
  }
}

?>


<body>
  <main>
    <h2>Ajouter un produit</h2>
    <div>

      <span class="msgPostSubmit"><?php echo "<font color='red'>$msgErr</font>" ;?></span>
      <span class="msgPostSubmit"><?php echo "<font color='green'>$msgSucc</font>";?></span>

      <form method="POST" action="add_product.php">
        <p>
          <label for="addName">Nom du produit : </label>
          <input type="text" name="addName" id="addName" autocomplete="off">
        </p>

        <!-- This select contains the values inserted in the category table, by name -->
        <p>
          <label for="cat">Catégorie :</label>  <select name="cat" id="cat">
            <option value="">Sélectionnez une catégorie</option>

            <?php

            $catName = "SELECT name FROM category ORDER BY id ASC ";
            $req = mysqli_query($conn, $catName);

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

        <!-- This select contains the values inserted in the brand table, by name -->
        <p>
          <label for="brand">Marque :</label>   <select name="brand" id="brand">
            <option value="">Sélectionnez une marque</option>


            <?php

            $brandName = "SELECT name FROM brand ORDER BY id ASC";
            $req = mysqli_query($conn, $brandName);

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

        <!-- This select contains the values inserted in the color table, by name -->
        <p>
          <label for="color">Couleur :</label>   <select name="color" id="color">
            <option value="">Sélectionnez une couleur</option>


            <?php

            $colorName = "SELECT name FROM color ORDER BY id ASC";
            $req = mysqli_query($conn, $colorName);

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
          <label for="addPrice">Prix du produit : </label>
          <input type="number" step="0.01" name="addPrice" min="0" id="addPrice" autocomplete="off">
        </p>
        <p>
          <label for="addGender">Femme</label>
          <input type="radio" id="addGender" name="addGender" value="F" checked>
          <label for="addGender">Homme</label>
          <input type="radio" id="addGender" name="addGender" value="H">
          <label for="addGender">Mixte</label>
          <input type="radio" id="addGender" name="addGender" value="M">
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
