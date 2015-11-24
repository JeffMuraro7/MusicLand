<?php
  $pseudo = isset($_REQUEST['pseudo']) ? $_REQUEST['pseudo'] : "";
  session_start();
  if(isset($_REQUEST['deco']) && $_REQUEST['deco'] == "oui")
  {
      session_destroy();
      session_write_close(); //ferme le fichier de session
      header('Location: ./index.php');
      exit();
  }
  if(isset($_REQUEST['boutonEnvoyer']))
  {
        require_once './fonctionBD/fonction_lecture_bd.php';
        $userlogin = login($_REQUEST['pseudo'], $_REQUEST['pass']);
        $nom = $_REQUEST['pseudo'];
        if ($userlogin != false) {
            $_SESSION['nom'] = $userlogin['pseudo'];
            $_SESSION['isAdmin'] = $userlogin['Statut'];
            header('Location: ./index.php');
            exit();
        }
  }
?>
<html>
    <head>
        <!-- Début des feuilles de styles -->
        <link href="StyleCSS/myStyle.css" rel="stylesheet" type="text/css"/>
         <link href="StyleCSS/myFont.css" rel="stylesheet" type="text/css"/>
         <link href="StyleCSS/myConnexion.css" rel="stylesheet" type="text/css"/>
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
                <li><a href="inscription.php">Inscription</a></li>
            </ul>
        </nav>

        <!-- Bloc pour le contenu du site -->
        <section>
            <article class="form">
                <form method="post" action="connexion.php">
                    <fieldset class="fieldset">
                        <legend> Connexion </legend>
                        <label for="pseudo">Votre Pseudo :</label><input type="text" name="pseudo" id="pseudo" maxlength="50" value="<?= $pseudo ?>" required /> <br />
                        <label for="pass">Votre mot de passe :</label><input type="password" name="pass" id="pass" required /> <br />
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
