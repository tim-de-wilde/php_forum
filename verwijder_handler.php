<?php
include 'connect.php';
//if (!isset($_POST['ID'])){
//    die('$_POST ID not set');
//}

$type = $_POST['type'];
$ID = $_POST['ID'];


switch ($type){
    case 'thread':
        //Verwijderen van de thread zelf & de reacties
        $sql = "DELETE FROM `threads` WHERE `ID` = '$ID';";
        $sql .= "DELETE FROM `reacties` WHERE `thread_ID` = '$ID';";
        mysqli_multi_query($conn,$sql);
        break;
    case 'topic':
        //Eerst topic ID krijgen
        $id_sql = "SELECT `ID` FROM `topics` WHERE `topic` = '$ID'";
        $topic_ID = null;
        $result = mysqli_query($conn,$id_sql);
        while ($row=mysqli_fetch_assoc($result)){
            $topic_ID = $row['ID'];
        }
        //Alle ID's krijgen van threads in de topic
        $thread_id_sql = "SELECT `ID` FROM `threads` WHERE `topic_ID` = '$topic_ID'";
        $thread_id_result = mysqli_query($conn,$thread_id_sql);
        $id_array = array();
        while ($row=mysqli_fetch_assoc($thread_id_result)){
            array_push($id_array,$row['ID']);
        }

        //Verwijderen van de reacties (werkt)
        if (!empty($id_array)){
            $id_array_sql = '';
            foreach($id_array as $value){
                $id_array_sql .= "DELETE FROM `reacties` WHERE `thread_ID` = '$value';";
            }
            mysqli_multi_query($conn,$id_array_sql);
        }
        //Verwijderen van threads en topic
        if (!empty($topic_ID)){
            $sql = "DELETE FROM `threads` WHERE `topic_ID` = $topic_ID;";
            $sql .= "DELETE FROM `topics` WHERE `ID` = $topic_ID;";
            mysqli_multi_query($conn,$sql);
        }
        break;
}
$conn->close();