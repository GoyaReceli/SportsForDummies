<?php
include("util.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="dashboard.css">
    <title>Dashboard</title>

    <?php
    $op = "dummy";
    if (isset($_GET['op'])) {
        $op = $_GET['op'];
        if ($op == 'login') {
            $_SESSION['uid'] = getUid($db, $_POST);
        } elseif ($op == 'logout') {
            $uid = 0;
            unset($_SESSION['uid']);
        }
    }
    ?>

</head>

<body>
    <div class="navbar">
        <div style="display: flex; align-content: center;">
            <a href="?op=dummy" style="margin: auto 40px">
                <img src="logo.png" style="width: 108px; height: 93px; margin-right: px; " />
            </a>

            <a href="?op=dummy" style="text-align: center; margin: auto 0px; font-size: 30px; text-decoration: none">
                <font style="color:black">S P</font>
                <font style="color:red">O R T S </font>
                <font style="color:black">F O R </font>
                <font style="color:black"> D U</font>
                <font style="color:red">M M I E S</font>

            </a>
        </div>
        <div style="display: flex;">
            <div style="display:flex; text-align: center; margin: auto 0px;">
                <a href="?op=abt&uid=<?php echo $_SESSION['uid'] ?>" class="navbardir">About me</a>
                <a href="" class="navbardir">Services</a>
                <a href="" class="navbardir">Projects</a>
            </div>
            <div class="user">
                <div class="user-icon">
                    <a href='?op=abt&uid=<?php echo $_SESSION['uid']; ?>'>
                        <i class="fa fa-circle-user" style="font-size: 35px;"></i>
                    </a>
                </div>

                <?php
                if (isset($_SESSION['uid'])) {
                    // User is logged in, show logout button
                    $uname = getName($db, $_SESSION['uid']);
                    showLogoutForm($uname);
                } else {
                ?>
                    <div class="login-reminder">
                        <p>Please login or sign up</p>
                    </div>
                <?php
                }
                ?>
            </div>

        </div>
    </div>

    <div style="margin-left: 13%">
        <div class="sportSelect">
            <select name="sport">
                <option value="basketball">Basketball</option>
            </select>
        </div>

        <div>
            <div>
                <a class="section" href="?op=team" <?php echo isActive('team', $_GET); ?>>
                    Team
                </a>
                <a class="section" href="?op=player" <?php echo isActive('player', $_GET); ?>>
                    Player
                </a>
                <a class="section" href="?op=game" <?php echo isActive('game', $_GET); ?>>
                    Game
                </a>
            </div>
        </div>

        <!-- Content -->
        <div class="content">

            <?php
            if (isset($_GET['op'])) {
                $op = $_GET['op'];
            }


            if (!isset($_SESSION['uid'])) {
                // User is not logged in, show login form
                showLoginForm($db);
            } else {
                if (isset($_GET['tid'])) {
                    displayTeamPlayers($db, $_GET['tid']);
                } else if ($op == "signUp") {
                    genSignUp();
                } else if ($op == "signedUp") {
                    genSignedUp($db, $_POST);
                } else if ($op == "abt") {
                    $user = $_GET['uid'];

                    if ($user == $_SESSION['uid']) {
                        genAbtMe($db, $user);
                    } else {
                        genAbt($db, $user);
                    }
                } else if ($op == "resetPass") {
                    genResetPass();
                } else if ($op == "validateReset") {
                    validateReset($db, $_POST);
                } else if ($op == "moreInfo") {
                    genMoreInfo($db, $_POST);
                } else if ($op == "genComment") {
                    genComment($db, $_POST);
                } else if ($op == "makeComment") {
                    makeComment($_POST, $db);
                } else if (isset($_GET['playerComment'])) {
                    genPlayerComments($db, $_GET['playerComment']);
                } else if ($op == "team") {
                    displaySportTeam($db, $sport);
                } else if ($op == "player") {
                    displayAllPlayers($db, $sport);
                } else if ($op == "game") {
                    genGameData($db, $sport);
                } else {
                    genDummyInfo();
                }
            }

            ?>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div style="display: flex; justify-content: center; margin: auto 0; font-weight: bold; font-size: 15px">
                <a class="footerdir" href="" style="width: 96px; height: 24px;">Youth team</a>
                <a class="footerdir" href="" style="width: 96px; height: 24px;">Support</a>
                <a class="footerdir" href="" style="width: 96px; height: 24px;">Contact</a>
                <a class="footerdir" href="" style="width: 96px; height: 24px;">Blog</a>
                <a class="footerdir" href="" style="width: 96px; height: 24px;">FAQ</a>
            </div>

            <div style="display: flex; justify-content: center;">
                <div style="width: 35px; height: 35px; margin: 12px; border-radius: 50%; background-color: red">
                    <i class="fa-brands fa-instagram" style="font-size: 22px; color: white; margin-top: 6px"></i>
                </div>
                <div style="width: 35px; height: 35px; margin: 12px; border-radius: 50%; background-color: red">
                    <i class="fa-brands fa-linkedin-in" style="font-size: 22px; color: white; margin-top: 6px"></i>
                </div>
                <div style="width: 35px; height: 35px; margin: 12px; border-radius: 50%; background-color: red">
                    <i class="fa-brands fa-facebook-f" style="font-size: 22px; color: white; margin-top: 6px"></i>
                </div>
                <div style="width: 35px; height: 35px; margin: 12px; border-radius: 50%; background-color: red">
                    <i class="fa-brands fa-youtube" style="font-size: 22px; color: white; margin-top: 6px"></i>
                </div>
                <div style="width: 35px; height: 35px; margin: 12px; border-radius: 50%; background-color: red">
                    <i class="fa-brands fa-twitter" style="font-size: 22px; color: white; margin-top: 6px"></i>
                </div>
            </div>
            <p style="color: #92989F; font-size: 12px;">Design by © Huy Ngo 2023. All right reserved</p>
        </div>
    </div>
</body>

</html>