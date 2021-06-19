<?php
include('calender.php');
$calendar = new Database_Calender;

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    $subject = $_POST['subject'];
    $sql = "SELECT przedmiot, poziom_nauczania, koszt FROM przedmiot WHERE id_nauczyciela = :id AND przedmiot = :subject";
    $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
    $stmt -> bindParam(':subject', $subject, PDO::PARAM_STR);
    $subject = [];
    while ($stmt->fetch(PDO::FETCH_BOUND)) {
        array_push($subject, (object)[
            'przedmiot' => $przedmiot,
            'poziom_nauczania' => $poziom,
            'koszt' => $koszt,
        ]);
    }
    $subjects = [];
    $cost1 = 0;
    $cost2 = 0;
    $cost3 = 0;
    foreach($subject as $object => $kolumn) {
        if($kolumn->poziom == 'podstawowa') {
            $cost1 = $value->koszt;
        }
        if($kolumn->poziom == 'srednia') {
            $cost2 = $value->koszt;
        }
        if($kolumn->poziom == 'studia') {
            $cost3 = $value->koszt;
        }
    }
    array_push($subjects, (object)[
        'id_nauczyciela' => $id,
        'przedmiot' => $subject,
        'cost1' => $cost1,
        'cost2' => $cost2,
        'cost3' => $cost3,
    ]);
    $cost1 = 0;
    $cost2 = 0;
    $cost3 = 0;
    return $subjects;
}
?>