<?php
class Database {
    public $con;
    public $error;
    public function __construct() {
        try{
            $this->con = new PDO("mysql:host=localhost;dbname=korepetycje", "root", "");
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->con->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
        }
        catch(PDOException $e) {   
            echo 'Coś poszło nie tak '.$e->getMessage();
        }
    }

    public function requied_validation($field) {
        foreach($field as $k => $v) {
            if(empty($v)) {
                $this->error = $v;  
                return false;       
            }
        }
        return true;
    }

    public function can_login($field) {
        $email = $field['email'];
        $password = $field['password'];
        $stmt = $this->con->prepare("SELECT * FROM uzytkownik WHERE email = :email AND haslo = :password");
        $stmt -> bindParam(':email', $email, PDO::PARAM_STR);
        $stmt -> bindParam(':password', $password, PDO::PARAM_STR);
        $stmt -> execute();
        if($stmt->rowCount()<=0) {
            $this->error = 'Wrong email or password';
        }
        else {
            return true;
        }
    }

    public function roles($field) {
        $email = $field['email'];
        $stmt = $this->con->prepare("SELECT rola FROM uzytkownik WHERE email = :email");
        $stmt -> bindParam(':email', $email, PDO::PARAM_STR);
        $stmt -> execute();
        $role = $stmt->fetch();
        return $role['name'];
    }

    public function email_validation($email) {
        if (preg_match('/[a-z|A-Z|0-9]+@[a-z|A-Z|0-9]+.[a-z|0-9]{1,4}/', $email)) {
            return true;
        }
        else {
            $this->error = 'Wrong email';
        }
    }

    public function pass($field) {
        if($field['password']==$field['passwordAgain']){
            return true;
        }
        else {
            $this->error = 'Repeat password correctly';
        }
    }

    public function exist($email) {
        $stmt = $this->con->prepare("SELECT email FROM uzytkownik WHERE email=:email");
        $stmt -> bindParam(':email', $email, PDO::PARAM_STR);
        $stmt -> execute();
        if($stmt->rowCount()==0) {
            return true;
        }
        else {
            $this->error = 'Exists some user with this email address already';
        }
    }

    public function createUser($field){
        $role = $field['role'];
        $email = $field['email'];
        $name = $field['name'];
        $surname = $field['surname'];
        $gender = $field['gender'];
        $password = $field['password'];
        $phone = $field['phone'];
        $birth = $field['birth'];
        $level = $field['level'];

        if($role=="uczen") {
            $stmt = $this->con->prepare("INSERT INTO uzytkownik (rola, email, imie, nazwisko, plec, haslo, telefon, data_urodzenia) VALUES (1, :email, :imie, :nazwisko, :plec, :haslo, :telefon, :data_urodzenia)");
            $stmt -> bindParam(':email', $email, PDO::PARAM_STR);
            $stmt -> bindParam(':imie', $name, PDO::PARAM_STR);
            $stmt -> bindParam(':nazwisko', $surname, PDO::PARAM_STR);
            $stmt -> bindParam(':plec', $gender, PDO::PARAM_STR);
            $stmt -> bindParam(':haslo', $password, PDO::PARAM_STR);
            $stmt -> bindParam(':telefon', $phone, PDO::PARAM_STR);
            $stmt -> bindParam(':data_urodzenia', $birth, PDO::PARAM_STR);
            $stmt -> execute();
            $last_id = $this->con->lastInsertId();
            $stmt = $this->con->prepare("INSERT INTO roles_pivot_table (user_id, role_id) VALUES (:user_id, 1)");
            $stmt -> bindParam(':user_id', $last_id, PDO::PARAM_INT);
            $stmt -> execute();
            $stmt = $this->con->prepare("INSERT INTO uczniowie (id_ucznia, poziom_nauczania) VALUES (:user_id, :level)");
            $stmt -> bindParam(':user_id', $last_id, PDO::PARAM_INT);
            $stmt -> bindParam(':level', $level, PDO::PARAM_STR);
            $stmt -> execute();
        }

        if($role=="nauczyciel") {
            $stmt = $this->con->prepare("INSERT INTO uzytkownik (rola, email, imie, nazwisko, plec, haslo, telefon, data_urodzenia) VALUES (2, :email, :imie, :nazwisko, :plec, :haslo, :telefon, :data_urodzenia)");
            $stmt -> bindParam(':email', $email, PDO::PARAM_STR);
            $stmt -> bindParam(':imie', $name, PDO::PARAM_STR);
            $stmt -> bindParam(':nazwisko', $surname, PDO::PARAM_STR);
            $stmt -> bindParam(':plec', $gender, PDO::PARAM_STR);
            $stmt -> bindParam(':haslo', $password, PDO::PARAM_STR);
            $stmt -> bindParam(':telefon', $phone, PDO::PARAM_STR);
            $stmt -> bindParam(':data_urodzenia', $birth, PDO::PARAM_STR);
            $stmt -> execute();
            $last_id = $this->con->lastInsertId();
            $stmt = $this->con->prepare("INSERT INTO roles_pivot_table (user_id, role_id) VALUES (:user_id, 2)");
            $stmt -> bindParam(':user_id', $last_id, PDO::PARAM_INT);
            $stmt -> execute();
            $stmt = $this->con->prepare("INSERT INTO nauczyciele (id_nauczyciela) VALUES (:teacher_id)");
            $stmt -> bindParam(':teacher_id', $last_id, PDO::PARAM_INT);
            $stmt -> execute();
        }
    }
}
?>