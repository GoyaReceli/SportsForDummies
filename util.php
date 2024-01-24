<style>
    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        border: 1px solid black;
        /* overflow-x: auto; */
    }

    .data-table th,
    .data-table td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
    }

    .data-table th {
        background-color: #f7f7f7;
        font-weight: bold;
    }

    .link {
        text-decoration: none;
        color: #333;
        font-weight: bold;
    }

    .table-highlight:hover {
        background-color: #FF8C8C;
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

    .abt-me-container {
        text-align: center;
        margin: 20px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .comments-container {
        max-height: 200px;
        overflow-y: auto;
        margin-bottom: 10px;
    }

    .comment {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .reset-pass-container {
        margin-top: 20px;
    }

    .reset-pass-btn {
        background-color: white;
        width: 150px;
        height: 40px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        cursor: pointer;
    }

    .dummy-info-container {
        text-align: center;
        margin: 20px;
        padding: 20px;
        border: 2px solid #3498db;
        border-radius: 8px;
        background-color: #f5f5f5;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
    }

    .dummy-info-container:hover {
        transform: scale(1.05);
    }

    .dummy-info-container h2 {
        font-size: 28px;
        color: #3498db;
        margin-bottom: 15px;
        animation: colorCycle 5s infinite;
    }

    @keyframes colorCycle {
        0% {
            color: pink;
        }

        50% {
            color: red;
        }

        100% {
            color: pink;
        }
    }

    .dummy-info-container p {
        font-size: 18px;
        line-height: 1.5;
        color: #333;
    }

    .input-wrapper {
        position: relative;
        margin: 10px 0;
        transition: all 0.3s ease-in-out;
    }

    .input-wrapper input:focus {
        border-color: #4CAF50;
    }

    .required {
        color: red;
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }

    .input-wrapper input:focus+.required {
        opacity: 1;
    }

    .input-wrapper input[type="text"],
    .input-wrapper input[type="password"] {
        width: 275px;
        height: 45px;
        padding: 12px;
        font-size: 18px;
    }


    .show-password {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        opacity: 0.5;
        transition: opacity 0.3s ease-in-out;
    }

    .show-password:hover {
        opacity: 1;
    }

    button {
        background-color: white;
        width: 130px;
        height: 50px;
        font-size: 16px;
        cursor: pointer;
        border: 1px solid #ddd;
        transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out, border-color 0.3s ease-in-out;
    }

    button:hover {
        background-color: #FFD2D2;
        color: black;
        border-color: #FF8C8C;
    }

    .welcome-label {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }
</style>

<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const passwordFieldType = passwordInput.getAttribute('type');

        if (passwordFieldType === 'password') {
            passwordInput.setAttribute('type', 'text');
        } else {
            passwordInput.setAttribute('type', 'password');
        }
    }
</script>

<?php
session_start();

include_once("db_connect.php");

/**
 * Huy
 */
function displaySportTeam($db, $sport) {
    $sql = "SELECT Team.*, League.name AS league_name 
            FROM Team 
            LEFT JOIN Participates_in ON Team.teamid = Participates_in.teamid 
            LEFT JOIN League ON Participates_in.leagueid = League.leagueid";

    $res = $db->query($sql);

    echo "<table class='data-table'>";
    echo "<tr>";
    echo "<th>Team</th>";
    echo "<th>City</th>";
    echo "<th>League</th>";
    echo "</tr>";

    if($res === false) {
        // Handle error
        echo "<tr><td colspan='3'>There has been a problem. Please try again.</td></tr>";
    } else {
        while($row = $res->fetch()) {
            $id = $row['teamid'];
            $team = $row['name'];
            $city = $row['city'];
            $league = $row['league_name'];

            echo "<tr>";
            echo "<td class='table-highlight'><a href='?tid=$id' class='link'>$team</a></td>";
            echo "<td>$city</td>";
            echo "<td>$league</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
}

/**
 * Huy
 */
function genDummyInfo() {
    echo "<div class='dummy-info-container'>";
    echo "<h2>Welcome, Fellow Sports Novice!</h2>";
    echo "<p>This page is specifically crafted for individuals who are new to sports but eager to explore and learn. Here, we'll guide you through players, teams, and games, helping you understand the exciting world of sports!</p>";
    echo "<p>Whether you're diving into basketball, soccer, or any other sport, we've got you covered. Get ready to embark on an adventurous journey to discover the players who make sports thrilling!</p>";
    echo "</div>";
}


/**
 * Huy
 */
function displayTeamPlayers($db, $tid) {
    $sql = "SELECT *
            FROM Player NATURAL JOIN Plays_in
            WHERE Plays_in.teamid = $tid";

    displayPlayers($db, $sql);
}

/**
 * Huy
 */
function displayAllPlayers($db, $sport) {
    $sql = "SELECT *
    FROM Player NATURAL JOIN Plays_in";

    displayPlayers($db, $sql);
}

/**
 * Huy
 */
function displayPlayers($db, $sql) {
    $res = $db->query($sql);

    if($res == FALSE) {
        echo "<tr><td colspan='3'>There has been a problem. Please try again.</td></tr>";
        header("refresh:1;url=dashboard.php");
    } else {
        echo "<table class='data-table'>";
        echo "<tr>";
        echo "<th>Player</th>";
        echo "<th>Position</th>";
        echo "<th>Birthday</th>";
        echo "<th>Start Date</th>";
        echo "<th>Retirement Date</th>";
        echo "</tr>";

        while($row = $res->fetch()) {
            $pid = $row['playerid'];
            $fname = $row['fname'];
            $lname = $row['lname'];
            $startDate = $row['startDate'];
            $endDate = $row['endDate'];
            $birthday = $row['birthday'];
            $position = $row['position'];

            echo "<tr>";
            echo "<td class='table-highlight'><a class='link' href='?playerComment=$pid'>$fname $lname</a></td>";
            echo "<td>$position</td>";
            echo "<td>$birthday</td>";
            echo "<td>$startDate</td>";

            if($endDate === null) {
                echo "<td>N/A</td>";
            } else {
                echo "<td>$endDate</td>";
            }

            echo "</tr>";
        }

        echo "</table>";
    }
}

/**
 * Huy
 */
function genPlayerComments($db, $pid) {

    echo "<table class='data-table'>";
    echo "<tr>";
    echo "<th>Height</th>";
    echo "<th>Shoe Size</th>";
    echo "<th>Overall Score</th>";
    echo "<th>Most Occuring Score Type</th>";
    echo "</tr>";

    $playerSpecsRes = getBasketballPlayerSpecs($db, $pid);
    $playerSpecsRow = $playerSpecsRes->fetch();
    
    $overallScoreRes = getPlayerTotalScore($db, $pid);
    $overallScoreRow = $overallScoreRes->fetch();
    
    $mostScoreTypeRes = getPlayerMostScoreType($db, $pid);
    $mostScoreTypeRow = $mostScoreTypeRes->fetch();

    $height = $playerSpecsRow['height'];
    $shoeSize = $playerSpecsRow['shoeSize'];
    $overallScore = $overallScoreRow['totalScore'];
    $mostScoreType = $mostScoreTypeRow['scoreType'];

    echo "<tr>";
    echo "<td>$height</td>";
    echo "<td>$shoeSize</td>";
    echo "<td>$overallScore</td>";
    echo "<td>$mostScoreType</td>";
    echo "</tr>";
    echo "</table>";
    
    $res = getPlayerTeams($db, $pid);

    if($res == FALSE) {
        echo "<tr><td colspan='3'>There has been a problem. Please try again.</td></tr>";
        header("refresh:1;url=dashboard.php");
    } else {
        echo "<table class='data-table'>";
        echo "<tr>";
        echo "<th>Team</th>";
        echo "<th>Start Date</th>";
        echo "<th>End Date</th>";
        echo "</tr>";

        if($res->rowCount() == 0) {
            echo "<tr>";
            echo "<td>No Data</td>";
            echo "<td>No Data</td>";
            echo "<td>No Data</td>";
            echo "</tr>";
        } else {
            while($row = $res->fetch()) {
                $teamName = $row['name'];
                $startDate = $row['startDate'];
                $endDate = $row['endDate'];

                echo "<tr>";
                echo "<td>$teamName</td>";
                echo "<td>$startDate</td>";
                if($endDate == FALSE) {
                    echo "<td>Still Playing</td>";
                } else {
                    echo "<td>$endDate</td>";
                }
                echo "</tr>";
            }
        }

        echo "</table>";
    }
    

    $res = getPlayerComments($db, $pid);

    if($res == FALSE) {
        echo "<tr><td colspan='3'>There has been a problem. Please try again.</td></tr>";
        header("refresh:1;url=dashboard.php");
    } else {
        echo "<table class='data-table'>";
        echo "<tr>";
        echo "<th>User</th>";
        echo "<th>Stars</th>";
        echo "<th>Comment</th>";
        echo "</tr>";

        if($res->rowCount() == 0) {
            echo "<tr>";
            echo "<td>No Data</td>";
            echo "<td>No Data</td>";
            echo "<td>No Data</td>";
            echo "</tr>";
        } else {
            while($row = $res->fetch()) {
                $stars = $row['noStars'];
                $comment = $row['comments'];
                $user = $row['username'];
                $uid = $row['uid'];

                echo "<tr>";
                echo "<td class='table-highlight'><a class='link' href='?op=abt&uid=$uid'>$user</a></td>";
                echo "<td>$stars</td>";
                echo "<td>$comment</td>";
                echo "</tr>";
            }
        }

        echo "</table>";
    }
}

/**
 * Huy
 */
function addParams($params = []) {
    $queryString = http_build_query(array_merge($_GET, $params));
    return '?'.$queryString;
}

/**
 * Huy
 */
function isSelected($sport, $data) {
    return (!isset($data['sport']) || $data['sport'] === $sport) ? 'selected' : '';
}

/**
 * Huy
 */
function isActive($op, $data) {
    return (isset($data['op']) && $data['op'] == $op) ? 'style="background-color: #FF8C8C;"' : '';
}

function showLoginForm($db) {
    ?>
    <label class="welcome-label">Welcome User!</label>
    <form name="fmLogin" method="POST" action="?op=login" class="login-form">
        <div class="input-wrapper">
            <input type="text" name="username" id="username" placeholder="Username" required>
            <span class="required">*</span>
        </div>
        <div class="input-wrapper">
            <input type="password" name="password" id="password" placeholder="Password" required>
            <span class="required">*</span>
            <span class="show-password" onclick="togglePasswordVisibility(this)"><i class="far fa-eye"></i></span>
        </div>
        <div class="button-wrapper">
            <button type="submit">Login</button>
            <button type="button" onclick="location.href='?op=signUp'">Sign Up</button>
        </div>
    </form>
    <?php
}

function showLogoutForm($uname) {
    ?>
    <form name="fmLogout" method="POST" action="?op=logout">
        <button class="user-logout" type="submit">Logout</button>

        <?php
        echo "<p>Welcome: ".$uname."</p>";
        echo "</form>";
}

function getUid($db, $LoginInfo): int {
    $uname = $LoginInfo['username'];
    $pass = $LoginInfo['password'];
    $sql = "SELECT uid
            FROM User
            WHERE username='$uname' AND password='$pass'";

    $res = $db->query($sql);

    if($res != FALSE && $res->rowCount() == 1) {
        $userRow = $res->fetch();
        return $userRow['uid'];
    } else {
        return 0;
    }
}

function getName($db, $uid) {
    $sql = "SELECT username
            FROM User
            WHERE uid=$uid";

    $res = $db->query($sql);

    if($res != FALSE && $res->rowCount() == 1) {
        $nameRow = $res->fetch();
        $name = $nameRow['username'];
        return $name;
    } else {
        return "Unknown";
    }
}

function genSignUp() {
    ?>
        <CENTER>
            <FORM name='fmSignUp' method='POST' action='?op=signedUp'>
                <INPUT style='font-size: 18px;' type='text' name='username' placeholder='Username' />
                <BR></BR>
                <INPUT style='font-size: 18px;' type='text' name='password' placeholder='Password' />
                <BR></BR>
                <button style="background-color: white; width: 215px; height: 75px; margin: 22px; font-size: 18px;"
                    type="submit">Submit</button>
            </FORM>
        </CENTER>
        <?php
}

function genSignedUp($db, $signUpInfo) {
    $uname = $signUpInfo['username'];
    $pass = $signUpInfo['password'];
    $sql1 = "SELECT uid
            FROM User
            WHERE username ='$uname'";
    $res1 = $db->query($sql1);
    if($res1->rowCount() == 0) {
        $sql2 = "INSERT INTO User(adminStat, username, password, userScore)
        VALUES(0, '$uname', '$pass', 0)";
        $res2 = $db->query($sql2);
        if($res2 == TRUE) {
            echo "<H1>User Sucessfully Added!</H1>";
        } else {
            echo "<H1>Error adding user</H1>";
        }
    } else {
        echo "<H1>User already in database</H1>";
    }
}

function genAbtMe($db, $uid) {
    genAbt($db, $uid);

    echo "<div class='reset-pass-container'>";
    echo "<button class='reset-pass-btn' type='button' onclick=\"location.href='?op=resetPass'\">Reset Password</button>";
    echo "</div>"; // Close reset-pass-container

}

function genAbt($db, $uid) {
    $uname = getName($db, $uid);
    echo "<div class='abt-me-container'>";
    echo "<h1>About: ".$uname."</h1>";

    $sql1 = "SELECT userScore FROM User WHERE uid=$uid";
    $res1 = $db->query($sql1);
    $scoreRow = $res1->fetch();

    if($res1 != FALSE) {
        $userScore = $scoreRow['userScore'];
        echo "<h3>User Score: ".$userScore."</h3>";
    } else {
        echo "<h3>Error Retrieving User Score</h3>";
    }

    echo "<h3>Comments:</h3>";

    echo "<div class='comments-container'>";
    $sql2 = "SELECT noStars, comments, t1.name AS team1, t2.name AS team2, location
            FROM Reviewed NATURAL JOIN Games 
            JOIN Team t1 ON teamid1=t1.teamid 
            JOIN Team t2 ON teamid2=t2.teamid
            WHERE uid=$uid";
    $res2 = $db->query($sql2);

    if($res2 != FALSE && $res2->rowCount() > 0) {
        while($row = $res2->fetch()) {
            $noStars = $row['noStars'];
            $comment = $row['comments'];
            $team1 = $row['team1'];
            $team2 = $row['team2'];
            $location = $row['location'];
            echo "<div class='comment'>";
            echo "<h4>Game: ".$team1." vs ".$team2." in ".$location."</h4>";
            echo "<h5>Stars: ".$noStars."</h5>";
            echo "<h5>Comment: ".$comment."</h5>";
            echo "</div>";
        }
    } else {
        echo "<h3>No user comments</h3>";
    }
    echo "</div>"; // Close comments-container
    echo "</div>"; // Close abt-me-container
}

function genResetPass() {
    ?>
        <CENTER>
            <H3>Current Password:</H3>
            <FORM name='fmResetPass' method='POST' action='?op=validateReset'>
                <INPUT style='font-size: 18px;' type='text' name='currPass' placeholder='Current Password' required />
                <H3>New Password:</H3>
                <INPUT style='font-size: 18px;' type='password' name='newPass' placeholder='New Password' required />
                <BR></BR>
                <INPUT style='font-size: 18px;' type='password' name='confirmNP' placeholder='Confirm New Password'
                    required />
                <BR></BR>
                <BUTTON style='background-color: white; font-size: 18px' type='submit'>Submit</BUTTON>
            </FORM>
        </CENTER>
        <?php
}

function validateReset($db, $resetInfo) {
    $uid = $_SESSION['uid'];
    $currPass = $resetInfo['currPass'];
    $newPass = $resetInfo['newPass'];
    $confirmNP = $resetInfo['confirmNP'];
    if($newPass == $confirmNP) {
        $sql1 = "SELECT password
                 FROM User
                 WHERE uid=$uid";
        $res1 = $db->query($sql1);
        $passRow = $res1->fetch();
        $password = $passRow['password'];
        if($currPass == $password) {
            $sql2 = "UPDATE User
                     SET password='$newPass'
                     WHERE uid=$uid";
            $res2 = $db->query($sql2);
            if($res2 == TRUE) {
                echo "<H1>Password Reset</H1>";
            } else {
                echo "<H1>Error Resetting Password</H1>";
            }
        } else {
            echo "<H1>Current password does not match input</H1>";
        }
    } else {
        echo "<H1>New password does not match</H1>";
    }
}

//Veysel
function makeComment($data, $db) {
    $noStars = $data['noStars'];
    $comment = $data['comment'];
    $uid = $data['uid'];
    $gameid = $data['gameid'];
    $sql = "INSERT INTO Reviewed(noStars, comments, uid, gameid)
     VALUE($noStars, '$comment', $uid, $gameid)";

    $res = $db->query($sql);
    if($res == FALSE) {
        header("refresh:5;url=test.php");
        echo ("<H3>There has been a problem with your comment. Please try again.</H3>\n");
    }
}

//Veysel
function getGameComments($db, $gameid) {
    $sql = "SELECT * 
		FROM Reviewed
		WHERE gameid = $gameid";

    $res = $db->query($sql);
    return $res;
}

//Veysel
function getTeamComments($db, $teamid) {
    $sql = "SELECT * 
		FROM Reviewed 
		WHERE gameid IN	(SELECT gameid 
				FROM Games
				WHERE teamid1 = $teamid OR teamid2 = $teamid)";

    $res = $db->query($sql);
    return $res;
}

//Veysel
function getPlayerComments($db, $playerid) {
    $sql = "SELECT * 
	FROM Reviewed NATURAL JOIN User
	WHERE gameid IN	(SELECT gameid 
			FROM Games AS RevTable
			WHERE teamid1 IN 	(SELECT teamid
						FROM Player NATURAL JOIN Plays_in
						WHERE playerid = $playerid AND 
						RevTable.gdate > Plays_in.startDate AND
						(Plays_in.endDate IS NULL OR RevTable.gdate < Plays_in.endDate))
						OR
			teamid2 IN		(SELECT teamid
						FROM Player NATURAL JOIN Plays_in
						WHERE playerid = $playerid AND 
						RevTable.gdate > Plays_in.startDate AND
						(Plays_in.endDate IS NULL OR RevTable.gdate < Plays_in.endDate)))";

    $res = $db->query($sql);
    return $res;
}

function genGameData($db, $sport) {
    echo "<div style='overflow-x:auto;'>";
    echo "<CENTER>";
    echo "<H3>Games: </H3>";

    $sql = "SELECT t1.teamid AS tid1, t2.teamid AS tid2, t1.name AS team1, t2.name AS team2, location, gdate, l.name AS leagueName, gameid
           FROM Games NATURAL JOIN League l
           JOIN Team t1 ON teamid1=t1.teamid 
           JOIN Team t2 ON teamid2=t2.teamid
           ORDER BY gdate";
    $res = $db->query($sql);

    if($res == TRUE) {
        echo "<TABLE class='data-table'>";
        echo "<TR><TH>Date</TH><TH>Location</TH><TH>Team 1</TH><TH>Team 2</TH><TH>League</TH><TH>Stats</TH><TH>Comment</TH></TR>";
        $i = 1;
        while($row = $res->fetch()) {
            echo "<FORM name='fm_$i' action='?op=moreInfo' method='POST'>";
            $date = $row['gdate'];
            $location = $row['location'];
            $team1 = $row['team1'];
            $team2 = $row['team2'];
            $league = $row['leagueName'];
            $gameid = $row['gameid'];

            //Huy
            $tid1 = $row['tid1'];
            $tid2 = $row['tid2'];

            echo "<TR>
                  <TD>$date</TD>
                  <TD>$location</TD>
                  <TD class='table-highlight'><a class='link' href='?tid=$tid1'>$team1</a></TD>
                  <TD class='table-highlight'><a class='link' href='?tid=$tid2'>$team2</a></TD>
                  <TD>$league</TD>
                  <TD>
                      <INPUT type='hidden' name='date' value='$date'>
                      <INPUT type='hidden' name='location' value='$location'>
                      <INPUT type='hidden' name='team1' value='$team1'>
                      <INPUT type='hidden' name='team2' value='$team2'>
                      <INPUT type='hidden' name='league' value='$league'>
                      <BUTTON type='submit' name='more_info'>More Info</BUTTON>
                      </FORM>
                  </TD>
                  <TD>
                    <FORM style='margin: 0px' name='makeComment_$i' action='?op=genComment' method='POST'>
                        <INPUT type='hidden' name='gameid' value='$gameid'>
                        <BUTTON type='submit' name='makeCom'> Make Comment</BUTTON>
                    </FORM>
                  </TD>
                  </TR>";
            ++$i;
        }

        echo "</TABLE>";
    } else {
        echo "Error in query!";
    }

    echo "</CENTER>";
    echo "</div>";
}

//Charlie
function genMoreInfo($db, $fmData) {
    $date = $fmData['date'];
    $team1 = $fmData['team1'];
    $team2 = $fmData['team2'];


    $team1idsql =   "SELECT teamid
                    FROM Team
                    WHERE name = '$team1'";
   
    $team1idRes = $db->query($team1idsql);


    $team2idsql =   "SELECT teamid
                    FROM Team
                    WHERE name = '$team2'";
   
    $team2idRes = $db->query($team2idsql);

    $team1idRow = $team1idRes->fetch();
    $team1id = $team1idRow['teamid'];

    $team2idRow = $team2idRes->fetch();
    $team2id = $team2idRow['teamid'];

    //Queries by Veysel
    $sql1 = "SELECT CONCAT(fname, ' ', lname) AS name, SUM(score) AS ptsScored
             FROM Player NATURAL JOIN Plays_in
             NATURAL JOIN Scored
             WHERE teamid = $team1id AND gameid IN (SELECT gameid
                                                    FROM Games
                                                    WHERE gdate = '$date')
             GROUP BY playerid";

    $sql2 = "SELECT CONCAT(fname, ' ', lname) AS name, SUM(score) AS ptsScored
             FROM Player NATURAL JOIN Plays_in
             NATURAL JOIN Scored
             WHERE teamid = $team2id AND gameid IN (SELECT gameid
                                                    FROM Games
                                                    WHERE gdate = '$date')
             GROUP BY playerid";

    $res1 = $db->query($sql1);
    $res2 = $db->query($sql2);

    echo "<CENTER>";
    echo "<H3>Players from $team1</H3>";
    while($row = $res1->fetch()) {
        $name1 = $row['name'];
        $ptsScored1 = $row['ptsScored'];
        echo "<TABLE class='data-table'>";
        echo "<TR><TH>Player Name</TH><TH>Points Scored</TH></TR>";
        echo "<TR><TD>$name1</TD><TD>$ptsScored1</TD></TR>";
        echo "</TABLE>";
    }

    echo "<H3>Players from $team2</H3>";
    while($row = $res2->fetch()) {
        $name2 = $row['name'];
        $ptsScored2 = $row['ptsScored'];
        echo "<TABLE class='data-table'>";
        echo "<TR><TH>Player Name</TH><TH>Points Scored</TH></TR>";
        echo "<TR><TD>$name2</TD><TD>$ptsScored2</TD></TR>";
        echo "</TABLE>";
    }
    echo "</CENTER>";
}

function genComment($db, $GameData) {
    $gameid = $GameData['gameid'];
    $uid = $_SESSION['uid'];

    echo "<div style='margin: 20px auto; max-width: 600px;'>";
    echo "<CENTER>";
    echo "<form name='makeComment' action='?op=makeComment' method='POST'>";
    echo "<h3 style='margin-bottom: 10px;'>Number of Stars:</h3>";
    echo "<input style='font-size: 16px; padding: 8px;' type='text' name='noStars' placeholder='Stars' />";
    echo "<h3 style='margin-top: 20px; margin-bottom: 10px;'>Comments:</h3>";
    echo "<textarea style='font-size: 16px; padding: 8px; width: 100%;' name='comment' rows='4' placeholder='Enter your comment'></textarea>";
    echo "<br /><br />";
    echo "<button style='background-color: #FF8C8C; color: white; font-size: 16px; padding: 8px 20px; border: none; cursor: pointer;'>Submit</button>";
    echo "<input type='hidden' name='uid' value='$uid' />";
    echo "<input type='hidden' name='gameid' value='$gameid' />";
    echo "</form>";
    echo "</CENTER>";
    echo "</div>";
}

// Veysel
function getPlayerTeams($db, $playerid) {
    $sql = "SELECT teamid, city, name, endDate, startDate
	FROM Plays_in NATURAL JOIN Team
	WHERE playerid = $playerid";

    $res = $db->query($sql);
    return $res;
}

// Veysel
function getBasketballPlayerSpecs($db, $playerid) {
    $sql = "SELECT height, shoeSize
	FROM Player NATURAL JOIN Basketball
	WHERE playerid = $playerid";

    $res = $db->query($sql);
    return $res;
}

// Veysel
function getPlayerTotalScore($db, $playerid) {
    $sql = "SELECT SUM(score) AS totalScore
	FROM Scored
	WHERE playerid = $playerid";

    $res = $db->query($sql);
    return $res;
}

// Veysel
function getPlayerMostScoreType($db, $playerid) {
    $sql = "SELECT scoreType
			FROM Scored
			WHERE playerid = $playerid
			GROUP BY scoreType
			HAVING COUNT(*) >= ALL 	(SELECT COUNT(*)
									FROM Scored
									WHERE playerid = $playerid
									GROUP BY scoreType)";

    $res = $db->query($sql);
    return $res;
}

// Veysel
function getPlayerNoGames($db, $playerid) {
    $sql = "SELECT COUNT(gameid)
	FROM Player NATURAL JOIN Plays_in JOIN Games ON 
	(Plays_in.teamid = Games.teamid1 OR Plays_in.teamid = Games.teamid2) AND
	(Plays_in.startDate < Games.gdate AND (Plays_in.endDate IS NULL OR Plays_in.endDate > Games.gdate))
	WHERE playerid = $playerid";

    $res = $db->query($sql);
    return $res;
}

// Veysel
function getPlayerScorePerGame($db, $fmData) {


    $date = $fmData['date'];
    $team1 = $fmData['team1'];
    $team2 = $fmData['team2'];


    $sql = "SELECT CONCAT(fname, ' ', lname) AS name, SUM(score) AS ptsScored
            FROM Player NATURAL JOIN Scored
            WHERE gameid IN     (SELECT gameid
                                FROM Games
                                WHERE (teamid1 = $team1 OR teamid1 = $team2) AND (teamid2 = $team1 OR teamid2 = $team2) AND (gdate = $date))
            GROUP BY playerid";

    $res = $db->query($sql);
    return $res;
}
