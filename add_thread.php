<?php
if (session_status() == PHP_SESSION_NONE){
    session_start();
}

if (isset($_POST['thread-title'])){
    $_inserted = [null,$_POST['thread-title'],$_POST['thread-content'],$_SESSION['user']];

    include 'connect.php';

    //Opvragen thread_ID
    $topic_name = $_POST['topic-name'];
    $id_sql = "SELECT `ID` FROM `topics` WHERE `topic` = '$topic_name'";
    $id_result = mysqli_query($conn,$id_sql);
    while ($row = mysqli_fetch_array($id_result)){
        $_inserted[0] = $row['ID'];
    }

    //De thread in database doen
    $insert_sql = "INSERT INTO `threads` (`topic_ID`,`title`,`content`,`user_created`)
                   VALUES ('$_inserted[0]','$_inserted[1]','$_inserted[2]','$_inserted[3]')";
    $insert_result = mysqli_query($conn,$insert_sql);


    $conn->close();
    //Terug naar homepagina
    header('Location:forum.php');
}
?>

<div id="add-thread-div">
    <form action="add_thread.php" method="POST" class="input-form">
        <fieldset style="margin-top: 5px;">
            <label for="thread-title">Titel:</label> <br>
            <input type="text" name="thread-title" required> <br>
            <label for="thread-content">Content: </label> <br>
            <textarea name="thread-content" cols="30" rows="10" required></textarea> <br>
            <input type="hidden" name="topic-name" value="<?php echo $_GET['topic']; ?>">
            <input type="submit">
        </fieldset>
    </form>
</div>