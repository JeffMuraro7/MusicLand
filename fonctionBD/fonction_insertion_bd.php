<?php
require_once 'connexion_bd.php';
function insertUser($lastname, $pseudo, $pass, $email) {
   try{
      $request = getDb()->prepare("INSERT INTO `".DB_NAME."`.`user` (`IdUser`, `Nom`, `Pseudo`, `MDP`, `Email`, `statut`) VALUES (NULL, :lastname, :pseudo, SHA1(:pass), :email, 0)");
      $request->bindParam(':lastname', $lastname, PDO::PARAM_STR);
      $request->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
      $request->bindParam(':pass', $pass, PDO::PARAM_STR);
      $request->bindParam(':email', $email, PDO::PARAM_STR);
      return $request->execute();
  }
  catch (PDOException $e) {
      return false;
  }
}

function insertion_album($nomAlbum, $nomArtiste, $dateParution, $pochette, $idStyle) {
    try {
        $request = getDb()->prepare("INSERT INTO `".DB_NAME."`.`album` (`IdAlbum`, `NomAlbum`, `NomArtiste`, `Pochette`, `IdStyle` , `DateParution`) VALUES (NULL, :nomAlbum, :nomArtiste, :pochette, :idStyle, :dateParution)");
        $request->bindParam(':nomAlbum', $nomAlbum, PDO::PARAM_STR);
        $request->bindParam(':nomArtiste', $nomArtiste, PDO::PARAM_STR);
        $request->bindParam(':dateParution', $dateParution, PDO::PARAM_STR);
        $request->bindParam(':pochette', $pochette, PDO::PARAM_STR);
        $request->bindParam(':idStyle', $idStyle, PDO::PARAM_INT);
        return $request->execute();
    } catch (PDOException $ex) {
        return $ex;
    }
}

function insertion_musique($titre, $chemin, $idAlbum)
{
   try{
     getDb()->beginTransaction();
     $request = getDb()->prepare("INSERT INTO `".DB_NAME."`.`musique` (`IdMusique`, `Titre`, `Piste`, `IdAlbum`) VALUES (NULL, :titre, :piste, :idAlbum);");
     $request->bindParam(':titre', $titre, PDO::PARAM_STR);
     $request->bindParam(':piste', $chemin, PDO::PARAM_STR);
     $request->bindParam(':idAlbum', $idAlbum, PDO::PARAM_STR);
     $request->execute();

     getDb()->commit();
   }
   catch(PDOException $ex) {
     getDb()->rollback();
      return $ex;
   }
}
