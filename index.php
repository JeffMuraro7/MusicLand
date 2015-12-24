<?php
  session_start();
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
        <title>Music'Land | Accueil</title>
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
                    echo '<li><a href="connexion.php?deco=oui">Déconnexion</a></li>';
                  }
                ?>
            </ul>
        </nav>

        <!-- Bloc pour le contenu du site -->
        <section>
            <article>
                Bienvenue sur Music'Land. Un site ou il est répertorié des musiques libre de droits que vous pourrez écouter.
            </article>
        </section>

        <!-- Bloc pour le pied de page -->
        <footer>
            &copy; Nicolas Bertrand & Jeff Muraro
        </footer>

    </body>
</html>
