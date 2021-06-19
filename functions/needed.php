<?php
class Database_Need {
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

    public function datas_user($email) {
        $stmt = $this->con->prepare("SELECT * FROM uzytkownik WHERE email = :email");
        $stmt -> bindParam(':email', $email, PDO::PARAM_STR);
        $stmt -> execute();
        $user = $stmt->fetch();
        return $user;
    }
    public function datas_user_id($id) {
        $stmt = $this->con->prepare("SELECT * FROM uzytkownik WHERE id_uzytkownika = :id");
        $stmt -> bindParam(':id', $id, PDO::PARAM_STR);
        $stmt -> execute();
        $user = $stmt->fetch();
        return $user;
    }
    public function datas_student($id) {
        $stmt = $this->con->prepare("SELECT * FROM uczniowie WHERE id_ucznia = :id");
        $stmt -> bindParam(':id', $id, PDO::PARAM_STR);
        $stmt -> execute();
        $student = $stmt->fetch();
        return $student;
    }
    public function datas_teacher($id) {
        $stmt = $this->con->prepare("SELECT * FROM nauczyciele WHERE id_nauczyciela = :id");
        $stmt -> bindParam(':id', $id, PDO::PARAM_STR);
        $stmt -> execute();
        $teacher = $stmt->fetch();
        return $teacher;
    }
    public function datas_birth($email) {
        $stmt = $this->con->prepare("SELECT TIMESTAMPDIFF(YEAR, data_urodzenia, CURDATE()) AS wiek FROM uzytkownik WHERE email = :email");
        $stmt -> bindParam(':email', $email, PDO::PARAM_STR);
        $stmt -> execute();
        $age = $stmt->fetch();
        return $age;
    }
    public function datas_subjects($id) {
        $stmt = $this->con->prepare("SELECT przedmiot, poziom_nauczania, koszt FROM przedmiot WHERE id_nauczyciela = :id");
        $stmt -> bindParam(':id', $id, PDO::PARAM_STR);
        $stmt -> execute();
        $stmt -> bindColumn('przedmiot', $przedmiot);
        $stmt -> bindColumn('poziom_nauczania', $poziom);
        $stmt -> bindColumn('koszt', $koszt);
        $subjects = [];
        while ($stmt->fetch(PDO::FETCH_BOUND)) {
            array_push($subjects, (object)[
                'przedmiot' => $przedmiot,
                'poziom' => $poziom,
                'koszt' => $koszt
            ]);
        }
        return $subjects;
    }
    public function edit_datas($id, $role, $field) {
        $name = $field['name'];
        $surname = $field['surname'];
        $gender = $field['gender'];
        $phone = $field['phone'];
        $birth = $field['birth'];
        $place = $field['place'];

        $stmt = $this->con->prepare("UPDATE uzytkownik SET imie = :imie, nazwisko = :nazwisko, plec = :plec, telefon = :telefon, data_urodzenia = :data, miejsce_zamieszkania = :miejsce WHERE id_uzytkownika = :id");
        $stmt -> bindParam(':imie', $name, PDO::PARAM_STR);
        $stmt -> bindParam(':nazwisko', $surname, PDO::PARAM_STR);
        $stmt -> bindParam(':plec', $gender, PDO::PARAM_STR);
        $stmt -> bindParam(':telefon', $phone, PDO::PARAM_STR);
        $stmt -> bindParam(':data', $birth, PDO::PARAM_STR);
        $stmt -> bindParam(':miejsce', $place, PDO::PARAM_STR);
        $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
        $stmt -> execute();

        if($role == 1) {
            $level = $field['level'];
            $stmt = $this->con->prepare("UPDATE uczniowie SET poziom_nauczania = :poziom WHERE id_ucznia = :id");
            $stmt -> bindParam(':poziom', $level, PDO::PARAM_STR);
            $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
            $stmt -> execute();
        }

        if($role == 2) {
            $opis = $field['description'];
            $stmt = $this->con->prepare("UPDATE nauczyciele SET opis = :opis WHERE id_nauczyciela = :id");
            $stmt -> bindParam(':opis', $opis, PDO::PARAM_STR);
            $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
            $stmt -> execute();
        }
    }
    public function theBestTutors() {
        $stmt = $this->con->prepare("SELECT uzytkownik.email, uzytkownik.imie, uzytkownik.nazwisko, uzytkownik.plec, nauczyciele.ocena FROM uzytkownik INNER JOIN nauczyciele ON uzytkownik.id_uzytkownika = nauczyciele.id_nauczyciela WHERE uzytkownik.rola = 2 ORDER BY 'ocena' DESC LIMIT 19");
        $stmt -> execute();
        $stmt -> bindColumn('email', $email);
        $stmt -> bindColumn('imie', $imie);
        $stmt -> bindColumn('nazwisko', $nazwisko);
        $stmt -> bindColumn('plec', $plec);
        $stmt -> bindColumn('ocena', $ocena);
        $teacher = [];
        while ($stmt->fetch(PDO::FETCH_BOUND)) {
            array_push($teacher, (object)[
                'email' => $email,
                'imie' => $imie,
                'nazwisko' => $nazwisko,
                'plec' => $plec,
                'ocena' => $ocena,
            ]);
        }
        return $teacher;
    }
}
?>