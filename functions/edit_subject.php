<?php
    include('calender.php');
    $calendar = new Database_Calender;

    $id = $_POST['id'];
    $subject= $_POST['subject'];
    $cost1= $_POST['cost1'];
    $cost2= $_POST['cost2'];
    $cost3= $_POST['cost3'];

    if($cost1!="") {
        $level = 'podstawowa';
        $stmt = $calendar->con->prepare("UPDATE przedmiot SET id_nauczyciela = :id, przedmiot = :subject, poziom_nauczania = :level, koszt = :cost)");
        $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
        $stmt -> bindParam(':subject', $subject, PDO::PARAM_STR);
        $stmt -> bindParam(':level', $level, PDO::PARAM_STR);
        $stmt -> bindParam(':cost', $cost1, PDO::PARAM_INT);
        $stmt -> execute();
    }
    if($cost2!="") {
        $level = 'srednia';
        $stmt = $calendar->con->prepare("UPDATE przedmiot SET id_nauczyciela = :id, przedmiot = :subject, poziom_nauczania = :level, koszt = :cost WHERE )");
        $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
        $stmt -> bindParam(':subject', $subject, PDO::PARAM_STR);
        $stmt -> bindParam(':level', $level, PDO::PARAM_STR);
        $stmt -> bindParam(':cost', $cost2, PDO::PARAM_INT);
        $stmt -> execute();
    }
    if($cost3!="") {
        $level = 'studia';
        $stmt = $calendar->con->prepare("UPDATE przedmiot SET id_nauczyciela = :id, przedmiot = :subject, poziom_nauczania = :level, koszt = :cost)");
        $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
        $stmt -> bindParam(':subject', $subject, PDO::PARAM_STR);
        $stmt -> bindParam(':level', $level, PDO::PARAM_STR);
        $stmt -> bindParam(':cost', $cost3, PDO::PARAM_INT);
        $stmt -> execute();
    }

    if($cost1 == "") {
        $level = 'podstawowa';
        $stmt = $calendar->con->prepare("DELETE FROM przedmiot SET id_nauczyciela = :id, przedmiot = :subject, poziom_nauczania = :level, koszt = :cost)");
        $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
        $stmt -> bindParam(':subject', $subject, PDO::PARAM_STR);
        $stmt -> bindParam(':level', $level, PDO::PARAM_STR);
        $stmt -> bindParam(':cost', $cost1, PDO::PARAM_INT);
        $stmt -> execute();
    }
    if($cost2 == "") {
        $level = 'srednia';
        $stmt = $calendar->con->prepare("UPDATE przedmiot SET id_nauczyciela = :id, przedmiot = :subject, poziom_nauczania = :level, koszt = :cost)");
        $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
        $stmt -> bindParam(':subject', $subject, PDO::PARAM_STR);
        $stmt -> bindParam(':level', $level, PDO::PARAM_STR);
        $stmt -> bindParam(':cost', $cost2, PDO::PARAM_INT);
        $stmt -> execute();
    }
    if($cost3 == "") {
        $level = 'studia';
        $stmt = $calendar->con->prepare("UPDATE przedmiot SET id_nauczyciela = :id, przedmiot = :subject, poziom_nauczania = :level, koszt = :cost)");
        $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
        $stmt -> bindParam(':subject', $subject, PDO::PARAM_STR);
        $stmt -> bindParam(':level', $level, PDO::PARAM_STR);
        $stmt -> bindParam(':cost', $cost3, PDO::PARAM_INT);
        $stmt -> execute();
    }
    