<?php
      include_once './fonctionBD/fonction_lecture_bd.php';

      if(empty($_REQUEST['idMusique']))
      {
        header('Location: ./index.php');
        exit();
      }

      function getMusic($id)
      {
          global $lecteur;
          $tableau_musique = recuperer_musique($id);
          $nomAlbum = recuperer_nom_album_et_artiste_par_id($id);
          $lecteur = '<article>
              <figure id="lecteurAudio" itemprop="track" itemscope itemtype="http://schema.org/MusicRecording">
                  <figcaption>
                      <div>Titre<span itemprop="name">'.$tableau_musique["Titre"].'</span></div>
                      <div id="album">Album<span itemprop="inAlbum">'.$nomAlbum["NomAlbum"].'</span></div>
                      <div id="artist">Artist<span itemprop="byArtist">'.$nomAlbum["NomArtiste"].'</span></div>
                      <div id="time">Temps<span id="playbacktime">00:00</span></div>
                  </figcaption>
                  <meta itemprop="duration" content="PT2M29S">
                  <div id="fader"></div>
                  <div id="playback"></div>
                  <audio controls src="'.$tableau_musique["Piste"].'" id="pisteAudio" preload="auto" itemprop="audio"></audio>
              </figure>
          </article>';
          return $lecteur;
      }
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
           <?php echo getMusic($_REQUEST['idMusique']); ?>
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

            function updatePlayhead() {
                playhead.value = pisteAudio.currentTime;
                var s = parseInt(pisteAudio.currentTime % 60);
                var m = parseInt((pisteAudio.currentTime / 60) % 60);
                s = (s >= 10) ? s : "0" + s;
                m = (m >= 10) ? m : "0" + m;
                playbacktime.innerHTML = m + ':' + s;
            }

            // Fonction pour la gestion du texte du volume.
            function volume() {
                if (pisteAudio.volume == 0) {
                    setText(muetBoutton, "Muet");
                }
                else {
                    setText(muetBoutton, "Volume");
                }
            }

            function muet() {
                if (pisteAudio.volume == 0) {
                    pisteAudio.volume = restoreValue;
                    slideVolume.value = restoreValue;
                } else {
                    pisteAudio.volume = 0;
                    restoreValue = slideVolume.value;
                    slideVolume.value = 0;
                }
            }

            function setAttributes(el, attrs) {
                for (var key in attrs) {
                    el.setAttribute(key, attrs[key]);
                }
            }
            var lecteurAudio = document.getElementById("lecteurAudio"),
                      fader = document.getElementById("fader"),
                      playback = document.getElementById("playback"),
                      pisteAudio = document.getElementById("pisteAudio"),
                      playbackTime = document.getElementById("playbacktime"),
                      playButton = document.createElement("button"),
                      muetBoutton = document.createElement("button"),
                      playhead = document.createElement("progress"),
                      slideVolume = document.createElement("input"),
                      duration = pisteAudio.duration;

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
