<?php
$email = checkInfoEmail("email");
$name = checkInfoText("name",300);
$comment = checkInfoText("comment",1000);
            
            if (count($tabError) == 0)
            {
                $dateContact = date ("Y-m-d H:i:s");
                $querySQL = 
<<<CODESQL
INSERT INTO contact
( email, name, comment, dateContact)
VALUES
(:email, :name, :comment, :dateContact)
CODESQL;

        sendQuerySQL($querySQL,
                [
                "email"           =>$email,
                "name"            =>$name,
                "comment"         =>$comment,         
                "dateContact"     =>$dateContact
                ]);
                
                echo "Thank You $email ($name) For Your Comment";
                
                    // ENVOYER UN EMAIL AU WEBMASTER POUR LE PREVENIR
        sendMail("webmaster@monsite.fr", "NEw message from $name", $message);
                
            }
            else
            {
      
            showError($tabError);
            }