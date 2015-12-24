<?php
/* ------------------------------------------------------------------------------
Projet : MusicLand
Fichier : inscription.php
Description : Page pour l'inscription au site
Auteur : Jeff Muraro | Nicolas Bertrand
Version : PC / 0.1 / Codage initial
------------------------------------------------------------------------------ */

    session_start();

    if(isset($_SESSION['nom'])) {
      header('Location: ./index.php');
      exit();
    }

   $nom = isset($_REQUEST['nom']) ? $_REQUEST['nom'] : "";
   $pseudo = isset($_REQUEST['pseudo']) ? $_REQUEST['pseudo'] : "";
   $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : "";
   $pass = isset($_REQUEST['pass']) ? $_REQUEST['pass'] : "";
   $passconf = isset($_REQUEST['passconf']) ? $_REQUEST['passconf'] : "";


   $succes = "";
   $erreur = "";

   if(isset($_REQUEST['boutonEnvoyer']))
   {
      require_once './fonctionBD/fonction_insertion_bd.php';

      if(isset($_REQUEST['pass']) && isset($_REQUEST['passconf']) && $_REQUEST['pass'] == $_REQUEST['passconf']) {
        $inscription = insertUser($_REQUEST['nom'], $_REQUEST['pseudo'], $_REQUEST['pass'], $_REQUEST['email']);

        if($inscription != false) {
          $succes = "Votre inscription a été executée avec succès!";
        } else {
          $erreur = "Il y a eut un problème avec votre inscription!";
        }
      } else {
        $erreur = "Les mots de passe ne sont pas identiques!";
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
         <title>Music'Land | Inscription</title>
     </head>

     <script>
       function checkPass() //code venant de http://keithscode.com/tutorials/javascript/3-a-simple-javascript-password-validator.html
       {
           //Store the password field objects into variables ...
           var pass1 = document.getElementById('pass');
           var pass2 = document.getElementById('passconf');
           //Store the Confimation Message Object ...
           var message = document.getElementById('confirmMessage');
           //Set the colors we will be using ...
           var goodColor = "#66cc66";
           var badColor = "#ff6666";
           //Compare the values in the password field
           //and the confirmation field
           if(pass1.value == pass2.value){
               //The passwords match.
               //Set the color to the good color and inform
               //the user that they have entered the correct password
               pass2.style.backgroundColor = goodColor;
               message.style.color = goodColor;
               message.innerHTML = "Passwords Match!"
           }else{
               //The passwords do not match.
               //Set the color to the bad color and
               //notify the user.
               pass2.style.backgroundColor = badColor;
               message.style.color = badColor;
               message.innerHTML = "Passwords Do Not Match!"
           }
        }
     </script>

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
                 <li><a href="connexion.php">Connexion</a></li>
                 <li><a href="inscription.php">Inscription</a></li>
             </ul>
         </nav>

         <!-- Bloc pour le contenu du site -->
         <section>
             <article class="form">
                 <form method="post" action="inscription.php">
                     <fieldset class="fieldset">
                        <legend> Inscription </legend>
                        <label for="nom">Votre Nom : </label><input type="text" name="nom" id="nom" maxlength="50" required value="<?= $nom ?>"/> <br />
                        <label for="pseudo">Votre Pseudo : </label><input type="text" name="pseudo" id="pseudo" maxlength="50" value="<?= $pseudo ?>" required /> <br />
                        <label for="pass">Votre mot de passe :</label><input type="password" name="pass" id="pass" required /> <br />
                        <label for="passconf">Confirmer mot de passe :</label><input type="password" name="passconf" id="passconf" onkeyup="checkPass(); return false;" required /><span id="confirmMessage" class="confirmMessage"></span> <br />
                        <label for="email">Votre E-mail : </label><input type="email" name="email" id="email" maxlength="200" value="<?= $email ?>" required /> <br />

                        <?php
                          if(isset($succes)) {
                            echo $succes;
                          } else {
                            if(isset($erreur)) {
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
