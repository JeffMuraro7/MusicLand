<?php
  require_once 'connexion_bd.php';

  function validation_chanson($idChanson)
  {
    $request = getDb()->prepare("UPDATE `music_land`.`musique` SET `estValide` = '1' WHERE `musique`.`IdMusique` = :idMusique;");
    $request->bindParam(':idMusique', $idChanson, PDO::PARAM_INT);
    $request->execute();
  }
