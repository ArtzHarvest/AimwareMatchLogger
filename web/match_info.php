<?php
include("assets/config.php");

$match_id = $_GET['match_id'];
$sql = "SELECT * FROM matches WHERE matchid = '$match_id'";
$result = $conn->query($sql);
$sql1 = "SELECT * FROM match_infos WHERE matchid = '$match_id' ORDER BY team ASC, score DESC";
$result1 = $conn->query($sql1);
$sql2 = "SELECT * FROM match_infos WHERE matchid = '$match_id'";
$result2 = $conn->query($sql2);
?>
<html>
<head>
	<title>Aimware Match Stats</title>
	<link rel="icon" type="image/png" href="assets/icons/favicon.svg">
	<link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div id="menu-bar">
        <img src="https://cdn.aimware.net/asset/img/logo/main-standards.svg" alt="Logo" class="logo">
        <ul class="menu-right">
			<?php
				echo '<li><a href=http://'.$_SERVER['HTTP_HOST'].'>Home</a></li>';
			?>
            <li class="selected"><a href="#">Match</a></li>
        </ul>
    </div>
	<div class="container">
		<div class="table-container">
				<h1>Match<p class="small-p">matchid's are shortened to 25 characters</p></h1>
			<div class="matches">
				<table>
					<tr>
						<th>MatchID</th>
						<th>Map</th>
						<th>Gamemode</th>
						<th>You</th>
						<th>Enemy</th>
						<th>Date</th>
					</tr>
					<?php
                    $sql = "SELECT * FROM matches WHERE matchid = '$match_id'";
                    $result = $conn->query($sql);
					if ($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
							echo "<tr>";
							if ($row["score_t"] > $row["score_ct"]) {
								echo "<td><a class='match-link' style='color:#309830;' href='match_info.php?match_id=".$row['matchid']."'>".substr($row['matchid'], 0, 25)."...</a></td>";
							} else if ($row["score_ct"] > $row["score_t"]) {
								echo "<td><a class='match-link' style='color:#ef5552;' href='match_info.php?match_id=".$row['matchid']."'>".substr($row['matchid'], 0, 25)."...</a></td>";
							} else {
								echo "<td><a class='match-link' style='color:white;' href='match_info.php?match_id=".$row['matchid']."'>".substr($row['matchid'], 0, 25)."...</a></td>";
							}
							echo "<td><img src='assets/map-icons/map_icon_".$row["map"].".png' title='".$row["map"]."'></td>";
							echo "<td>".$row["gamemode"]."</td>";
							echo "<td>".$row["score_t"]."</td>";
							echo "<td>".$row["score_ct"]."</td>";
							echo "<td>".$row["date"]."</td>";
							echo "</tr>";
						}
					} else {
						echo "<tr><td colspan='8'>No matches found.</td></tr>";
						}
					?>
				</table>
			</div>
			<div class="match-started">
				<h1>Match Infos - Map: <?php 
                    $sql = "SELECT * FROM matches WHERE matchid = '$match_id'";
                    $result = $conn->query($sql);
					if ($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
							echo $row["map"]; 
							if ($row["score_t"] > $row["score_ct"]) {
								echo "<i style='color:#309830;right:5px;position: absolute;'>You won</i>";
							} else if ($row["score_ct"] > $row["score_t"]) {
								echo "<i style='color:#ef5552;right:5px;position: absolute;'>You lost</i>";
							} else {
								echo "<i style='color:white;right:5px;position: absolute;'>draw</i>";
							}
						}
					}
					?></h1>
				<table>
					<tr>
						<th>Name</th>
						<th>Rank</th>
						<th>Wins</th>
						<th>Kills</th>
						<th>Deaths</th>
						<th>Assists</th>
						<th>MVPs</th>
						<th>Score</th>
						<th>Team</th>
					</tr>
					<?php
					if ($result1->num_rows > 0) {
						while($row1 = $result1->fetch_assoc()) {
							echo "<tr>";
							echo "<td><a href='https://steamcommunity.com/profiles/[U:1:".$row1["steamid"]."]' target='_blank'>".urldecode($row1["name"])."</a></td>";
							echo "<td><img class='ranks' src='assets/rank-icons/".$row1["rank"].".png' title='".$row1["rank"]."'></td>";
							echo "<td>".$row1["wins"]."</td>";
							echo "<td>".$row1["kills"]."</td>";
							echo "<td>".$row1["deaths"]."</td>";
							echo "<td>".$row1["assists"]."</td>";
							echo "<td><h class='mvptext'><div class='mvpstar-container'><img class='mvpstar' src='assets/icons/Scoreboard_mvp.webp' title='MVP'><div class='mvpstar-number'>".$row1["mvps"]."</div></div></h></td>";
							echo "<td>".$row1["score"]."</td>";
                            if ($row1["team"] == 2){
                                echo "<td><img src='assets/icons/TSide.webp' title='TSide'></td>";
                            } else if ($row1["team"] == 3){
                                echo "<td><img src='assets/icons/CTSide.webp' title='CTSide'></td>";
                            }
							echo "</tr>";
						}
					} else {
						echo "<tr><td colspan='8'>No players found</td></tr>";
						}
					?>
				</table>
			</div>
		</div>
	</div>
	<footer>
		<div class="footer-content">
			<p>made with <span class="danger">❤️</span> by <a href="https://aimware.net/forum/user/484354" target="_blank">ArtzHarvest</a></p>
		</div>
	</footer>
</body>
</html>
