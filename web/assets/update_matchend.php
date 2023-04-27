<?php
// http://localhost/assets/update_matchend.php?matchid=187&score_t=16&score_ct=2
include("config.php");

if (!isset($_GET['matchid']) || !isset($_GET['score_t']) || !isset($_GET['score_ct'])) {
    die("Error: Missing data");
}

$match_id = $_GET['matchid'];
$score_t = $_GET['score_t'];
$score_ct = $_GET['score_ct'];

$sql = "UPDATE matches SET score_t = $score_t, score_ct = $score_ct WHERE matchid = '$match_id'";

if ($conn->query($sql) === TRUE) {
    echo "scores updated | ct: ".$score_ct." t: ".$score_t;
} else {
    echo "Error updating scores: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
