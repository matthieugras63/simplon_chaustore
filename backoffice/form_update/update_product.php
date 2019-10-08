<?php require_once "../connection.php" ?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="../styles/form.css">
</head>

<body>
  <main>
    <h2>Modifier un produit</h2>
    <div>
      <form action="to_update_product.php" method="POST">
        <p>
          <label for="update">Produit :</label>
          <select name="update" id="product">
            <option value="">Sélectionnez un produit</option>

            <?php

            $productName = "SELECT product.id , product.name , category.name , brand.name , color.name , price , gender FROM product INNER JOIN category ON product.category_id = category.id INNER JOIN brand ON product.brand_id = brand.id INNER JOIN color ON product.color_id = color.id ORDER BY product.name ASC;";
            $req = mysqli_query($conn, $productName);

            while ($result = mysqli_fetch_row($req)){
              for ($i=0; $i < count($result) ; $i+=7) {
                ?>
                <option value="<?php echo $result[$i]; ?>"> <?php echo $result[$i+1]." . ". $result[$i+2]." . ". $result[$i+3]." . ". $result[$i+4]." . ". $result[$i+5]. " . ". $result[$i+6]; ?></option>
                <?php
              }
            }
            ?>
          </select>
        </p>
        <input type="submit" name="submit" value="Valider">
      </form>
    </div>
    <button>Retour</button>
  </main>
  <script type="text/javascript" src="../scripts/jquery-3.4.1.js"></script>
  <script type="text/javascript" src="../scripts/script.js"></script>
</body>

</html>

