<?php

function setComments($conn) {
  if(isset($_POST['commentSubmit'])){
    $user = $_POST['user'];
    $date = $_POST['date'];
    $message = $_POST['message'];

    $sql = "INSERT INTO comments (user, date, message) VALUES ('".$user."', '".$date."', '".$message."')";
    $result = $conn->query($sql);
  }
}

function getComments($conn){
  $sql = "SELECT * FROM comments";
  $result = $conn->query($sql);
  while($row = $result->fetch_assoc()){
    echo "<div class='commentdisplay'><p>";
    echo "<h5>";
    echo $row['user']."<br>";
    echo $row['date']."<br>";
    echo "</h5>";
    echo $row['message'];
    echo "</p>
      <form class='edit-form' method='POST' action='edit-comments.php'>
        <input type='hidden' name='idComments' value='".$row['idComments']."'>
        <input type='hidden' name='user' value='".$row['user']."'>
        <input type='hidden' name='date' value='".$row['date']."'>
        <input type='hidden' name='message' value='".$row['message']."'>
        <button>Edit</button>
      </form>
    </div>";
  }
}

function editComments($conn) {
  if(isset($_POST['commentSubmit'])){
    $user = $_POST['user'];
    $date = $_POST['date'];
    $message = $_POST['message'];

    $sql = "INSERT INTO comments (user, date, message) VALUES ('".$user."', '".$date."', '".$message."')";
    $result = $conn->query($sql);
  }
}
