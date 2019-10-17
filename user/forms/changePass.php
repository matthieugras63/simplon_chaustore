<?php require_once '../../connection.php' ?>
<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<?php


$msgErr = $msgSucc = "";
if (!empty($_POST['formerPass']) && !empty($_POST['newPass']) && !empty($_POST['newPass-2']) && !empty($_POST['email'])){
  $formerPass = $_POST['formerPass'];
  $newPass = password_hash($_POST['newPass'], PASSWORD_DEFAULT);
  $email = $_POST['email'];
  $checkFormerPass = "SELECT password FROM user WHERE email = '$email';";
  $req = mysqli_query($conn,$checkFormerPass);
  $donnees = mysqli_fetch_row($req);
  if ($donnees[0] === $formerPass) {
    if ($_POST['newPass'] === $_POST['newPass-2']) {
      $updatePass = "UPDATE user SET password = '$newPass' WHERE email = '$email';";
      $req = mysqli_query($conn,$updatePass);
      if ($_SESSION['function'] === "Admin") {
        $msgSucc .= "Mot de passe modifié ! Vous pouvez vous connecter dès maintenant. <br/>";
        $msgSucc .= "Vous allez être redirigé vers la page de connection";
        header("Refresh: 4; url=connect.php");
      } else {
        $msgSucc .= "Mot de passe modifié ! Vous pouvez vous connecter dès maintenant. <br/>";
        $msgSucc .= "Vous allez être redirigé vers l'accueil";
        header("Refresh: 4; url=../index.php");
      }
    } else {
      $msgErr .= "Les nouveaux mots de passe ne correspondent pas";
    }
  } else {
    $msgErr .= "<br/> L'ancien mot de passe ne correspond pas";
  }
}

if (isset($_POST['submit'])) {
  if (empty($_POST['formerPass'])){
    $msgErr .= "Veuillez saisir l'ancien mot de passe";
  }
  if (empty($_POST['newPass']) || empty($_POST['newPass-2'])) {
    $msgErr .= "Veuillez saisir votre nouveau mot de passe";
  }
}

?>
<body>
  <div>
    <span class="msgPostSubmit"><?php echo "<font color='red'>$msgErr</font>" ;?></span>
    <span class="msgPostSubmit"><?php echo "<font color='green'>$msgSucc</font>";?></span>
    <form action="changePass.php" method="POST">
      <p>
        <label>Ancien mot de passe : </label>
        <input type="password" name="formerPass" id="formerPass">
      </p>
      <p>
        <label>Adresse e-mail : </label>
        <input type="text" name="email" id="email">
      </p>
      <p>
        <label>Nouveau mot de passe : </label>
        <input type="password" name="newPass" id="newPass">
      </p>
      <p>
        <label>Confirmation mot de passe : </label>
        <input type="password" name="newPass-2" id="newPass-2">
      </p>
      <input type="submit" name="submit" value="Confirmer">
    </form>
    <button id="recoverPass">Retour</button>
  </div>

  <script type="text/javascript" src="../../backoffice/scripts/jquery-3.4.1.js"></script>
  <script type="text/javascript" src="../../backoffice/scripts/script.js"></script>
</body>

</html>
