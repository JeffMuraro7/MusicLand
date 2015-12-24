<?php
  session_start();
  if(!isset($_SESSION['nom']))
  {
    echo '<script language="Javascript">
    alert("Vous devez vous connecter pour accéder à cette page")
    </script>';
    header('Location: ./index.php');
    exit();
  }
  require_once './fonctionBD/fonction_lecture_bd.php';
  require_once './fonctionBD/fonction_insertion_bd.php';
  $nom = isset($_REQUEST['nomMusique']) ? $_REQUEST['nomMusique'] : "";
  $nomAlbums = recuperer_nom_album_par_artiste($_SESSION['nom']);

  $erreur = "";
  $succes = "";

  if(count($nomAlbums) == 0)
  {
    echo '<script language="Javascript">
    alert ("Vous devez d\'abord créer un album" )
    </script>';
    header('Location: ./form_upload_album.php');
    exit();
  }
  if(isset($_REQUEST['boutonEnvoyer']))
   {
     $nomAlbumChoisi = recuperer_nom_album_et_artiste_par_id($_REQUEST['nomAlbum']); //get the name for create a folder fo each album
     $target_dir = "./music/".$_SESSION['nom']."/".$nomAlbumChoisi['NomAlbum']."/"; //path for the file
     $target_file = $target_dir.$_FILES["musique"]["name"]; //get the name and the extension of the file
     $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION); //get the extension of the file
     $newNameFile = $_REQUEST['nomMusique'].".".$imageFileType; //the new name with the extension
     $uploadOk = 1;

      // Check if file already exists
      if (file_exists($target_file)) {
          $erreur = 'Le fichier existe déjà.';
      }
      else {
        if(!file_exists("./music/".$_SESSION['nom']."/"))
        {
          mkdir("./music/".$_SESSION['nom']."/");
        }
        if(!file_exists($target_dir))
        {
          mkdir($target_dir);
        }
        // Allow certain file formats
        if($imageFileType != "wav" && $imageFileType != "mp3")
       {
            $erreur = "Désolé, seul les formats mp3 et wav sont acceptés.";
            $uploadOk = 0;
        }
      }
      if (move_uploaded_file($_FILES["musique"]["tmp_name"], $target_file)) {
          $succes = "Le fichier ". basename( $_FILES["musique"]["name"]). " a bien été envoyé.";
          rename($target_file, $target_dir.$newNameFile);
          insertion_musique( $_REQUEST['nomMusique'], $target_dir.$newNameFile, $_REQUEST['nomAlbum']);
      } else {
          $erreur = "Désolé, il y a eut une erreur lors de l'envoi de la musique.";
      }

   }

 ?>
<html>
    <head>
        <!-- Début des feuilles de styles -->
        <link href="StyleCSS/myStyle.css" rel="stylesheet" type="text/css"/>
        <link href="StyleCSS/myFont.css" rel="stylesheet" type="text/css"/>
        <link href="StyleCSS/myInscription.css" rel="stylesheet" type="text/css"/>
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
                if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {
                  echo '<li><a href="admin.php">Administration</a></li><li><a href="./fonctionBD/deconnexion.php">Déconnexion</a></li>';
                } else {
                  echo '<li><a href="./fonctionBD/deconnexion.php">Déconnexion</a></li>';
                }
              ?>
            </ul>
        </nav>

        <!-- Bloc pour le contenu du site -->
        <section>
            <article class="form">
                <form method="post" action="#"  enctype="multipart/form-data">
                    <fieldset class="fieldset">
                       <legend> Ajouter une musique </legend>
                       <label for="nom">Votre nom de la musique : </label><input type="text" name="nomMusique" id="nom" maxlength="50" required value="<?= $nom ?>"/> <br />
                       <label for="nomAlbum">Votre Album : </label> <select name="nomAlbum" required>
                      <?php
                       foreach ($nomAlbums as $value) {
                          echo "<option value=\"".$value['IdAlbum']."\">".$value['NomAlbum']."</option>";
                       }
                       ?>
                      </select>
                      <label for="musique">Télécharger votre musique :</label><input name="musique" id="image" type=file accept="audio/wav, audio/mp3"><br />
                      <?php
                        if(!empty($succes)) {
                          echo $succes;
                        } else {
                          if(!empty($erreur)) {
                            echo $erreur;
                          }
                        }
                       ?>
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
