<?php
  DEFINE('DB_HOST', "127.0.0.1");
  DEFINE('DB_NAME', "music_land");
  DEFINE('DB_USER', "musicLand");
  DEFINE('DB_PASS', "SuperLand");
  function getDb() {
      static $dbb = null;
      if ($dbb === null) {
          try {
              $dbb = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . '', DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
              $dbb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          } catch (PDOException $e) {
              die('Erreur : ' . $e->getMessage());
          }
      }
      return $dbb;
    }
