<?php session_start()  ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

  <header>
    <nav>
      <ul>
        <li>Accueil</li>
        <?php if (!isset($_SESSION['id'])): ?>
          <li>Inscription</li>
          <li>Connexion</li>
        <?php else : ?>
          <li>Panier</li>
          <li>Déconnexion</li>
        <?php endif ?>
      </ul>
    </nav>
    <h1>Bienvenue sur la boutique Chaustore <?php if (isset($_SESSION['id'])) {echo" , ". $_SESSION['firstname'];} ?></h1>
  </header>

  <main>



  </main>

  <script type="text/javascript" src="../backoffice/scripts/jquery-3.4.1.js"></script>
  <script type="text/javascript" src="../backoffice/scripts/script.js"></script>
</body>
</html>
