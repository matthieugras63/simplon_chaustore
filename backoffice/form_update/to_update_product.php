<?php session_start();

if (!empty($_POST['update'])) {
  $idProduct = $_POST['update'];
} else $idProduct = $_SESSION['idProduct'];
if ($idProduct != "") $_SESSION['idProduct'] = $idProduct;
$test = $_SESSION['idProduct'];

?>

<?php require_once "../connection.php" ?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="../styles/form.css">
  <link rel="stylesheet" type="text/css" href="../styles/form_update_product.css">
</head>



<?php

$msgSucc = $msgErr =  '';

if (!empty($_POST['productName']) && !empty($_POST['price'])) {
  $product = $_POST['productName'];
  $brand = $_POST['brandName'];
  $category = $_POST['categoryName'];
  $color = $_POST['colorName'];
  $price = $_POST['price'];
  $gender = $_POST['gender'];
  $checkIfExist = "SELECT name, brand_id, color_id, category_id,price, gender FROM product WHERE name = '$product' AND brand_id = (SELECT id FROM brand WHERE name = '$brand') AND color_id = (SELECT id FROM color WHERE name = '$color') AND category_id = (SELECT id FROM category WHERE name = '$category') AND price = '$price' AND gender = '$gender';";
  $req = mysqli_query($conn, $checkIfExist);
  $donnees = mysqli_fetch_row($req);
  if ($donnees[0] !== NULL) {
    $msgErr .= "<br/> Ce produit est déjà référencé ( " . $_POST['productName'].", ". $_POST['categoryName'] ." de couleur ". $_POST['colorName']. " de la marque ".$_POST['brandName']." pour ".$_POST['gender']."  )";
  } else {
    $formerName = "SELECT name FROM product WHERE id = $test";
    $formerCategory = "SELECT category.name FROM product INNER JOIN category ON product.category_id = category.id WHERE product.id = $test";
    $formerBrand = "SELECT brand.name FROM product INNER JOIN brand ON product.brand_id = brand.id WHERE product.id = $test";
    $formerColor = "SELECT color.name FROM product INNER JOIN color ON product.color_id = color.id WHERE product.id = $test";
    $formerPrice = "SELECT price FROM product WHERE id = $test";
    $formerGender = "SELECT gender FROM product WHERE id = $test";
    $req2 = mysqli_query($conn,$formerName);
    $req3 = mysqli_query($conn,$formerCategory);
    $req4 = mysqli_query($conn,$formerBrand);
    $req5 = mysqli_query($conn,$formerColor);
    $req6 = mysqli_query($conn,$formerPrice);
    $req7 = mysqli_query($conn,$formerGender);
    $donnees2 = mysqli_fetch_row($req2);
    $donnees3 = mysqli_fetch_row($req3);
    $donnees4 = mysqli_fetch_row($req4);
    $donnees5 = mysqli_fetch_row($req5);
    $donnees6 = mysqli_fetch_row($req6);
    $donnees7 = mysqli_fetch_row($req7);
    $update = "UPDATE product SET name = '$product' , brand_id = (SELECT id FROM brand WHERE name = '$brand'), color_id = (SELECT id FROM color WHERE name = '$color'), category_id = (SELECT id FROM category WHERE name = '$category'), price = $price, gender = '$gender' WHERE product.id = $test;";
    $req8 = mysqli_query($conn, $update);
    if ($donnees2[0] !== $_POST['productName']) {
      $msgSucc .= "<br/>Le nom a bien été modifié, de ".$donnees2[0]." à ".$_POST['productName']." ";
    }
    if ($donnees3[0] !== $_POST['categoryName']) {
      $msgSucc .= "<br/>La catégorie a bien été modifiée, de ".$donnees3[0]." à ".$_POST['categoryName']." ";
    }
    if ($donnees4[0] !== $_POST['brandName']) {
      $msgSucc .= "<br/>La marque a bien été modifiée, de ".$donnees4[0]." à ".$_POST['brandName']." ";
    }
    if ($donnees5[0] !== $_POST['colorName']) {
      $msgSucc .= "<br/>La couleur a bien été modifiée, de ".$donnees5[0]." à ".$_POST['colorName']." ";
    }
    if ($donnees6[0] !== $_POST['price']) {
      $msgSucc .= "<br/>Le prix a bien été modifié, de ".$donnees6[0]." à ".$_POST['price']." ";
    }
    if ($donnees7[0] !== $_POST['gender']) {
      $msgSucc .= "<br/>Le sexe a bien été modifié, de ".$donnees7[0]." à ".$_POST['gender']." ";
    }
  }
}


