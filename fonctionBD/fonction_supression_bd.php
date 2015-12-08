<?php
  require_once 'connexion_bd.php';

  function supprimer_musique($idMusique)
  {
    $request = getDb()->prepare("DELETE FROM ".DB_NAME.".musique WHERE `musique`.`IdMusique` = :idMusique");
    $request->bindParam(':idMusique', $idMusique, PDO::PARAM_INT);
    $request->execute();
  }
