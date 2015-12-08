<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<html>
    <head>
        <!-- Début des feuilles de styles -->
        <link href="StyleCSS/myStyle.css" rel="stylesheet" type="text/css"/>
        <link href="StyleCSS/myFont.css" rel="stylesheet" type="text/css"/>
        <link href="StyleCSS/myUploadAlbum.css" rel="stylesheet" type="text/css"/>
        <link href="StyleCSS/styleLecteur.css" rel="stylesheet" type="text/css"/>
        <!-- Fin des feuilles de styles -->
        
        <!-- Script pour le lecteur audio -->
        <script src="jquery.js"></script>
        <script src="audioplayer.js"></script> 
        <!-- Fin des scripts du lecteur -->
        
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
            <article>
                <audio preload="auto" id="lecteurAudio" ontimeupdate="update(this)">
                    <source src="music/albatraoz.mp3" />
                </audio>
                
                <div>
                    <div id="barProgresControl">
                        <div id="barProgres"> Pas de lecture </div>
                    </div>
                </div>
                
                <button class="lecteurControle" onclick="play('lecteurAudio', this)"> Play </button>
                <button class="lecteurControle" onclick="resume('lecteurAudio')"> Stop </button>
                <span class="volume">
                    <a class="stick1" onclick="volume('lecteurAudio', 0)"></a>
                    <a class="stick2" onclick="volume('lecteurAudio', 0.3)"></a>
                    <a class="stick3" onclick="volume('lecteurAudio', 0.5)"></a>
                    <a class="stick4" onclick="volume('lecteurAudio', 0.7)"></a>
                    <a class="stick5" onclick="volume('lecteurAudio', 1)"></a>
                </span>
            </article>
        </section>

        <script>
            
            function play(idLecteur, controle) {
                var lecteur = document.querySelector('#' + idLecteur);
                
                if(lecteur.paused) {
                    lecteur.play();
                    controle.textContent = 'Pause';
                } else {
                    lecteur.pause();
                    controle.textContent = 'Play';
                }
            }
            
            function resume(idLecteur) {
                var lecteur = document.querySelector('#' + idLecteur);
                
                lecteur.currentTime = 0;
                lecteur.pause();
            }
            
            function volume(idLecteur, vol) {
                var lecteur = document.querySelector('#' + idLecteur);
                
                lecteur.volume = vol;
            }
            
            function update(lecteur) {
                var duree = lecteur.duration;    // Durée totale de la musique
                var temps = lecteur.currentTime; // Temps écoulé du morceau
                var fraction = temps / duree;
                var percent = Math.ceil(fraction * 100);
                
                var progres = document.querySelector('#barProgres');
                
                progres.style.width = percent + '%';
                progres.textContent = percent + '%';
            }
            
            function formatTemps(temps) {
                var heures = Math.floor(temps / 3600);
                var minutes = Math.floor((temps % 3600) / 60);
                var secondes = Math.floor((temps % 60));
            }
//            var lecteur = document.querySelector('#lecteurAudio');
//            
//            //Méthode pour mettre play
//            lecteur.play();
//            
//            //Méthode pour mettre pause
//            lecteur.pause();
//            
//            //Méthode pour stoper la lecteur audio (pause puis mise au début de la piste audio).
//            lecteur.pause();
//            lecteur.currentTime = 0;
            
            
            
        </script>
        
        <!-- Bloc pour le pied de page -->
        <footer>
            &copy; Nicolas Bertrand & Jeff Muraro
        </footer>

    </body>
</html>