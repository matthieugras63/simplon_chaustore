<div id="Visualiser" class="Produit">
  <h4>Voici les données actuellement enregistrées :</h4>
  <table>
    <thead>
      <tr>
        <?php
        $nomCol ="SELECT product.id AS article, product.name AS produit, category.name AS catégorie, brand.name AS marque, color.name AS couleur, price AS prix, image AS image, gender AS sexe FROM product INNER JOIN category ON product.category_id = category.id INNER JOIN brand ON product.brand_id = brand.id INNER JOIN color ON product.color_id = color.id ORDER BY product.name ASC;";
        $req = mysqli_query($conn, $nomCol);
        while ($result = mysqli_fetch_field($req)){
          ?>
          <th><?php echo $result->name; ?></th>
          <?php
        }
        ?>
      </tr>
    </thead>
    <tbody>

      <?php
      $preview = "SELECT product.id AS article, product.name AS produit, category.name AS catégorie, brand.name AS marque, color.name AS couleur, price AS prix,image AS image, gender AS sexe FROM product INNER JOIN category ON product.category_id = category.id INNER JOIN brand ON product.brand_id = brand.id INNER JOIN color ON product.color_id = color.id ORDER BY product.name ASC;";

      $req = mysqli_query($conn, $preview);
      while($result = mysqli_fetch_row($req)){
        for ($i=0; $i < count($result) ; $i+=8) {
         ?>

         <tr>

          <?php for ($j=0; $j < 8 ; $j++) { ?>
           <td><?php echo($result[$i+$j]); ?></td>
         <?php } ?>

       </tr>

       <?php
     }
   }
   ?>

 </tbody>
</table>
</div>




<div id="Visualiser" class="Catégorie">
  <h4>Voici les données actuellement enregistrées :</h4>
  <table>
    <thead>
      <tr>
        <?php
        $nomCol ="SELECT id as catégorie, name as intitulé FROM category";
        $req = mysqli_query($conn, $nomCol);
        while ($result = mysqli_fetch_field($req)){
          ?>
          <th><?php echo $result->name; ?></th>
          <?php
        }
        ?>
      </tr>
    </thead>
    <tbody>

      <?php
      $preview = "SELECT * FROM category ORDER BY id";

      $req = mysqli_query($conn, $preview);
      while($result = mysqli_fetch_row($req)){
        for ($i=0; $i < count($result) ; $i+=2) {
         ?>

         <tr>

          <?php for ($j=0; $j < 2 ; $j++) { ?>
           <td><?php echo($result[$i+$j]); ?></td>
         <?php } ?>

       </tr>

       <?php
     }
   }
   ?>

 </tbody>
</table>
</div>




<div id="Visualiser" class="Couleur">
  <h4>Voici les données actuellement enregistrées :</h4>
  <table>
    <thead>
      <tr>
        <?php
        $nomCol ="SELECT id as identifiant, name as couleur FROM color";
        $req = mysqli_query($conn, $nomCol);
        while ($result = mysqli_fetch_field($req)){
          ?>
          <th><?php echo $result->name; ?></th>
          <?php
        }
        ?>
      </tr>
    </thead>
    <tbody>

      <?php
      $preview = "SELECT * FROM color ORDER BY id";

      $req = mysqli_query($conn, $preview);
      while($result = mysqli_fetch_row($req)){
        for ($i=0; $i < count($result) ; $i+=2) {
         ?>

         <tr>

          <?php for ($j=0; $j < 2 ; $j++) { ?>
           <td><?php echo($result[$i+$j]); ?></td>
         <?php } ?>

       </tr>

       <?php
     }
   }
   ?>

 </tbody>
</table>
</div>









<div id="Visualiser" class="Stock">
  <h4>Voici les données actuellement enregistrées :</h4>
  <table>
    <thead>
      <tr>
        <?php
        $nomCol ="SELECT product.name AS article, size.name AS pointure, stock FROM stock INNER JOIN product ON stock.product_id = product.id INNER JOIN size ON stock.size_id = size.id ORDER BY product.id ASC;";
        $req = mysqli_query($conn, $nomCol);
        while ($result = mysqli_fetch_field($req)){
          ?>
          <th><?php echo $result->name; ?></th>
          <?php
        }
        ?>
      </tr>
    </thead>
    <tbody>

      <?php
      $preview = "SELECT product.name AS article, size.name AS pointure, stock FROM stock INNER JOIN product ON stock.product_id = product.id INNER JOIN size ON stock.size_id = size.id ORDER BY product.name ASC;";

      $req = mysqli_query($conn, $preview);
      while($result = mysqli_fetch_row($req)){
        for ($i=0; $i < count($result) ; $i+=3) {
         ?>

         <tr>

          <?php for ($j=0; $j < 3 ; $j++) { ?>
           <td><?php echo($result[$i+$j]); ?></td>
         <?php } ?>

       </tr>

       <?php
     }
   }
   ?>

 </tbody>
</table>
</div>










<div id="Visualiser" class="Marque">
  <h4>Voici les données actuellement enregistrées :</h4>
  <table>
    <thead>
      <tr>
        <?php
        $nomCol ="SELECT id as identifiant, name as marque FROM brand";
        $req = mysqli_query($conn, $nomCol);
        while ($result = mysqli_fetch_field($req)){
          ?>
          <th><?php echo $result->name; ?></th>
          <?php
        }
        ?>
      </tr>
    </thead>
    <tbody>

      <?php
      $preview = "SELECT id,name FROM brand ORDER BY id";

      $req = mysqli_query($conn, $preview);
      while($result = mysqli_fetch_row($req)){
        for ($i=0; $i < count($result) ; $i+=2) {
         ?>

         <tr>

          <?php for ($j=0; $j < 2 ; $j++) { ?>
           <td><?php echo($result[$i+$j]); ?></td>
         <?php } ?>

       </tr>

       <?php
     }
   }
   ?>

 </tbody>
</table>
</div>











<div id="Visualiser" class="Pointure">
  <h4>Voici les données actuellement enregistrées :</h4>
  <table>
    <thead>
      <tr>
        <?php
        $nomCol ="SELECT id as identifiant, name as pointure FROM size";
        $req = mysqli_query($conn, $nomCol);
        while ($result = mysqli_fetch_field($req)){
          ?>
          <th><?php echo $result->name; ?></th>
          <?php
        }
        ?>
      </tr>
    </thead>
    <tbody>

      <?php
      $preview = "SELECT * FROM size ORDER BY id";

      $req = mysqli_query($conn, $preview);
      while($result = mysqli_fetch_row($req)){
        for ($i=0; $i < count($result) ; $i+=2) {
         ?>

         <tr>

          <?php for ($j=0; $j < 2 ; $j++) { ?>
           <td><?php echo($result[$i+$j]); ?></td>
         <?php } ?>

       </tr>

       <?php
     }
   }
   ?>

 </tbody>
</table>
</div>
