<?php
  require_once 'connexion_bd.php';
  function login($username, $pass) {
    $request = getDb()->prepare("SELECT pseudo, MDP, Statut FROM user WHERE pseudo = :pseudo AND MDP = SHA1(:pass)");
    $request->bindParam(':pseudo', $username);
    $request->bindParam(':pass', $pass);
    $request->execute();
    return $request->fetch(PDO::FETCH_ASSOC);
  }

  function recuperer_nom_album_par_artiste($nomArtiste)
  {
    $request = getDb()->prepare("SELECT NomAlbum, IdAlbum FROM album WHERE NomArtiste = :nom");
    $request->bindParam(':nom', $nomArtiste);
    $request->execute();
    return $request->fetchAll(PDO::FETCH_ASSOC);
  }
