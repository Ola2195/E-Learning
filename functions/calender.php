<?php
class Database_Calender {
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

    public function find_nauczanie_nauczyciel($id) {
        $stmt = $this->con->prepare("SELECT * FROM nauczanie WHERE id_nauczyciela = :id");
        $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
        $stmt -> execute();
        $stmt -> bindColumn('id_nauczania', $id_nauczania);
        $stmt -> bindColumn('id_nauczyciela', $id_nauczyciela);
        $stmt -> bindColumn('id_ucznia', $id_ucznia);
        $nauczanie = [];
        while ($stmt->fetch(PDO::FETCH_BOUND)) {
            array_push($nauczanie, (object)[
                'id_nauczania' => $id_nauczania,
                'id_nauczyciela' => $id_nauczyciela,
                'id_ucznia' => $id_ucznia
            ]);
        }
        return $nauczanie;
    }
    public function find_nauczanie_uczen($id) {
        $stmt = $this->con->prepare("SELECT * FROM nauczanie WHERE id_ucznia = :id");
        $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
        $stmt -> execute();
        $stmt -> bindColumn('id_nauczania', $id_nauczania);
        $stmt -> bindColumn('id_nauczyciela', $id_nauczyciela);
        $stmt -> bindColumn('id_ucznia', $id_ucznia);
        $nauczanie = [];
        while ($stmt->fetch(PDO::FETCH_BOUND)) {
            array_push($nauczanie, (object)[
                'id_nauczania' => $id_nauczania,
                'id_nauczyciela' => $id_nauczyciela,
                'id_ucznia' => $id_ucznia
            ]);
        }
        return $nauczanie;
    }
    public function find_zajecia($id, $start, $end) {
        $start = date_create($start);
        $start = date_format($start, 'Y-m-d');
        $end = date_create($end);
        $end = date_format($end, 'Y-m-d');
        $stmt = $this->con->prepare("SELECT * FROM zajecia WHERE id_nauczania = :id AND dzien > '$start' AND dzien < '$end'");
        $stmt -> bindParam(':id', $id, PDO::PARAM_STR);
        $stmt -> execute();
        $stmt -> bindColumn('id_spotkania', $id_spotkania);
        $stmt -> bindColumn('id_nauczania', $id_nauczania);
        $stmt -> bindColumn('przedmiot', $przedmiot);
        $stmt -> bindColumn('powtarzalne', $powtarzalne);
        $stmt -> bindColumn('dzien', $dzien);
        $stmt -> bindColumn('dzien_tygodnia', $dzien_tygodnia);
        $stmt -> bindColumn('godzina', $godzina);
        $stmt -> bindColumn('czas', $czas);
        $stmt -> bindColumn('opis', $opis);
        $stmt -> bindColumn('zoom', $zoom);
        $zajecia = array();
        while ($stmt->fetch(PDO::FETCH_BOUND)) {
            array_push($zajecia, (object)[
                'id_spotkania' => $id_spotkania,
                'id_nauczania' => $id_nauczania,
                'przedmiot' => $przedmiot,
                'powtarzalne' => $powtarzalne,
                'dzien' => $dzien,
                'dzien_tygodnia' => $dzien_tygodnia,
                'godzina' => $godzina,
                'czas' => $czas,
                'opis' => $opis,
                'zoom' => $zoom
            ]);
        }
        return $zajecia;
    }
    public function color($przedmiot) {
        if($przedmiot == 'plastyka') {
            $color = '#b52020';
        }
        if($przedmiot == 'biologia') {
            $color = '#2b8223';
        }
        if($przedmiot == 'chemia') {
            $color = '#513b71';
        }
        if($przedmiot == 'chiński') {
            $color = '#ba3434';
        }
        if($przedmiot == 'angielski') {
            $color = '#2c49a2';
        }
        if($przedmiot == 'francuski') {
            $color = '#ad2451';
        }
        if($przedmiot == 'geografia') {
            $color = '#dc642a';
        }
        if($przedmiot == 'niemiecki') {
            $color = '#dcc02a';
        }
        if($przedmiot == 'historia') {
            $color = '#5b2d80';
        }
        if($przedmiot == 'historia sztuki') {
            $color = '#b34985';
        }
        if($przedmiot == 'informatyka') {
            $color = '#49aeb3';
        }
        if($przedmiot == 'włoski') {
            $color = '#9a1a1a';
        }
        if($przedmiot == 'matematyka') {
            $color = '#1a9a58';
        }
        if($przedmiot == 'fizyka') {
            $color = '#2c536b';
        }
        if($przedmiot == 'polski') {
            $color = '#c63356';
        }
        if($przedmiot == 'portugalski') {
            $color = '#469530';
        }
        if($przedmiot == 'rosyjski') {
            $color = '#c42d2d';
        }
        if($przedmiot == 'hiszpański') {
            $color = '#e4b526';
        }
        
        return $color;
    }
    public function grade($id) {
        $stmt = $this->con->prepare("SELECT id_nauczania FROM nauczanie WHERE id_nauczania = :id AND czy_ocena is not TRUE");
        $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
        $stmt -> execute();
        $zajecia = $stmt->fetch();
        if($zajecia) {
            $stmt = $this->con->prepare("SELECT id_nauczania FROM zajecia WHERE id_nauczania = :id AND ( dzien = CURDATE()-1 OR ( dzien = CURDATE() AND godzina < CURTIME() ))");
            $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
            $stmt -> execute();
            $ocena = $stmt->fetch();
            return $ocena[0];
        }
    }
    public function teacher_grade($id) {
        $stmt = $this->con->prepare("SELECT id_nauczyciela FROM nauczanie WHERE id_nauczania = :id");
        $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
        $stmt -> execute();
        $teacher = $stmt->fetch();
        return $teacher[0];
    }
    public function add_grade($add, $id, $id_tutor) {
        $stmt = $this->con->prepare("UPDATE nauczanie SET czy_ocena = 1 WHERE id_nauczania = :id");
        $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
        $stmt -> execute();

        $stmt = $this->con->prepare("SELECT ocena, ilosc_ocen FROM nauczyciele WHERE id_nauczyciela = :id");
        $stmt -> bindParam(':id', $id_tutor, PDO::PARAM_INT);
        $stmt -> execute();
        $ocena = $stmt->fetch();

        $new_ocena = ($ocena['ocena'] * $ocena['ilosc_ocen'] + $add) / ($ocena['ilosc_ocen'] + 1);
        $new_ilosc = $ocena['ilosc_ocen'] + 1;

        $stmt = $this->con->prepare("UPDATE nauczyciele SET ocena = $new_ocena, ilosc_ocen = $new_ilosc WHERE id_nauczyciela = $id_tutor");
        $stmt -> execute();
    }
    public function find_files($id) {
        $stmt = $this->con->prepare("SELECT id_materialu, id_nauczania, nazwa, data, typ FROM materialy WHERE id_nauczania = :id");
        $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
        $stmt -> execute();
        $stmt -> bindColumn('id_materialu', $id_materialu);
        $stmt -> bindColumn('id_nauczania', $id_nauczania);
        $stmt -> bindColumn('nazwa', $nazwa);
        $stmt -> bindColumn('data', $data);
        $stmt -> bindColumn('typ', $typ);
        $files = [];
        while ($stmt->fetch(PDO::FETCH_BOUND)) {
            array_push($files, (object)[
                'id_materialu' => $id_materialu,
                'id_nauczania' => $id_nauczania,
                'nazwa' => $nazwa,
                'data' => $data,
                'typ' => $typ
            ]);
        }
        return $files;
    }
    public function add_files($data_file) {
        try {
            $stmt = $this->con->prepare("INSERT INTO materialy (id_nauczania, nazwa, data, typ, material) VALUES(:id, :name, :data, :type, :material)");
            $stmt -> bindParam(':id', $data_file['id'], PDO::PARAM_INT);
            $stmt -> bindParam(':name', $data_file['name'], PDO::PARAM_STR);
            $stmt -> bindParam(':data', $data_file['data'], PDO::PARAM_STR);
            $stmt -> bindParam(':type', $data_file['type'], PDO::PARAM_STR);
            $stmt -> bindParam(':material', $data_file['material']);
            $stmt -> execute();
        }
        catch(PDOException $e) {
            
        }
    }
    
}