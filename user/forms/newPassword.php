<?php

function createNewPass($length){

  $chaine = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $newPass = "";
  for($i=0;$i<$length;$i++){
    $newPass = $newPass . $chaine[rand(0,strlen($chaine)-1)];
  }
  return $newPass;
}

?>
