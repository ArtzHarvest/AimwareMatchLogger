<?php
// http://localhost/assets/update_users.php?matchid=187&steamid=1&kills=16&deaths=1&assists=2&mvps=6&score=32&team=2
include("config.php");

if (!isset($_GET['matchid']) || !isset($_GET['steamid']) || !isset($_GET['kills']) || !isset($_GET['deaths']) || !isset($_GET['assists']) || !isset($_GET['mvps']) || !isset($_GET['score']) || !isset($_GET['team'])) {
    die("Error: Missing data");
}

$match_id = $_GET['matchid'];
$steamid = $_GET['steamid'];
$kills = $_GET['kills'];
$deaths = $_GET['deaths'];
$assists = $_GET['assists'];
$mvps = $_GET['mvps'];
$score = $_GET['score'];
$team = $_GET['team'];

$sql = "UPDATE match_infos SET kills = $kills, deaths = $deaths, assists = $assists, mvps = $mvps, score = $score, team = $team WHERE matchid = '$match_id' AND steamid = '$steamid'";

if ($conn->query($sql) === TRUE) {
    echo "user stats ".$steamid." updated";
} else {
    echo "Error updating scores: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