?>


<body>
  <main>
    <h2>Modifier un produit</h2>
    <div>

      <span class="msgPostSubmit"><?php echo "<font color='red'>$msgErr</font>" ;?></span>
      <span class="msgPostSubmit"><?php echo "<font color='green'>$msgSucc</font>";?></span>

      <form method="POST" action="to_update_product.php">

        <p>

          <?php
          $productName = "SELECT name FROM product WHERE id = $test;";
          $req = mysqli_query($conn, $productName);
          $product = mysqli_fetch_row($req);
          ?>

          <label for="productName">Nom du produit : </label>
          <input type="text" name="productName" id="productName" autocomplete="off" value="<?php echo $product[0]; ?>">
        </p>

        <p>
          <label for="categoryName">Catégorie du produit  : </label>
          <select name="categoryName" id="categoryName">
           <?php

           $catName = "SELECT category.name FROM product INNER JOIN category ON product.category_id = category.id WHERE product.id = $test ORDER BY product.id ASC;";
           $req = mysqli_query($conn, $catName);

           while ($result = mysqli_fetch_row($req)){
            for ($i=0; $i < count($result) ; $i++) {
              ?>
              <option value="<?php echo $result[$i]; ?>"> <?php echo $result[$i]; ?></option>
              <?php
            }
          }

          $catName = "SELECT name FROM category WHERE name != (SELECT category.name FROM product INNER JOIN category ON product.category_id = category.id WHERE product.id = '$test') ORDER BY id ASC ";
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

      <p>
        <label for="brandName">Marque du produit : </label>
        <select name="brandName" id="brandName">
         <?php

         $brandName = "SELECT brand.name FROM product INNER JOIN brand ON product.brand_id = brand.id WHERE product.id = '$test' ORDER BY product.id ASC;";
         $req = mysqli_query($conn, $brandName);

         while ($result = mysqli_fetch_row($req)){
          for ($i=0; $i < count($result) ; $i++) {
            ?>
            <option value="<?php echo $result[$i]; ?>"> <?php echo $result[$i]; ?></option>
            <?php
          }
        }

        $brandName = "SELECT name FROM brand WHERE name != (SELECT brand.name FROM product INNER JOIN brand ON product.brand_id = brand.id WHERE product.id = '$test' ORDER BY product.id ASC) ORDER BY id ASC";
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

    <p>
      <label for="colorName">Nouvelle couleur du produit : </label>
      <select name="colorName" id="colorName">
        <?php

        $colorName = "SELECT color.name FROM product INNER JOIN color ON product.color_id = color.id WHERE product.id = '$test' ORDER BY product.id ASC;";
        $req = mysqli_query($conn, $colorName);

        while ($result = mysqli_fetch_row($req)){
          for ($i=0; $i < count($result) ; $i++) {
            ?>
            <option value="<?php echo $result[$i]; ?>"> <?php echo $result[$i]; ?></option>
            <?php
          }
        }
        $colorName = "SELECT name FROM color WHERE name != (SELECT color.name FROM product INNER JOIN color ON product.color_id = color.id WHERE product.id = '$test' ORDER BY product.id ASC) ORDER BY id ASC";
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

      <?php
      $productPrice = "SELECT price FROM product WHERE id = $test;";
      $req = mysqli_query($conn, $productPrice);
      $price = mysqli_fetch_row($req);
      ?>

      <label for="price">Prix du produit : </label>
      <input type="number" step="0.01" name="price" min="0" id="price" autocomplete="off" value="<?php echo $price[0]; ?>">
    </p>

    <p>


      <?php
      $productGender = "SELECT gender FROM product WHERE id = $test;";
      $req = mysqli_query($conn, $productGender);
      $gender = mysqli_fetch_row($req);
      ?>


      <label for="gender">Femme</label>
      <input type="radio" id="gender" name="gender" value="F" <?php if ($gender[0] === "F") {echo 'checked="checked"' ;} ?>>
      <label for="gender">Homme</label>
      <input type="radio" id="gender" name="gender" value="H" <?php if ($gender[0] === "H") {echo 'checked="checked"' ;} ?>>
      <label for="gender">Mixte</label>
      <input type="radio" id="gender" name="gender" value="M" <?php if ($gender[0] === "M") {echo 'checked="checked"' ;} ?>>
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
