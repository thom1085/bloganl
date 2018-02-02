<section>
    <h3>Admin Login</h3>
    <form class="form" method="GET" action="">
      <input type="text" name="username" required placeholder="YOUR USERNAME">
        <input type="text" name="email" required placeholder="YOUR EMAIL">
        <input type="password" name="password" required placeholder="YOUR PASWORD">
        <input type="hidden" name="barcode" value="login">
        <button type="submit">CONNECT</button>
        <div class="reponse">
<?php
// TRAITER LE FORMULAIRE DE connexion
if (isset($_REQUEST["codebarre"]) && ($_REQUEST["codebarre"] == "login"))
{
    // CHARGER LE CODE DE TRAITEMENT
    require_once("private/control/traitement-form-connection.php");
}
?>
        </div>
    </form>
</section>
