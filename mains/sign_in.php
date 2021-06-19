<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Lerning</title>
    <link rel="icon" href="../img/icon.png" type="image/png" sizes="16x16"> 
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/login_register.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<?php
include('../functions/login_register.php');
$data = new Database;
$massage = '';

if(isset($_POST['login'])) {
    $massage = '';
    $field = array(
        'email' => $_POST['email'],
        'password' => $_POST['password']
    );
    if($data->requied_validation($field)) { 
        $field = array(
            'email' => $_POST['email'],
            'password' => hash('ripemd160', $_POST['password'])
        );
        if($data->can_login($field)) {
            session_start();
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['role'] = $data->roles($field);
            header("location: ../myprofil.php?email=".$_SESSION['email']);
        }
        else {
            $message = $data->error;
        }
    }
    else {
        $message = $data->error;
    }
}
?>

<body>
    <div id="logIn" class="modal">
        <div class="modal_contener">
            <a href="../index.php"><span class="close">&times;</span></a>
            <h2>LOG IN</h2>
            <form id="form" method="POST">
                <p id="alert">
                    <?php
                        if(isset($message)){
                            echo $message;
                        }
                    ?>
                </p>
                <input class="text" type="text" name="email" placeholder="E-mail"><br>
                <input class="text" type="password" name="password" placeholder="Password"><br>
                <button class="submit_login" name="login">SIGN IN</button><br>
                <p>Forgot your password? <a href="#">Click here</a></p>
                <p>Don't have an account? <a href="sign_up.php">Sign up</a></p>
            </form>
        </div>
    </div>
</body>