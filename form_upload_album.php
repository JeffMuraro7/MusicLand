<?php
  
?>
<!DOCTYPE html>
<!--
    Crée le     : 24 nov. 2015, 09:00
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
        <link href="StyleCSS/myUploadAlbum.css" rel="stylesheet" type="text/css"/>
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
                <li><a href="#">Musique</a></li>
                <?php
                  if(!isset($_SESSION['nom']))
                  {
                    echo '<li><a href="inscription.php">Inscription</a></li><li><a href="connexion.php">Connexion</a></li>';
                  }
                  else
                  {
                    echo '<li><a href="connexion.php?deco=oui">Déconnexion</a></li>'; //TODO Faire déco
                  }
                ?>
            </ul>
        </nav>

        <!-- Bloc pour le contenu du site -->
        <section>
            <article class="form">
                <form method="post" action="form_upload_album.php">
                     <fieldset class="fieldset">
                        <legend> Ajout d'album </legend>
                        <label for="nomAlbum">Nom de l'album : </label><input type="text" name="nomAlbum" id="nomAlbum" maxlength="50" required value=""/> <br />
                        <label for="nomArtiste">Artiste de l'album : </label><input type="text" name="nomArtiste" id="nomArtiste" maxlength="50" required value=""/> <br />
                        <label for="dateParution">Date de parution de l'album : </label><input type="date" name="dateParution" id="dateParution" maxlength="50" required value=""/> <br />
                        <label for="pochette">Pochette de l'album : </label><input type="file" name="pochette" id="pochette" maxlength="50" accept=".jpg, .png, .jpeg, .gif" required value=""/> <br />
                        
                        <input type="submit" value="Envoyer" name="boutonEnvoyer"/>
                     </fieldset>
                 </form>
             </article>
        </section>

        <!-- Bloc pour le pied de page -->
        <footer>
            &copy; Nicolas Bertrand & Jeff Muraro
        </footer>

    </body>
</html>


