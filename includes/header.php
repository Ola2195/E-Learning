<?php
if(isset($_POST['signOut'])) {
    unset($_SESSION['email']);
    unset($_SESSION['role']);
    session_destroy();
    header("location: index.php");
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Learning</title>
    <link rel="icon" href="img/icon.png" type="image/png" sizes="16x16"> 
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/glider.css">
    <link rel="stylesheet" href="styles/profil.css">
    <link rel="stylesheet" href="styles/home.css">
    <link rel="stylesheet" href="styles/search.css">
    <link rel="stylesheet" href="styles/file.css">
    <link rel="stylesheet" href="styles/grade.css">
    <link rel="stylesheet" href="styles/set.css">
    <link rel="stylesheet" href="styles/modal.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">  
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.13/css/all.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/library/glide.core.css">
    <link rel="stylesheet" href="styles/library/glide.theme.css">
    <link rel="stylesheet" href="styles/library/main.css">
</head>
<body>
    <div class="header">
        <img id="sowa" src="img/sowa.png">
        <h1>E-Learning</h1>
        <div id="hamburger_menu" onclick="hamburger()"><i class="fas fa-bars"></i></div>
        <div id="menu-bar">
            <a class="menu menu_elements menu_text" href="index.php">Home</a>
            <a class="menu menu_elements menu_text" href="search.php">Search</a>
            <?php
                if(isset($_SESSION['email'])) {
            ?>
            <a class="menu menu_elements menu_text" href="files.php">My Files</a>
            <a class="menu menu_elements menu_text" href="myprofil.php?email=<?php echo($_SESSION['email'])?>">My Profile</a>
            <a id="settings" class="menu menu_elements" href="settings.php"><p class="settings_text">Settings</p><i id="settings_icon" class="fa fa-cog"></i></a>
            <form method="POST">
                <button class="menu_elements menu_elements_button" id="signOut" name="signOut">SIGN OUT</button>
            </form>
            <?php
                }
                else {
            ?>
            <a class="menu menu_elements" href="mains/sign_in.php"><button class="menu_elements_button" id="signIn">SIGN IN</button></a>
            <a class="menu menu_elements" href="mains/sign_up.php"><button class="menu_elements_button" id="signUp">SIGN UP</button></a>
            <?php
                }
            ?>
        </div>
    </div>