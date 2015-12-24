<?php
  session_start();
  if(empty($_SESSION['nom']) || $_SESSION['isAdmin'] != 1) //Vérification si l'utilisateur est connté et administrateur
  {
      session_write_close();
      header('Location: ./index.php');
      exit();
  }
  include_once './fonctionBD/fonction_lecture_bd.php';
  include_once './fonctionBD/fonction_modification.php';
  include_once './fonctionBD/fonction_supression_bd.php';

  function recuperer_titre_nom_valider()
  {
     $titre = recuperer_album_non_valide();
     if(count($titre) > 0) //Si il y a des titres à valider
     {
       $html = "<table><tr><th>Nom de la musique</th><th>Validation</th></tr>";
       foreach ($titre as  $value) {
            $html .= "<tr><td>".$value['Titre']."<td>";
            $html .= "<td><button name=\"buttonValidation\" Onclick=\"window.location.href='admin.php?validation=".$value['IdMusique']."'\">Validation</button></td>";
            $html .= "<td><button name=\"buttonSupression\" Onclick=\"window.location.href='admin.php?supression=".$value['IdMusique']."'\">Supression</button></td></tr>";
       }
       $html .= "</table>";
     }
     else {
       $html = "<h2>Pas de titre à valider</h2>";
     }
     return $html;
  }

  if(isset($_REQUEST['validation']) && is_numeric($_REQUEST['validation']))
  {
       validation_chanson($_REQUEST['validation']);
  }
  if(isset($_REQUEST['supression']) && is_numeric($_REQUEST['supression']))
  {
     $musique = recuperer_musique_par_id($_REQUEST['supression']);
     if($musique != false) //Si la musique que l'on veut supprimer existe vraiment
     {
        if(unlink($musique['Piste'])) //Si on arrive à supprimer le fichier
        {
           supprimer_musique($musique['IdMusique']);
        }
        else {
          echo "<h2>Une erreur est survenue lors de la supression</h2>";
        }

        echo "<h2>La musique à bien été supprimée</h2>";
     }
      else {
        echo "<h2>Cette musique n'existe pas.</h2>";
      }
  }
?>
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
                  if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {
                    echo "<li><a href='admin.php'>Administration</a></li>";
                  }
                ?>
                <li><a href="./fonctionBD/deconnexion.php">Déconnexion</a></li>
            </ul>
        </nav>

        <!-- Bloc pour le contenu du site -->
        <section>
            <article>
                <h1>Validation de la musique</h1>
                <?php echo recuperer_titre_nom_valider(); ?>
            </article>

            <article>
                Article n°2
            </article>

            <article>
                Article n°3
            </article>
        </section>

        <!-- Bloc pour le pied de page -->
        <footer>
            &copy; Nicolas Bertrand & Jeff Muraro
        </footer>

    </body>
</html>
