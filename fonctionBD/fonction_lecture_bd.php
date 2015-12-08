<?php
  require_once 'connexion_bd.php';
  function login($username, $pass) {
    $request = getDb()->prepare("SELECT pseudo, MDP, Statut FROM user WHERE pseudo = :pseudo AND MDP = SHA1(:pass)");
    $request->bindParam(':pseudo', $username, PDO::PARAM_STR);
    $request->bindParam(':pass', $pass, PDO::PARAM_STR);
    $request->execute();
    return $request->fetch(PDO::FETCH_ASSOC);
  }

  function recuperer_nom_album_par_artiste($nomArtiste)
  {
    $request = getDb()->prepare("SELECT NomAlbum, IdAlbum FROM album WHERE NomArtiste = :nom");
    $request->bindParam(':nom', $nomArtiste, PDO::PARAM_STR);
    $request->execute();
    return $request->fetchAll(PDO::FETCH_ASSOC);
  }

  function recuperer_nom_album_par_id($idAlbum)
  {
    $request = getDb()->prepare("SELECT NomAlbum FROM album WHERE IdAlbum = :id");
    $request->bindParam(':id', $idAlbum, PDO::PARAM_INT);
    $request->execute();
    return $request->fetch(PDO::FETCH_ASSOC);
  }

  function recuperer_album_non_valide()
  {
    $query = 'SELECT IdMusique, Titre FROM musique WHERE estValide = 0';
    $answer = getDb()->query($query); //execute the query
    return $answer->fetchAll(PDO::FETCH_ASSOC); //We make the answer an associotive array
  }
