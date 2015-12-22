<?php
      include_once './fonctionBD/fonction_lecture_bd.php';

      $limite = 3; //limite de musique que l'on souhaite si on les veux toute mettre 0
      $tableau_musique = recuperer_musique($limite);
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
<!--        <script src="jquery.js"></script>
        <script src="lecteurAudio.js"></script> -->
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
            if (!isset($_SESSION['nom'])) {
                echo '<li><a href="inscription.php">Inscription</a></li><li><a href="connexion.php">Connexion</a></li>';
            } else {
                echo '<li><a href="connexion.php?deco=oui">Déconnexion</a></li>'; //TODO Faire déco
            }
        ?>
            </ul>
        </nav>

        <!-- Bloc pour le contenu du site -->
        <section>
           <?php
                 foreach ($tableau_musique as $musique) {
                   $nomAlbum = recuperer_nom_album_et_artiste_par_id($musique['IdAlbum']);
                   echo '
                   <article>
                       <figure id="'.$musique["Titre"].'fig'.'" itemprop="track" itemscope itemtype="http://schema.org/MusicRecording">
                           <figcaption>
                               <div>Titre<span itemprop="name">'.$musique["Titre"].'</span></div>
                               <div id="album">Album<span itemprop="inAlbum">'.$nomAlbum["NomAlbum"].'</span></div>
                               <div id="artist">Artist<span itemprop="byArtist">'.$nomAlbum["NomArtiste"].'</span></div>
                               <div id="time">Temps<span id="playbacktime'.$musique["Titre"].'">00:00</span></div>
                           </figcaption>
                           <meta itemprop="duration" content="PT2M29S">
                           <div id="fader'.$musique["Titre"].'"></div>
                           <div id="playback'.$musique["Titre"].'"></div>
                           <audio controls src="'.$musique["Piste"].'" id="'.$musique["Titre"].'" class="lecteurAudio" preload="auto" itemprop="audio"></audio>
                       </figure>
                   </article>';
                 } ?>
        </section>

        <!-- Script pour le lecteur audio -->
        <script>
            // Fonction pour le bouton play.
            function player() {
                if (pisteAudio.paused) {
                    setText(this, "Pause");
                    pisteAudio.play();
                } else {
                    setText(this, "Play");
                    pisteAudio.pause();
                }
            }

            // Fonction pour associer un texte à un élément.
            function setText(el, text) {
                el.innerHTML = text;
            }

            // Fonction pour la fin de la musique.
            function finish() {
                pisteAudio.currentTime = 0;
                setText(playButton, "Play");
            }

            function updatePlayhead(lecteur) {
                playhead.value = lecteur.currentTime;
                var s = parseInt(lecteur.currentTime % 60);
                var m = parseInt((lecteur.currentTime / 60) % 60);
                s = (s >= 10) ? s : "0" + s;
                m = (m >= 10) ? m : "0" + m;
                playbacktime.innerHTML = m + ':' + s;
            }

            // Fonction pour la gestion du texte du volume.
            function volume(lecteur) {
                if (lecteur.volume == 0) {
                    setText(muetBoutton, "Muet");
                }
                else {
                    setText(muetBoutton, "Volume");
                }
            }

            function muet(lecteur) {
                if (lecteur.volume == 0) {
                    lecteur.volume = restoreValue;
                    slideVolume.value = restoreValue;
                } else {
                    lecteur.volume = 0;
                    restoreValue = slideVolume.value;
                    slideVolume.value = 0;
                }
            }

            function setAttributes(el, attrs) {
                for (var key in attrs) {
                    el.setAttribute(key, attrs[key]);
                }
            }

            var tableau_musique = document.getElementsByClassName('lecteurAudio');
            var tableau_lecteur = {}; //TODO : tableau vide...
            for (var tab in tableau_musique) {
              var lecteurAudio = document.getElementById(tab + "fig"),
                      fader = document.getElementById("fader" + tab),
                      playback = document.getElementById("playback" + tab),
                      pisteAudio = document.getElementById(tab),
                      playbackTime = document.getElementById("playbacktime" + tab),
                      playButton = document.createElement("buttonPlay" + tab),
                      muetBoutton = document.createElement("buttonMuet" + tab),
                      playhead = document.createElement("progress" + tab),
                      slideVolume = document.createElement("input" + tab),
                      duration = pisteAudio.duration;
              tableau_lecteur[tab] = lecteurAudio;

            }

            console.log(tableau_lecteur);

            // Insertion du texte pour le bouton play et pour le volume.
            setText(playButton, "Play");
            setText(muetBoutton, "Volume");

            // Attribution des différents attributs
            setAttributes(playButton, {"type": "button", "class": "ss-icon"});
            setAttributes(muetBoutton, {"type": "button", "class": "ss-icon"});
            setAttributes(slideVolume, {"type": "range", "min": "0", "max": "1", "step": "any", "value": "1", "orient": "vertical", "id": "slideVolume"});
            setAttributes(playhead, {"min": "0", "max": "100", "value": "0", "id": "playhead"});

            muetBoutton.style.display = "block";
            muetBoutton.style.margin = "0 auto";

            fader.appendChild(slideVolume);
            fader.appendChild(muetBoutton);
            playback.appendChild(playButton);
            playback.appendChild(playhead);

            // Retrait des attributs de base du lecteur audio html5
            pisteAudio.removeAttribute("controls");

            // Ajout des événements pour les éléments
            playButton.addEventListener("click", player, false);

            muetBoutton.addEventListener("click", muet, false);

            slideVolume.addEventListener("input", function () {
                pisteAudio.volume = slideVolume.value;
            }, false);

            pisteAudio.addEventListener('volumechange', volume, false);

            pisteAudio.addEventListener('playing', function () {
                playhead.max = pisteAudio.duration;
            }, false);

            pisteAudio.addEventListener('timeupdate', updatePlayhead, false);

            pisteAudio.addEventListener('ended', finish, false);

        </script>

        <!-- Bloc pour le pied de page -->
        <footer>
            &copy; Nicolas Bertrand & Jeff Muraro
        </footer>

    </body>
</html>
