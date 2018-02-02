
<?php

// DANS CE FICHIER
// ON VA CENTRALISER LA DECLARATION DES NOS FONCTIONS

// CE N'EST PAS OPTIMAL CAR ON VA DECLARER DES FONCTIONS 
// QU'ON NE VA PAS FORCEMENT UTILISER... :-/
// MAIS C'EST PLUS SIMPLE POUR NOUS
// (ET LES PERFORMANCES DE PHP RESTENT BONNES...)

// ET AVEC LA PROGRAMMATION ORIENTEE OBJET
// ON AURA UN AUTRE MOYEN POUR OPTIMISER LE CHARGEMENT DU CODE NECESSAIRE... ;-p

// INSERER UNE LIGNE DANS UNE TABLE SQL $nomTable 
// ET LES VALEURS SONT FOURNIES AVEC LE TABLEAU ASSOCIATIF $paramTabAsso
function insertLine ($nameTable, $paramTabAsso)
{
    $result = "";
 
    // JE FAIS UNE BOUCLE POUR PARCOURIR LE TABLEAU
    // POUR ACCEDER AUX CLES, JE SUIS OBLIGE DE CREER UNE VARIABLE POUR LES VALEURS
    // MEME SI JE N'EN AI PAS BESOIN
    $list1 = "";
    $list2 = "";
    foreach($paramTabAsso as $key => $value)
    {
        // JE RAJOUTE LA CLE AVEC UNE VIRGULE AVANT
        $list1 .= ", $key";
        $list2 .= ", :$key";
    }
    // IL FAUT ENLEVER LA VIRGULE EN TROP (AU DEBUT)
    // http://php.net/manual/fr/function.trim.php
    $list1 = trim($list1, ",");
    $list2 = trim($list2, ",");
    
    $result = "INSERT INTO $nameTable ( $list1 ) VALUES ( $list2 )";
    // => "INSERT INTO nomTable ( cle1, cle2, cle3, cle4 ) VALUES ( :cle1, :cle2, :cle3, :cle4 )"
    
    // ON PEUT ENVOYER LA REQUETE QUI VA FAIRE LE INSERT INTO
    sendQuerySQL($result, $paramTabAsso);

    return $result; 
}

function sendQuerySQL ($paramSQL, $tabTokenValeur)
{
      //global variables
      /*
    $databaseDB = "sql2";
    $loginDB    = "root";
    $passwordDB = "";
    $serveurDB  = "localhost";
    $charsetDB  = "utf8";
    */
    // infor,ation to change with each project when you enrigister a name hosting site
  
    
    //We need a DSN
    // Data Source Name
    // (like a URL to find the good database to send to...)
    $dsn = "mysql:dbname=$databaseDB;host=$serveurDB;charset=$charsetDB";
    
    // create connection to the datbase
    // http://php.net/manual/fr/pdo.construct.php
    $objetPDO = new PDO($dsn, $loginDB, $passwordDB);
    
    // MODIFY THE PARAMETRES
    // Show errors
    // call the METHODE setAttribute SUR OBJET $objetPDO
    $objetPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    
    // get the info from mysql into an associative table
    $objetPDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // JE DEMANDE A $objetPDO DE PREPARER LA REQUETE QUE JE VEUX EXECUTER
    // ON APPELLE LA METHODE prepare SUR $objetPDO
    // http://php.net/manual/fr/pdo.prepare.php
    $objetPDOStatement = $objetPDO->prepare($paramSQL);
    
    // ON VA EXECUTER LA REQUETE AVEC $objetPDOStatement
    // http://php.net/manual/fr/pdostatement.execute.php
    $objetPDOStatement->execute($tabTokenValeur);
    
    //allows us to grab the information (select) 
    return $objetPDOStatement;
}

// VIEW
function showEntered ($nameInput)
{
    // Show information sent by the formula
    // if infor,ation available
    if (isset($_REQUEST[$nameInput]))
    {
        // So It wil show
        echo $_REQUEST[$nameInput];
    }
}

// Declare function
// CONTROL
function checkInfoName ($nameInput)
{
    
  if (isset($_REQUEST[$nameInput]))
    {
        // so I get back the value
        $valueInput = $_REQUEST[$nameInput];
    }
    else
    {
        //if not the the field is empty by default 
        $valueInput = "";
    }
    // $valueInput is a local variable
    // contains what the visitor has sent with the formula
    $valueInput = $_REQUEST[$nameInput];
    
    // FILTRER bad information
    
    // ATTENTION: MODE PARANO
    //Order of filters is important
    
    // take away elements HTML and PHP
    // http://php.net/manual/fr/function.strip-tags.php
    $valueInput = strip_tags($valueInput);

    // take away spaces at start and end
    // http://php.net/manual/fr/function.trim.php
    $valueInput = trim($valueInput);
    
    // JE RAJOUTE DANS LE TABLEAU $tabColonneInfo L'INFO RECUPEREE DU FORMULAIRE
    // $tabColonneInfo["email"] = verifierInfoEmail("email");
    global $tabColonneInfo;
    $tabColonneInfo[$nameInput] = $valueInput;

    
    
    return $valueInput;
}

