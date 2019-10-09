<?php require_once "../connection.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="style/style.css">
</head>
<body>
  <form action="forms/register.php" method="POST">
    <input type="submit" name="register" value="S'inscrire">
  </form>
  <form action="forms/connect.php" method="POST">
    <input type="submit" name="connect" value="Se connecter">
  </form>
</body>
</html>
