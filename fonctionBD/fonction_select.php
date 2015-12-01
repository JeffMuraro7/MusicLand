<?php 
    require_once 'connexion_bd.php';

    function getStyle() {
        try{
            $request = getDb()->prepare("SELECT * FROM style");
            $request->execute();
            return $request->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            return false;
        }
    }