function checkInfoEmail ($nameInput)
{
    global $tabError;
    
    $email = checkInfoName ($nameInput);
    
    // TEST 
    if ($email == "")
    {
        // ERRor
        $tabError[] = "EMAIL EMPTY";
    }
    if (mb_strlen($email) > 1000)
    {
        // Error
        $tabError[] = "EMAIL TOO LONG";
    }
    if (filter_var($email, FILTER_VALIDATE_EMAIL) == false)
    {
        // ERror
        $tabError[] = "EMAIL INVALID";
    }
    return $email;
}

function checkInfoEmailUnique ($nameInput, $nameTable)
{
    $email = checkInfoEmail($nameInput);
            
            $querySQL =
<<<CODESQL

SELECT * FROM $nameTable
WHERE $nameInput = :$nameInput

CODESQL;
 $tabResultat = sendQuerySQL($querySQL, [ "$nameInput" => $email ]);
    // EST-CE QUE IL Y A UNE REPONSE OU PAS
    $inLoop = false;
    foreach($tabResult as $tabline)
    {
        // ON A TROUVE UNE LIGNE
        // DONC IL NE FAUT PAS INSERER UNE NOUVELLE LIGNE
        $inLoop = true;
        break;                  // ON NE VA TOURNER EN BOUCLE, UNE FOIS SUFFIT
    }
    
    // SI JE NE SUIS PAS PASSE DANS LA BOUCLE 
    // ALORS C'EST PAS BON
    if ($inLoop == true)
    {
        // ERREUR
        $tabError[] = "$email ALREADY USED";
    }
    return $email;
}

function checkInfoText ($nameInput, $lengthMax)
{
    global $tabError;
    
    $text = checkInfoName($nameInput);
    
    // TEST DE VALIDITE
    if ($text == "")
    {
        // ERREUR
        $tabError[] = "($nameInput) EMPTY TEXT FIELD";
    }
    if (mb_strlen($text) > $lengthMax)
    {
        // ERROR
        $tabError[] = "($nameInput) TEXT TOO LONG";
    }
    return $text;
}

function checkInfoUser ($nameInput, $lengthMax)
{
    global $tabError;
    
    $text = checkInfoName($nameInput);
    
    // TEST DE VALIDITE
    if ($user == "")
    {
        // ERREUR
        $tabError[] = "($nameInput) EMPTY TEXT FIELD";
    }
    if (mb_strlen($text) > $lengthMax)
    {
        // ERROR
        $tabError[] = "($nameInput) TEXT TOO LONG";
    }
    return $user;
}
function checkInfoNumber ($nameInput, $min, $max)
{
    global $tabError;
    
    $text = checkInfoName($nameInput);
    
    //Convert text to number
    $number = intval($text);
    
    // TEST DE VALIDITE
    if ($number < $min)
    {
        // ERREUR
        $tabError[] = "($nameInput) VALUE TOO SMALL";
    }

    // http://php.net/manual/fr/function.mb-strlen.php
    if ($number > $max)
    {
        // ERREUR
        $tabError[] = "($nameInput) VALUE TOO BIG";
    }
    
    return $number;
}



function checkInfoPassword ($nameInput, $lengthMax)
{
    global $tabError;
    
    $password = checkInfoName($nameInput);
    
    // TEST 
    if ($password == "")
    {
        // ERRor
        $tabError[] = "PASSWORD EMPTY";
    }
    if (mb_strlen($password) > 1000)
    {
        // Error
        $tabError[] = "PASSWORD TOO LONG";
    }
    
    return $password;
}


function checkInfoTitle ($nameInput, $lengthMax)
{
    global $tabError;
    
    $title = checkInfoName($nameInput);
    
    // TEST 
    if ($title == "")
    {
        // ERRor
        $tabError[] = "TITLE EMPTY";
    }
    if (mb_strlen($title) > $lengthMax)
    {
        // Error
        $tabError[] = "TITLE TOO LONG";
    }
    
    return $title;
}


function checkInfoDescription ($nameInput)
{
    global $tabError;
    
    $description = checkInfoName($nameInput);
    
    // TEST 
    if ($description == "")
    {
        // ERRor
        $tabError[] = "DESCRIPTION EMPTY";
    }
   
    
    return $description;
}

