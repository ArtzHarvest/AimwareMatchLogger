# AimwareMatchLogger

This project contains a Lua script and a PHP website that work together to log CS:GO match data and player statistics to a MySQL database.

The Lua script captures match data, while the PHP website provides a simple web interface to view and analyze the data.

# Features
Logs match data including map, game mode, scores, and player stats

Stores data in a MySQL database for easy retrieval and analysis

Provides a simple web interface to view match data and player statistics

# Installation
To use this project, you'll need a web server running PHP and a MySQL database. Here are the steps to get started:

1. Download this repository and upload it to your web server.
2. Edit the config.php file in the website directory with your MySQL database credentials and site information.
3. Create a new MySQL database and import the csgostuff.sql file in the database directory.
4. Copy the lua to your Aimware Lua directory.
5. Replace the URL in the MatchLoggerScript.lua script with the URL of your website.
6. Start CS:GO and run the MatchLoggerScript.lua script.

# Usage
Once everything is set up, the Lua script will automatically capture match data (on match_start, round_end and win_panel events) and send it to the PHP website for storage. You can view the match data and player statistics by loading up the website.

# Screenshots
![Panel Overview](/screenshots/b1g_rat-ZEbOO9-def_not-a_ratw0hsSfT7wyrU.rat.png?raw=true "Panel Overview")
![Match Overview](/screenshots/b1g_rat-lfQZcm-def_not-a_ratpwgfSEjkI05E.rat.png?raw=true "Match Overview")

# Todo
1. include basic user authentication to keep data secure
2. maybe admin panel for deleting some stuff
3. better round tracking thingy

# License
This project is licensed under the MIT License. See the LICENSE file for details.
