<?php require_once "../../connection.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="../../backoffice/styles/form.css">
</head>
<body>
  <main>
    <h2>Inscription</h2>
    <div>
      <form method="POST" action="register.php">
        <p>
          <label for="firstname">Prénom :</label>
          <input type="text" name="firstname" id="firstname" autocomplete="off">
        </p>
        <p>
          <label for="lastname">Nom :</label>
          <input type="text" name="lastname" id="lastname" autocomplete="off">
        </p>
        <p>
          <label for="email">E-mail :</label>
          <input type="text" name="email" id="email" autocomplete="off">
        </p>
        <p>
          <label for="email-2">Confirmation de l'E-mail :</label>
          <input type="text" name="email-2" id="email-2" autocomplete="off">
        </p>
        <p>
          <label for="password">Mot de passe :</label>
          <input type="password" name="password" id="password" autocomplete="off">
        </p>
        <p>
          <label for="password-2">Confirmation du mot de passe :</label>
          <input type="password" name="password-2" id="password-2" autocomplete="off">
        </p>
        <input type="submit" name="submit">
      </form>
    </div>
    <button>Retour</button>
  </main>
  <script type="text/javascript" src="../../backoffice/scripts/jquery-3.4.1.js"></script>
  <script type="text/javascript" src="../../backoffice/scripts/script.js"></script>
</body>
</html>
