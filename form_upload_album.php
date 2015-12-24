<?php
    session_start();

    if(!isset($_SESSION['nom']))
    {
        header('Location: ./index.php');
        exit();
    }

    require_once './fonctionBD/fonction_lecture_bd.php';
    require_once './fonctionBD/fonction_insertion_bd.php';

    $option = getStyle();

    if(isset($_REQUEST['boutonEnvoyer'])) {
        $target_dir = "./IMG/".$_SESSION['nom']."/".$_REQUEST['nomAlbum']."/";
        $target_file = $target_dir .$_FILES['pochette']['name']."/";
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        $newNameFile = $_REQUEST['nomAlbum'].".".$imageFileType;

        if(file_exists($target_file)) {
            echo 'Le fichier existe déjà!';
        } else {
            if(!file_exists("./IMG/".$_SESSION['nom'])) //Si le dossier le l'utilisateur n'existe pas
            {
              mkdir("./IMG/".$_SESSION['nom']); //fait le dossier
            }
            if(!file_exists($target_dir))
            {
              mkdir($target_dir);
            }

            if (move_uploaded_file($_FILES["pochette"]["tmp_name"], $target_file)) {
                echo "The file ". basename( $_FILES["pochette"]["name"]). " has been uploaded.";
                insertion_album($_REQUEST['nomAlbum'], $_SESSION['nom'], $_REQUEST['dateParution'], $target_file, $_REQUEST['style']); //TODO : Pas d'insertion dans la base
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }


    }
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
                <li><a href="index.php">Accueil</a></li>
                <li><a href="music.php">Musique</a></li>
                <li><a href="connexion.php?deco=oui">Déconnexion</a></li>
            </ul>
        </nav>

        <!-- Bloc pour le contenu du site -->
        <section>
            <article class="form">
                <form method="post" action="form_upload_album.php" enctype="multipart/form-data">
                     <fieldset class="fieldset">
                        <legend> Ajout d'album </legend>
                        <label for="nomAlbum">Nom de l'album : </label><input type="text" name="nomAlbum" id="nomAlbum" maxlength="50" required value=""/> <br />
                        <label for="dateParution">Date de parution de l'album : </label><input type="date" name="dateParution" id="dateParution" maxlength="50" required value=""/> <br />
                        <label for="pochette">Pochette de l'album : </label><input type="file" name="pochette" id="pochette" maxlength="50" accept=".jpg, .png, .jpeg, .gif" required value=""/> <br />
                        <label for="style">Style de l'album : </label>
                        <select name="style" id="style">
                            <?php
                                foreach ($option as $value) {
                                    echo "<option value='".$value['IdStyle']."'>".$value['Style']."</option>";
                                }
                            ?>
                        </select>

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
