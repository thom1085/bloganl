<?php

// CE CODE EST CHARGE SUR TOUTES LES PAGES DE MON SITE

// VARIABLE GLOBALE
$tabError      = [];
$tabColonneInfo = [];
   
    //global variables
    $databaseDB = "sql1";
    $loginDB    = "root";
    $passwordDB = "";
    $serveurDB  = "localhost";
    $charsetDB  = "utf8";
    $authorMail = "contact@mysite.com";
    $replyToMail= "contact@mysite.com";
    

// AFFICHAGE DES ERREURS 
// http://php.net/manual/en/function.error-reporting.php
error_reporting(E_ALL);

// DECLARER MES FONCTIONS
require_once("private/functions.php");

