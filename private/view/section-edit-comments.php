<?php
  date_default_timezone_set('Europe/France');
  include 'private/control/treatment-form-comment.php';
  include 'private/control/dbh.php';
?>
<section class="commentsection">
  <div class="commentsbox">
  <h3>Edit Your comments below</h3>
<?php
$idComments = $_POST['idComments'];
$user = $_POST['user'];
$date = $_POST['date'];
$message = $_POST['message'];

    echo "<form method='POST' action='".editComments($conn)."'>
    <input type='hidden' name='user' value='".$user."'>
    <input type='hidden' name='date' value='".$date."'>
    <textarea name='message'>".$message."</textarea>
    <button class='' type='submit' name='commentSubmit'>Edit</button>
    </form>";
?>
  </div>
</section>
