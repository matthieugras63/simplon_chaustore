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
if (!empty($_POST['delete']) && !empty($_POST['deleteType'])) {
  if ($_POST['delete'] === $_POST['deleteType']) {

    $toDelete = $_POST['delete'];
    $toDelete = mysqli_real_escape_string($conn, $toDelete);

    /* here, we have to delete datas from all tables linked to brand, , using it as foreign key */
    $delInStock = "DELETE FROM stock WHERE product_id IN (SELECT id FROM product WHERE brand_id IN (SELECT id FROM brand WHERE name = '$toDelete'));";
    $delInProd ="DELETE FROM product WHERE brand_id IN (SELECT id FROM brand WHERE name = '$toDelete');";
    $delInBrand ="DELETE FROM brand WHERE name = '$toDelete';";
    $req1 = mysqli_query($conn, $delInStock);
    $req2 = mysqli_query($conn, $delInProd);
    $req3 = mysqli_query($conn, $delInBrand);
  } else {
    $msgErr .= "<br/> Les deux entrées ne correspondent pas";
  }
}

/* Here, we will check if the input is empty when the user click on submit. If yes, error message appear */
if(isset($_POST["submit"]) && $msgErr === '') {

  if(empty($_POST["delete"]) || empty($_POST['deleteType'])) {
    $msgErr .= "<br/> Veuillez saisir une marque à supprimer";
  } else {
    $msgSucc .="<br/> Entrée supprimée avec succès ( " . $_POST['delete']." )" ;
  }
}
?>


<body>
  <main>
    <h2>Supprimer une marque de chaussure</h2>
    <div>

      <span class="msgPostSubmit"><?php echo "<font color='red'>$msgErr</font>" ;?></span>
      <span class="msgPostSubmit"><?php echo "<font color='green'>$msgSucc</font>";?></span>

      <form action="delete_brand.php" method="POST">
        <p>
          <label for="delete">Marque :</label>
          <select name="delete" id="brand">
            <option value="">Sélectionnez une marque</option>

            <?php

            $colorName = "SELECT name FROM brand ORDER BY id ASC";
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
          <label for="deleteType">Saisissez la marque en toute lettre :</label>
          <input type="text" name="deleteType">
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

