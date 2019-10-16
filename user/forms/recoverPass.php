<?php require_once "../../connection.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
  <div>
    <form action="recoverPass.php" method="POST">
      <p>
        <label>Adresse e-mail du compte : </label>
        <input type="text" name="mail" id="mail">
      </p>
      <input type="submit" name="submit" value="Confirmer">
    </form>
    <button id="returnConnect">Retour</button>
  </div>

  <script type="text/javascript" src="../../backoffice/scripts/jquery-3.4.1.js"></script>
  <script type="text/javascript" src="../../backoffice/scripts/script.js"></script>
</body>

</html>
