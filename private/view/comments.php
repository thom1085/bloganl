<?php
  date_default_timezone_set('Europe/France');
  include 'private/control/treatment-form-comment.php';
  include 'private/control/dbh.php';
?>
<section class="commentsection">
  <div class="commentsbox">
  <h3>Leave Your comments below</h3>
    <?php
    echo "<form method='POST' action='".setComments($conn)."' class='formcomments'>
    <input type='hidden' name='user' value='Anonymous'>
    <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
    <textarea name='message' placeholder='Add your comment here!'></textarea>
    <button class='button-blue' type='submit' name='commentSubmit'>Comment</button>
    </form>";
    getComments($conn);
    ?>
  </div>
</section>
