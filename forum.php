<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location:index.php');
}

include 'functions.php';

?>

<html>
<head>
    <title>Forum</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <!--Username, logout button, titel -->
    <span><a href="forum.php" id="headline">PHP Forum</a></span>
    <!-- Topic toevoegen als permissions '1' is + thread toevoegen zonder permissions-->
    <?php
        if (isset($_SESSION['permissions']) && !isset($_GET['page'])){
            echo "<a id='topic-toevoegen-a' onclick='addTopic()'>Topic toevoegen</a>";
            echo "<a id='topic-verwijderen-a' onclick='removeTopic()'> (topic verwijderen)</a>";
        }
        if (isset($_GET['page']) && $_GET['page'] == 1){
            echo "<a id='thread-toevoegen-a' onclick='addThread()'>Thread toevoegen</a>";
        }
    ?>



    <div id="logout" style="text-align: right">
        <span>Ingelogd als: <?php echo $_SESSION['user']; ?></span>
        <a href="logout.php"> logout</a>
    </div>
</header>
<main>
    <!--Topic lijst, thread lijst-->
    <?php
    include 'connect.php';
    include 'register_variables.php';
    if (isset($_GET['page'])) {
        $pag_num = $_GET['page'];
        switch ($pag_num) {
            case 1://pag_num 1 = overzicht threads van een topic
                if (isset($_GET['addThread'])){
                    include 'add_thread.php';
                    break;
                }
                //Eerst topic ID krijgen van SQL
                $topic_ID = null;
                $topic_name = $_GET['topic'];
                veranderHeadline('PHP Forum -> ' . $topic_name);
                $topic_name_sql = "SELECT `ID` FROM `topics` WHERE `topic` = '$topic_name'";
                $topic_name_result = mysqli_query($conn, $topic_name_sql);
                while ($row = mysqli_fetch_array($topic_name_result)) {
                    $topic_ID = $row['ID'];
                }
                //Dan alle threads krijgen
                $threads_sql = "SELECT `ID`, `title`, `user_created` FROM `threads` WHERE `topic_ID` = '$topic_ID'";
                $threads_result = mysqli_query($conn, $threads_sql);
                while ($row = mysqli_fetch_assoc($threads_result)) {
                    //uitprinten
                    echo '<div class="table-div">';
                    echo '<table>';
                    $ID = $row['ID'];
                    $title = $row['title'];
                    $user_created = $row['user_created'];
                    echo '<tr><td>' .
                        "<a class='table-a' href='forum.php?page=2&thread=$ID'>$title
                              <br> Gemaakt door: $user_created</a>" .

                        '</td></tr>';
                    echo '</table>';
                    echo '</div>';
                }
                break;
            case 2://pag_num 2 = overzicht van een thread zelf
                //uitprinten
                if (isset($_GET['thread'])) {
                    $thread = $_GET['thread'];
                } else {
                    break;
                }

                $thread_display_sql = "SELECT `title`,`content`,`user_created`,`date_created` FROM `threads` WHERE `ID` = '$thread'";
                $thread_display_result = mysqli_query($conn, $thread_display_sql);
                while ($row = mysqli_fetch_array($thread_display_result)) {
                    $title = $row['title'];
                    $content = $row['content'];
                    $user_created = $row['user_created'];
                    $date_created = $row['date_created'];

                    if (empty($row['content'])){
                        header('Location:forum.php');
                        break;
                    }
                    echo '<div class="thread-container-div">';
                    //titel, date created, user created
                    echo "<p class='title-text'>$user_created ";
                    checkUserPrintVerwijderen($user_created);
                    echo "</p>";
                    echo "<p class='title-text'>$title</p>" .
                         "<p class='title-text'>$date_created</p>";


                    //content
                    echo "<p class='content-text'>$content</p>";
                }
                mysqli_free_result($thread_display_result);
                //reactie toevoegen knop
                echo '<form action="reactie_handler.php" method="post">';
                echo '<textarea class="reactie-input" id="reactie-input" name="reactie-input"></textarea>';
                echo "<input type='hidden' name='current_thread' value='$thread'>";
                $user = $_SESSION['user'];
                echo "<input type='hidden' name='user' value='$user'>";
                echo '<button class="button">Reactie toevoegen</button>';
                echo '</form>';
                echo '</div>';
                $reactie_display_sql = "SELECT `user_created`,`content`,`date_created` FROM `reacties` WHERE `thread_ID` = '$thread'";
                $reactie_display_result = mysqli_query($conn, $reactie_display_sql);
                //Reactie lijst printen
                while ($row = mysqli_fetch_array($reactie_display_result)) {
                    if (!empty($row['user_created'])) {
                        echo '<div class="thread-reactie-container-div">';
                        $user_created = $row['user_created'];
                        $content = $row['content'];
                        $date_created = $row['date_created'];
                        echo "<p class='reactie-title-text'>$user_created</p>";
                        echo "<p class='reactie-title-text'>$date_created</p>";
                        echo "<p class='reactie-content-text'>$content</p>";
                        echo '</div>';
                    }
                }
                mysqli_free_result($reactie_display_result);
        }
    } else {//Topic lijst laten zien
        $topics_sql = "SELECT `topic` FROM `topics`";
        $topics_result = mysqli_query($conn, $topics_sql);
        echo '<div class="table-div">';
        echo '<table id="topic-table">';
        while ($row = mysqli_fetch_array($topics_result, MYSQLI_NUM)) {
            foreach ($row as $value) {
                echo '<tr><td>' .
                    "<a class='table-a' href='forum.php?page=1&topic=$value'>$value</a>" .
                    '</td></tr>';
            }
        }
        echo '</table>';
        echo '</div>';
    }

    $conn->close();
    ?>
</main>
<script src="main.js"></script>
</body>
</html>
