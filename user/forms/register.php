<?php require_once "../../connection.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="../../backoffice/styles/form.css">
</head>

<?php

$msgErr = $msgSucc = "";


if (!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email']) && !empty($_POST['email-2']) && !empty($_POST['password']) && !empty($_POST['password-2']) && $_POST['email'] === $_POST['email-2'] && $_POST['password'] === $_POST['password-2'] && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){

  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $checkIfExist = "SELECT email FROM user WHERE email = '$email';";
  $req = mysqli_query($conn, $checkIfExist);
  $donnees = mysqli_fetch_row($req);
  if ($donnees[0] !== NULL) {
    $msgErr .= "<br/> Cette adresse email est déjà utilisée";
  } else {
    $add = "INSERT INTO user (firstname, lastname, email, password) VALUES ('$firstname', '$lastname', '$email', '$password');";
    $req = mysqli_query($conn, $add);
    $msgSucc .="Inscription réussie. Un mail de confirmation va vous être envoyé à l'adresse ". $_POST['email'] ;
    $msgSucc .="<br/> Vous allez être redirigé vers l'accueil";
    mail($_POST['email'], "Confirmation d'inscription - Chaustore", "C'est avec joie que l'équipe Chaustore confirme votre inscription ! A bientôt sur notre site !", "FROM : simplon.chaustore@simplon.co");
    header("Refresh: 7; url=../index.php");
  }
}


if (isset($_POST['submit'])) {

  if (empty($_POST["firstname"] )) {
    $msgErr .= "<br/> Veuillez saisir un prénom";
  }

  if (empty($_POST["lastname"] )) {
    $msgErr .= "<br/> Veuillez saisir un nom";
  }

  if(empty($_POST['email'])){
    $msgErr .= "<br/> Veuillez saisir votre email";
  }

  if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $msgErr .= "<br/> Veuillez saisir un email valide";
  }

  if (empty($_POST["email-2"] )) {
    $msgErr .= "<br/> Veuillez confirmer l'adresse e-mail";
  }

  if (empty($_POST["password"] )) {
    $msgErr .= "<br/> Veuillez saisir un mot de passe";
  }

  if (empty($_POST["password-2"] )) {
    $msgErr .= "<br/> Veuillez confirmer le mot de passe";
  }

  if ($_POST["email"]!== $_POST["email-2"]) {
    $msgErr .= "<br/> Les adresses E-mail ne correspondent pas";
  }

  if ($_POST["password"]!=$_POST["password-2"]) {
    $msgErr .= "<br/> Les mots de passe ne correspondent pas";
  }

}

?>

<body>
  <main>
    <h2>Inscription</h2>
    <div>
      <span class="msgPostSubmit"><?php echo "<font color='red'>$msgErr</font>" ;?></span>
      <span class="msgPostSubmit"><?php echo "<font color='green'>$msgSucc</font>";?></span>

      <form method="POST" action="register.php">
        <p>
          <label for="firstname">Prénom *:</label>
          <input type="text" name="firstname" id="firstname" autocomplete="off">
        </p>
        <p>
          <label for="lastname">Nom *:</label>
          <input type="text" name="lastname" id="lastname" autocomplete="off">
        </p>
        <p>
          <label for="email">E-mail *:</label>
          <input type="text" name="email" id="email" autocomplete="off">
        </p>
        <p>
          <label for="email-2">Confirmation de l'E-mail *:</label>
          <input type="text" name="email-2" id="email-2" autocomplete="off">
        </p>
        <p>
          <label for="password">Mot de passe *:</label>
          <input type="password" name="password" id="password" autocomplete="off">
        </p>
        <p>
          <label for="password-2">Confirmation du mot de passe *:</label>
          <input type="password" name="password-2" id="password-2" autocomplete="off">
        </p>
        <input type="submit" name="submit">
      </form>
    </div>
    <p>Les champs marqués d'une * sont obligatoires</p>
    <p>/!\ Actuellement, seules les adresses e-mail de la forme xxx@gmail.com sont supportées. Nous travaillons à améliorer ceci pour votre confort</p>
    <button>Retour</button>
  </main>
  <script type="text/javascript" src="../../backoffice/scripts/jquery-3.4.1.js"></script>
  <script type="text/javascript" src="../../backoffice/scripts/script.js"></script>
</body>
</html>
