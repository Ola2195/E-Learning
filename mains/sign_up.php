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

if(isset($_POST['create'])) {
    $field = array(
        'role' => $_POST['roles'],
        'email' => $_POST['email'],
        'name' => $_POST['name'],
        'surname' => $_POST['surname'],
        'gender' => $_POST['gender'],
        'password' => $_POST['password'],
        'passwordAgain' => $_POST['cpassword'],
        'phone' => $_POST['phone'],
        'birth' => $_POST['birth']
    );
    if($data->requied_validation($field)) {
        $field = array(
            'role' => $_POST['roles'],
            'email' => $_POST['email'],
            'name' => $_POST['name'],
            'surname' => $_POST['surname'],
            'gender' => $_POST['gender'],
            'password' => hash('ripemd160', $_POST['password']),
            'passwordAgain' => hash('ripemd160', $_POST['cpassword']),
            'phone' => $_POST['phone'],
            'birth' => $_POST['birth'],
            'level' => $_POST['level']
        );   
        if($data->email_validation($_POST['email'])) {
            if($data->pass($field)) {
                if($data->exist($_POST['email'])) {
                    session_start();
                    $data->createUser($field);
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
    <div id="register" class="modal">
        <div class="modal_contener">
            <a href="../index.php"><span class="close">&times;</span></a>
            <h2>REGISTER</h2>
            <form id="form" method="POST">
                <p id="alert">
                    <?php
                        if(isset($message)){
                            echo $message;
                        }
                    ?>
                </p>
                <div class="roles" onclick="checkRole()">
                    <input type="radio" id="student" name="roles" value="uczen">
                        <label for="student">STUDENT<br>
                        <img src="../img/student.png"></label>
                </div>
                <div class="roles" onclick="checkRole()">
                    <input type="radio" id="teacher" name="roles" value="nauczyciel">
                        <label for="teacher">TEACHER<br>
                        <img src="../img/teacher.png"></label>
                </div>
                <input class="text half1" type="text" name="name" placeholder="First Name">
                <input class="text half2" type="text" name="surname" placeholder="Surname"><br>
                <select class="text" name="gender">
                    <option selected  value="">GENDER</option>
                    <option value="kobieta">Female</option>
                    <option value="mezczyzna">Male</option>
                </select>
                <input class="text" type="text" name="email" placeholder="E-mail"><br>
                <input class="text" type="password" name="password" placeholder="Password"><br>
                <input class="text" type="password" name="cpassword" placeholder="Confirm Password"><br>
                <input class="text half1" type="text" name="phone" placeholder="Phone Number">
                <input class="text half2" type="date" name="birth" placeholder="Date od Birth"><br>
                <select class="text" id="level" name="level">
                    <option value="podstawowa">Primary School</option>
                    <option value="srednia">Secondary School</option>
                    <option value="studia">University</option>
                </select>
                <button class="submit_register" name="create">SIGN UP</button><br>
            </form>
        </div>
    </div>
</body>
<script src="../js/script.js"></script>