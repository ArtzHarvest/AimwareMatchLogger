<?php
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
// http://localhost/assets/insert_start.php?name=Gay;&matchid=187&steamid=187&rank=Global Elite&wins=10&kills=0&deaths=0&assists=0&mvps=0&score=0&team=2
include("config.php");

if (!isset($_GET['name']) || !isset($_GET['matchid']) || !isset($_GET['steamid']) || !isset($_GET['rank']) || !isset($_GET['wins']) || !isset($_GET['kills']) || !isset($_GET['deaths']) || !isset($_GET['assists']) || !isset($_GET['mvps']) || !isset($_GET['score'])) {
    die("Error: Missing data");
}

$name = $_GET['name'];
$name = urlencode($name);
$matchid = $_GET['matchid'];
$steamid = $_GET['steamid'];
$rank = $_GET['rank'];
$wins = $_GET['wins'];
$kills = $_GET['kills'];
$deaths = $_GET['deaths'];
$assists = $_GET['assists'];
$mvps = $_GET['mvps'];
$score = $_GET['score'];
$team = $_GET['team'];

$sql = "INSERT INTO match_infos (name, matchid, steamid, rank, wins, kills, deaths, assists, mvps, score, team) VALUES ('$name', '$matchid', '$steamid', '$rank', '$wins', '$kills', '$deaths', '$assists', '$mvps', '$score', '$team')";

if ($conn->query($sql) === TRUE) {
    echo "user: ".$name." inserted";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
