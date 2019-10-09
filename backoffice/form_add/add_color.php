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
if (!empty($_POST['add'])) {
  $toAdd = $_POST['add'];

  /* Here, we will check if the brand the user want to register isn't already in the database */
  $checkIfExist = "SELECT name FROM color WHERE name = '$toAdd';";
  $req = mysqli_query($conn, $checkIfExist);
  $donnees = mysqli_fetch_row($req);

  /* If the query return at least one row, it  means that the color is already registered */
  if ($donnees[0] !== NULL) {
    $msgErr .= "<br/> Cette couleur est déjà référencée ( " . $_POST['add'].")";
  } else {
    $add = "INSERT INTO color (name) VALUES ('$toAdd');";
    $req = mysqli_query($conn, $add);
    $msgSucc .="<br/> Entrée ajoutée avec succès ( " . $_POST['add']." )" ;
  }
}

/* Here, we will check if the input is empty when the user click on submit. If yes, error message appear */
if (isset($_POST["submit"])) {

  if(empty($_POST["add"])) {
    $msgErr .= "<br/> Veuillez saisir une couleur à ajouter";
  }
}
?>


<body>
  <main>
    <h2>Ajouter une couleur de chaussure</h2>
    <div>

      <span class="msgPostSubmit"><?php echo "<font color='red'>$msgErr</font>" ;?></span>
      <span class="msgPostSubmit"><?php echo "<font color='green'>$msgSucc</font>";?></span>

      <form action="add_color.php" method="POST">
        <p>
          <label for="add">Nom de la couleur :</label>
          <input type="text" name="add" id="add" autocomplete="off">
        </p>
        <input type="submit" name="submit">
      </form>
    </div>
    <button>Retour</button>
  </main>
  <script type="text/javascript" src="../scripts/jquery-3.4.1.js"></script>
  <script type="text/javascript" src="../scripts/script.js"></script>
</body>

</html>

