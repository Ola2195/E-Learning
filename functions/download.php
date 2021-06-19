<?php
    if(isset($_GET['id'])){
        include('calender.php');
        $calendar = new Database_Calender;
        $id = $_GET['id'];

        $stmt = $calendar->con->prepare("SELECT nazwa, typ, material FROM materialy WHERE id_materialu = :id");
        $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
        $stmt -> execute();
        $file = $stmt->fetch();
        $nazwa = $file['nazwa'];
        $typ = $file['typ'];

        header("Content-Type: $typ");
        header("Content-Disposition: attachment; filename=\"$nazwa\"");
        ob_clean();
        flush();
        echo $file['material'];
    }
