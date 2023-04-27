<?php
// http://localhost/assets/insert_matchinfos.php?matchid=187&map=de_mirage&gamemode=Deathmatch&score_t=16&score_ct=2
include("config.php");

if (!isset($_GET['matchid']) || !isset($_GET['map']) || !isset($_GET['gamemode']) || !isset($_GET['score_t']) || !isset($_GET['score_ct'])) {
    die("Error: Missing data");
}

$matchid = $_GET['matchid'];
$map = $_GET['map'];
$date = date('Y-m-d H:i:s');
$gamemode = $_GET['gamemode'];
$score_t = $_GET['score_t'];
$score_ct = $_GET['score_ct'];


$sql = "INSERT INTO matches (matchid, date, map, gamemode, score_t, score_ct) VALUES ('$matchid', '$date', '$map', '$gamemode', '$score_t', '$score_ct')";

if ($conn->query($sql) === TRUE) {
    echo "Match infos inserted";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
