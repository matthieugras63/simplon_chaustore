<?php require_once '../connection.php' ?>
<?php session_start();  ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Simplon Chaustore</title>
  <link rel="stylesheet" type="text/css" href="styles/style.css">
  <link rel="shortcut icon" href="#">
</head>

<body>
  <header>
    <h1>Gestion de la boutique</h1>
  </header>
  <main>
    <section id="DBAdmin" class="accessDB" >
      <h2>Sélectionnez un champs</h2>
      <?php require 'menu.php' ?>
      <h3>Que souhaitez-vous faire ?</h3>
      <div>
        <div>
          <div>
            <button>Visualiser</button>
          </div>
          <span> Permet de visualiser les données présentes dans la base de données</span>
        </div>
        <div>
          <div>
            <button>Ajouter</button>
          </div>
          <span>Permet d'ajouter de nouvelles entrées dans la base de données</span>
        </div>
        <div>
          <div>
            <button>Modifier</button>
          </div>
          <span>Permet de modifier des entrées dans la base de données</span>
        </div>
        <div>
          <div>
            <button id="delete">Supprimer</button>
          </div>
          <span>Permet de supprimer des données dans la base de données</span>
        </div>
      </div>
    </section>
  </main>
  <div id="container">
    <div id="modal_container">
      <div id="modal">
        <button id="cross">
          <div></div>
          <div></div>
        </button>
        <h4></h4>
        <?php require_once 'visualize.php' ?>


      </div>
    </div>
  </div>


  <script type="text/javascript" src="scripts/jquery-3.4.1.js"></script>
  <script type="text/javascript" src="scripts/script.js"></script>
</body>

</html>


