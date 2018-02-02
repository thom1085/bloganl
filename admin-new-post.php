<?php

// CHARGER LE CODE COMMUN A TOUTES LES PAGES
require_once("private/setup.php");

// DEBUG
// ALLER CHERCHER LES INFOS DE SESSION
session_start();

// print_r($_SESSION);

// CETTE PAGE DOIT SEULEMENT ETRE ACCESSIBLE
// AUX VISITEURS DE NIVEAU >= 1
$niveau = readsessions("level");

if ($niveau >= 9)
{
    // AFFICHER LA PAGE
    require_once("private/view/header.php");
    require_once("private/view/admin-section-blog.php");
    require_once("private/view/footer.php");

}
else
{
    // REDIRIGER AUTOMATIQUE VERS LA PAGE DE login.php
    // http://php.net/manual/fr/function.header.php
    header("Location: admin.php");

    // ERREUR
    // BLOQUER L'ACCES
    echo "ACCES PROTEGE";
}
