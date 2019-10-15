<?php require_once "../../connection.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<?php

$msgErr = $msgSucc = "";

if (!empty($_POST['mail']) && !empty($_POST['password'])){
  $email = $_POST['mail'];
  $password = $_POST['password'];

  $check = "SELECT email, password FROM user WHERE email = '$email';";
  $req = mysqli_query($conn, $check);
  $donnees = mysqli_fetch_row($req);


  if ($donnees[0] === $email && password_verify($password, $donnees[1])) {
    $msgSucc .="<br/> Connection réussie";
  }else{
    $msgErr .="<br/> Identifiants incorrects";
  }
}

if (isset($_POST['submit'])) {

  if (empty($_POST["mail"] )) {
    $msgErr .= "<br/> Veuillez saisir votre adresse e-mail";
  }

  if (empty($_POST["password"] )) {
    $msgErr .= "<br/> Veuillez saisir votre mot de passe";
  }
}

?>


<body>
  <div>
    <span class="msgPostSubmit"><?php echo "<font color='red'>$msgErr</font>" ;?></span>
    <span class="msgPostSubmit"><?php echo "<font color='green'>$msgSucc</font>";?></span>
    <form action="connect.php" method="POST">
      <p>
        <label>Adresse e-mail : </label>
        <input type="text" name="mail" id="mail">
      </p>
      <p>
        <label>Mot de passe : </label>
        <input type="password" name="password" id="password">
      </p>
      <input type="submit" name="submit" value="Se connecter">
    </form>
    <a href="register.php"> S'inscrire</a>
    <a href="recoverPass.php">Mot de passe oublié</a>
    <button>Retour</button>
  </div>

  <script type="text/javascript" src="../../backoffice/scripts/jquery-3.4.1.js"></script>
  <script type="text/javascript" src="../../backoffice/scripts/script.js"></script>
</body>

</html>
