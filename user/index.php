<?php session_start()  ?>
<?php require_once '../connection.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

  <header>
    <nav>
      <ul>
        <li>Accueil</li>
        <?php if (!isset($_SESSION['id'])): ?>
          <li>Inscription</li>
          <li>Connexion</li>
          <?php else : ?>
            <li>Panier</li>
            <li>Déconnexion</li>
          <?php endif ?>
        </ul>
      </nav>
      <h1>Bienvenue sur la boutique Chaustore <?php if (isset($_SESSION['id'])) {echo" , ". $_SESSION['firstname'];} ?></h1>
    </header>

    <main>

      <?php

      $products = "SELECT product.name AS product, category.name AS category, brand.name AS brand ,price, image ,sum(stock) as stock FROM stock INNER JOIN product ON stock.product_id = product.id INNER JOIN brand ON product.brand_id = brand.id INNER JOIN category ON product.category_id = category.id GROUP BY product_id ORDER BY product.name;";

      $req = mysqli_query($conn, $products);
      while($result = mysqli_fetch_array($req)){
        for ($i=0; $i<count($result); $i++)
         ?>
       <div>
        <?php
        $msg ="";
        ?>
        <?php if ($result['image'] !== ''): ?>
         <img src="../backoffice/form_add/images/<?php echo $result['image'] ?>" alt="<?php echo $result['product'] ?>" />
         <?php else : ?>
          <p class="noImage">Aucune image disponible pour le moment</p>
         <?php endif ;?>
         <p><span>Produit</span> : <?php echo $result['product'] ?> </p>
         <p><span>Marque</span> : <?php echo $result['brand'] ?> </p>
         <p><span>Catégorie</span> : <?php echo$result['category'] ?> </p>
         <p><span>Prix</span> : <?php echo $result['price'] ?> € </p>
         <?php
         if ($result['stock'] == 0) {
          echo "<font color='red'>Aucun produit en stock</font>";
        } else if ($result['stock'] > 0 && $result['stock'] <= 10 ){
          echo "<font color = 'orange'> Produit presque épuisé</font>";
        } else {
          echo "<font color = 'green'> Produit disponible</font>";
        }
        ?>
      </div>
      <?php
    }

    ?>


  </main>

  <script type="text/javascript" src="../backoffice/scripts/jquery-3.4.1.js"></script>
  <script type="text/javascript" src="../backoffice/scripts/script.js"></script>
</body>
</html>
