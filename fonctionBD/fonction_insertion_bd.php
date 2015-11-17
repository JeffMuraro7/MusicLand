<?php
require_once 'connection_bd.php';
function insertUser($lastname, $pseudo, $pass, $email) {
   try{
      $request = getDb()->prepare("INSERT INTO ".DB_NAME.".`user` (`IdUser`, `Nom`, `Pseudo`, `MDP`, `Email`, `statut`) VALUES (NULL, :lastname, :pseudo, SHA1(:pass), :email, 0)");
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
