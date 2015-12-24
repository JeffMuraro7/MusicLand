<?php
    /* ------------------------------------------------------------------------------
    Projet : MusicLand
    Fichier : deconnexion.php
    Description : Page pour la deconnexion au site
    Auteur : Jeff Muraro | Nicolas Bertrand
    Version : PC / 0.1 / Codage initial
    ------------------------------------------------------------------------------ */

    // On démarre la session
    session_start ();

    // On détruit les variables de notre session
    session_unset ();

    // On détruit notre session
    session_destroy ();

    // On redirige le visiteur vers la page d'accueil
    header ('location: ../index.php');

?>