function saveSession ($key, $value)
{
    // POUR STOCKER UNE INFO DANS UNE SESSION
    // ON PASSE PAR LE TABLEAU ASSOCIATIF $_SESSION
    // MALHEUREUSEMENT IL FAUT APPELER LA FONCTION session_start()
    // POUR CREER CETTE VARIABLE $_SESSION
    // http://php.net/manual/fr/function.session-start.php
    if (!isset($_SESSION))
    {
        // PERMET DE N'APPELER QU'UNE FOIS LA FONCTION session_start
        session_start();
        // CETTE FONCTION VA VERIFIER SI ON A DEJA IDENTIFIE LE NAVIGATEUR
        // AVEC UN COOKIE PHPSESSID 
        // SI OUI, ON CONTINUE A L'UTILISER
        // SINON, ON CREE UN COOKIE PHPSESSID UNIQUE POUR IDENTIFIER LE NAVIGATEUR
    }
    
    // MAINTENANT, ON PEUT UTILISER LE TABLEAU $_SESSION
    $_SESSION[$key] = $value;
}

function readSession ($key)
{
    // EST-CE QUE LA VARIABLE $_SESSION N'EXISTE PAS?
    if ( ! isset($_SESSION))
    {
        // ALORS session_start VA CREER $_SESSION
        // PERMET DE N'APPELER QU'UNE FOIS LA FONCTION session_start
        session_start();
    }
    // MAINTENANT JE PEUX UTILISER $_SESSION
    
    // JE VERIFIE SI L'INFO EST PRESENTE DANS LE TABLEAU $_SESSION
    if (isset($_SESSION[$key]))
    {
        return $_SESSION[$key];
    }
    else
    {
        // SINON ON RENVOIE UN TEXTE VIDE
        return "";
    }
}

// AFFICHER LES ERREURS
function showError ($tabError)
{
    // http://php.net/manual/fr/function.implode.php
    $listError = implode(",", $tabError);
    $nbError    = count($tabError);
    
    // ERREUR: L'UNE DES INFORMATION EST MANQUANTE
    echo 
<<<CODEHTML
    <div class="ko">$nbError ERROR(S): $listError</div>
CODEHTML;

}

function lineCount ($nameTable)
{
    $querySQL = 
<<<CODESQL

SELECT COUNT(*) AS nbLine FROM $nameTable

CODESQL;

    $tabResult = sendQuerySQL($querySQL, []);
    $nbLine = 0;
    foreach($tabResult as $tabline)
    {
     
        $nbLine = $tabline["nbLine"];
    }
    
    return $nbLine;
}

function modifyLine ($nameTable,  $tabAssoColVal, $nameColWhere, $valColWhere)
{
    $listCol = "";
    foreach($tabAssoColVal as $col => $value)
    {
        $listCol .= ",$col = :$col"; 
    }
    //take away the ,
    $listCol = trim($listCol, ",");
    
    $querySQL =
    
<<<CODESQL
UPDATE $nameTable
SET $listCol
WHERE $nameColWhere = :$nameColWhere
CODESQL;
        sendQuerySQL ($querySQL ,$tabAssoColVal);
}




function deleteLine ($nameTable,  $nameCol, $valCol)
{
$querySQL =

<<<CODESQL
DELETE FROM $nameTable
WHERE
$nameCol = :$nameCol
CODESQL;

        sendQuerySQL($querySQL, 
                        ["$nameCol" => $valCol]);
                        }
                     


function sendMail ($destination, $titleMessage, $message)
{
    // ON VA UTILISER LE CODE PHP DE LA FONCTION mail
    // A RENSEIGNER DANS LE FICHIER private/setup.php
    // $auteurDuMail = "contact@monsite.fr";
    // $replyTo      = "service-client@monsite.fr";
    
    global $authorMail, $replyToMail;
    
    $headers = "From: $authorMail" . "\r\n" .
        "Reply-To: $replyTo" . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    
    // http://php.net/manual/en/function.mail.php
    mail($destination, $titleMessage, $message, $headers);
    
    // ENREGISTRER L'EMAIL DANS UNE TABLE Email
    insertLine("Email", 
                    [ 
                        "destination" => $destination, 
                        "titreMessage" => $titreMessage, 
                        "message"      => $message,
                        "sentDate"    => date("Y-m-d H:i:s"),
                        "status"       => "sent",
                    ]);
                    
    // TABLE SQL Email
    // idEmail         INT             PRIMARY A_I
    // destinataire    VARCHAR(300)
    // titreMessage    VARCHAR(100)
    // message         VARCHAR(1000)
    // dateEnvoi       DATETIME
    // statut          VARCHAR(100)
    
}
        

?>