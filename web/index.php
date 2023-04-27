<?php
include("assets/config.php");

// Set number of matches per page
$matches_per_page = 10;

$page_number = 1;
if (isset($_GET['page'])) {
	$page_number = intval($_GET['page']);
	if ($page_number < 1) {
		$page_number = 1;
	}
}
$match_offset = ($page_number - 1) * $matches_per_page;
$sql = "SELECT * FROM matches ORDER BY date DESC LIMIT $matches_per_page OFFSET $match_offset";
$result = $conn->query($sql);
$sql = "SELECT COUNT(*) FROM matches";
$result_count = $conn->query($sql);
$total_matches = intval($result_count->fetch_row()[0]);
$total_pages = ceil($total_matches / $matches_per_page);
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
            <li class="selected"><a href="#">Home</a></li>
        </ul>
    </div>
	<div class="container">
		<div class="table-container">
      		<h1>Matches<p class="small-p">matchid's are shortened to 15 charakters</p></h1>
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
					if ($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
							echo "<tr>";
							if ($row["score_t"] > $row["score_ct"]) {
								echo "<td><a class='match-link' style='color:#309830;' href='match_info.php?match_id=".$row['matchid']."'>".substr($row['matchid'], 0, 15)."...</a></td>";
							} else if ($row["score_ct"] > $row["score_t"]) {
								echo "<td><a class='match-link' style='color:#ef5552;' href='match_info.php?match_id=".$row['matchid']."'>".substr($row['matchid'], 0, 15)."...</a></td>";
							} else {
								echo "<td><a class='match-link' style='color:white;' href='match_info.php?match_id=".$row['matchid']."'>".substr($row['matchid'], 0, 15)."...</a></td>";
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
				<?php
					if ($total_pages > 1) {
						echo "<div class='footer-table'><h2>10 items</h2>";
						echo "<div class='pages'>";

						for ($i = 1; $i <= $total_pages; $i++) {
							if ($i == $page_number) {
								echo "<button class='pagination-button active'>$i</button>";
							} else {
								echo "<a href='?page=$i'><button class='pagination-button'>$i</button></a>";
							}
						}
						echo "</div><h2>total matches $total_matches</h2></div>";
					}
				?>
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
