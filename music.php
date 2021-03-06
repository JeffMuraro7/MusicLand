<?php
  session_start();
  require_once './fonctionBD/fonction_lecture_bd.php';
  $tableau_musique = recuperer_musique_valider(3); //On veut récupérer les trois prmière musiques
?>
<!DOCTYPE html>
<!--
    Crée le     : 1 nov. 2015, 08:56:15
    Auteur      : Jeff Muraro, Nicolas Bertrand
    Version     : v0.1
    Description : Music'Land est un projet qui se trouve dans le cadre du module m152. Nous sommes deux à travailler dessus.
                  Ainsi M. Bertrand et M. Muraro vont réaliser un site web qui regroupe des musiques pour en faire un site
                  de streaming tel que soundcloud.
-->


<html>
    <head>
        <!-- Début des feuilles de styles -->
        <link href="StyleCSS/myStyle.css" rel="stylesheet" type="text/css"/>
        <link href="StyleCSS/myFont.css" rel="stylesheet" type="text/css"/>
        <!-- Fin des feuilles de styles -->
        <meta charset="UTF-8">
        <title>Music'Land | Musique</title>
    </head>
    <body>

        <!-- Bloc pour l'en-tête -->
        <header>
            <img src="IMG/musicLandLogo.png" alt="Logo Music'Land" class="floatLeft" />
        </header>

        <!-- Bloc pour la navigation -->
        <nav class="clearfix">
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="music.php">Musique</a></li>
                <?php
                  if(!isset($_SESSION['nom']))
                  {
                    echo '<li><a href="connexion.php">Connexion</a></li><li><a href="inscription.php">Inscription</a></li>';
                  }
                  else
                  {
                    if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {
                      echo '<li><a href="admin.php">Administration</a></li><li><a href="./fonctionBD/deconnexion.php">Déconnexion</a></li>';
                    } else {
                      echo '<li><a href="./fonctionBD/deconnexion.php">Déconnexion</a></li>';
                    }
                  }
                ?>
            </ul>
        </nav>

        <!-- Bloc pour le contenu du site -->
        <section>

                <?php
                    if(isset($_SESSION['nom'])) {
                        echo '<article><a href="form_upload_album.php">Ajouter un album</a></br><a href="form_upload_music.php">Ajouter une musique</a></article>';
                    }

                    foreach ($tableau_musique as $value) { //Pour chaque musique son article
                       $nomAlbum = recuperer_nom_album_et_artiste_par_id($value['IdMusique']);
                       echo '<article>';
                       echo "<h2>".$value['Titre']."</h2>";
                       echo "<p> Nom de l'artiste : ".$nomAlbum["NomArtiste"]."</p>";
                       echo "<p> Nom de l'album :".$nomAlbum['NomAlbum']."</p>";
                       echo '<a href="lecteur.php?idMusique='.$value['IdMusique'].'">Ecouter la musique</a>';
                       echo "</article>";
                    }
                ?>
        </section>

        <!-- Bloc pour le pied de page -->
        <footer>
            &copy; Nicolas Bertrand & Jeff Muraro
        </footer>

    </body>
</html>
