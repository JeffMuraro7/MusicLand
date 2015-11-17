<?php
  require_once 'connexion_bd.php';
  function login($username, $pass) {
    $request = getDb()->prepare("SELECT pseudo, MDP, Statut FROM user WHERE pseudo = :pseudo AND MDP = SHA1(:pass)");
    $request->bindParam(':pseudo', $username);
    $request->bindParam(':pass', $pass);
    $request->execute();
    return $request->fetch(PDO::FETCH_ASSOC);
  }
