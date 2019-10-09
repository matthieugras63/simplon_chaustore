<?php require_once "../../connection.php" ?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="../styles/form.css">
</head>


<?php

$msgSucc = $msgErr =  '';

if (!empty($_POST['update']) && !empty($_POST['updateType1']) && !empty($_POST['updateType2'])) {
  if ($_POST['updateType1'] === $_POST['updateType2']) {

    $toUpdate = $_POST['update'];
    $nameUpdated = $_POST['updateType1'];
    $toUpdate = mysqli_real_escape_string($conn, $toUpdate);
    $nameUpdated = mysqli_real_escape_string($conn, $nameUpdated);
    $checkIfExist = "SELECT name FROM size WHERE name = '$nameUpdated';";
    $req = mysqli_query($conn, $checkIfExist);
    $donnees = mysqli_fetch_row($req);
    if ($donnees[0] !== NULL) {
      $msgErr .= "<br/> la pointure " . $_POST['updateType1']." est déjà référencée ";
    } else {
      $update = "UPDATE size SET name = '$nameUpdated' WHERE name = '$toUpdate';";
      $req2 = mysqli_query($conn, $update);
    }
  }else {
    $msgErr .= "<br/> Les deux entrées ne correspondent pas";
  }
}
if(isset($_POST["submit"]) && $msgErr === '') {

  if(empty($_POST["update"]) || empty($_POST['updateType1']) || empty($_POST['updateType2'])) {
    $msgErr .= "<br/> Veuillez saisir la modification à effectuer";
  } else {
    $msgSucc .="<br/> La pointure " . $_POST['update']." a bien été modifiée avec succès en " . $_POST['updateType1']." " ;
  }
}
?>


<body>
  <main>
    <h2>Modifier une pointure de chaussure</h2>
    <div>

      <span class="msgPostSubmit"><?php echo "<font color='red'>$msgErr</font>" ;?></span>
      <span class="msgPostSubmit"><?php echo "<font color='green'>$msgSucc</font>";?></span>

      <form action="update_brand.php" method="POST">
        <p>
          <label for="update">Pointure :</label>
          <select name="update" id="size">
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
          <label for="updateType1">Saisissez le changement en toute lettre :</label>
          <input type="text" name="updateType1">
        </p>
        <p>
          <label for="updateType2">Confirmez le changement en toute lettre :</label>
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

