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
  $nom = isset($_REQUEST['nomMusique']) ? $_REQUEST['nomMusique'] : "";
  var_dump($_SESSION['nom']);
  $nomAlbums = recuperer_nom_album_par_artiste($_SESSION['nom']);
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
     $target_dir = "./music/".$_SESSION['nom']."/";
     $target_file = $target_dir . basename($_FILES["musique"]["name"]);
     $uploadOk = 1;
     $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
     // Check if image file is a actual image or fake image
     if(!preg_match("\baudio/",$_FILES['image']['mime_type'])) {
         $uploadOk = 0;
     }
      // Check if file already exists
      if (file_exists($target_file)) {
          $uploadOk = 0;
      }
      // Check file size
      if ($_FILES["musique"]["size"] > 500000000) {
          echo "Sorry, your file is too large.";
          $uploadOk = 0;
      }
      // Allow certain file formats
      if($imageFileType != "wav" && $imageFileType != "mp3")
     {
          echo "Désolé, seul les formats mp3 et wav sont acceptés.";
          $uploadOk = 0;
      }
      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
          echo "Sorry, your file was not uploaded.";
      // if everything is ok, try to upload file
    } else if(!file_exists($target_file)){
          if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
              echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
              //TODO : insertion dans base de données
              //insertUser( $_REQUEST['nom'], $_REQUEST['prenom'], $_REQUEST['email'], $_REQUEST['date'], $_REQUEST['telephone'], $target_dir.$_FILES['image']['name']);
          } else {
              echo "Sorry, there was an error uploading your file.";
          }
      }
      else {
        echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
        insertUser( $_REQUEST['nom'], $_REQUEST['prenom'], $_REQUEST['email'], $_REQUEST['date'], $_REQUEST['telephone'], $target_dir.$_FILES['image']['name']);
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
                <li><a href="#">Musique</a></li>
            </ul>
        </nav>

        <!-- Bloc pour le contenu du site -->
        <section>
            <article class="form">
                <form method="post" action="#">
                    <fieldset class="fieldset">
                       <legend> Inscription </legend>
                       <label for="nom">Votre nom de la musique : </label><input type="text" name="nomMusique" id="nom" maxlength="50" required value="<?= $nom ?>"/> <br />
                       <label for="nomAlbum">Votre Album : </label> <select name="nomAlbum" required>
                      <?php
                       foreach ($nomAlbums as $value) {
                          echo "<option value=\"".$value['IdAlbum']."\">".$value['NomAlbum']."</option>";
                       }
                       ?>
                      </select>
                      <label for="musique">Télécharger votre avatar:</label> : <input name="musique" id="image" type=file accept="audio/wav, audio/mp3"><br />
                       <input type="submit" value="Envoyer" name="boutonEnvoyer"/>
                    </fieldset>
                </form>
            </article>
        </section>

        <!-- Bloc pour le pied de page -->
        <footer>
            Pied de page
        </footer>

    </body>
</html>
