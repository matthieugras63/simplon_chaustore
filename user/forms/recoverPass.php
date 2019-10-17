<?php require_once "../../connection.php" ?>
<?php require_once 'newPassword.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<?php


$msgErr = $msg = '';

if (!empty($_POST['mail'])) {
  $mail = $_POST['mail'];
  $checkIfValid = "SELECT email FROM user WHERE email = '$mail';";
  $req = mysqli_query($conn,$checkIfValid);
  $donnees = mysqli_fetch_row($req);
  if ($donnees[0] === NULL){
   $msgErr .= "<br/> Cette adresse e-mail n'existe pas !";
 } else {
  $msg .= "Un mail vous a été envoyé pour changer votre mot de passe";
  $newPass = createNewPass(15);
  $email = '
  <!DOCTYPE html>
  <html lang="fr">
  <head>
  <meta charset="UTF-8">
  <title>Document</title>
  </head>
  <body>
  <p>Voici le mot de passe provisoire qui vous est attribué :'.$newPass.'</p>
  <p> Pensez à le modifier en cliquant sur "Modifier mon mot de passe" dans votre navigateur </p>
  </body>
  </html>
  ';
  $headers = "FROM : simplon.chaustore@simplon.co\r\n".
  "Content-type: text/html; charset=UTF-8" . "\r\n";
  mail($_POST['mail'], "Réinitialisation de mot de passe - Chaustore", $email, $headers);
  $updatePass = "UPDATE user SET password = '$newPass' WHERE email = '$mail';";
  $req = mysqli_query($conn,$updatePass);
}
}

if (isset($_POST['submit'])) {
  if (empty($_POST['mail'])) {
    $msgErr .= "<br/> Vous devez préciser une adresse e-mail";
  }
}

?>


<body>
  <div>
    <span class="msgPostSubmit"><?php echo "<font color='red'>$msgErr</font>" ;?></span>
    <span class="msgPostSubmit"><?php echo $msg;?></span>
    <form action="recoverPass.php" method="POST">
      <p>
        <label>Adresse e-mail : </label>
        <input type="text" name="mail" id="mail">
      </p>
      <input type="submit" name="submit" value="Confirmer">
    </form>
    <?php if ($msg !== ""): ?>
      <button id="changePass">Modifier mon mot de passe</button>
    <?php endif ?>
    <button id="returnConnect">Retour</button>
  </div>

  <script type="text/javascript" src="../../backoffice/scripts/jquery-3.4.1.js"></script>
  <script type="text/javascript" src="../../backoffice/scripts/script.js"></script>
</body>

</html>
