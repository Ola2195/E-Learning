<?php
    include('calender.php');
    $calender = new Database_Calender;
    include('needed.php');
    $base = new Database_Need;

    $start = $_POST['start'];
    $end = $_POST['end'];
    $id = $_POST['id'];
    $rola = $_POST['rola'];
    $email = $_POST['email'];
    $email_session = $_POST['email_session'];

    if($rola == 1) {
        $nauczanie = $calender->find_nauczanie_uczen($id);  
    }
    if($rola == 2) {
        $nauczanie = $calender->find_nauczanie_nauczyciel($id);
    }

    $json_zajecia = array();

    foreach($nauczanie as $object => $kolumna) {
        if($rola == 1) {
            $datas = $base->datas_user_id($kolumna->id_nauczyciela);
            $title = $datas['imie'][0].".".$datas['nazwisko'];
        }
        if($rola == 2) {
            $datas = $base->datas_user_id($kolumna->id_ucznia);
            $title = $datas['imie'][0].".".$datas['nazwisko'];
        }
        $zajecia = $calender->find_zajecia($kolumna->id_nauczania, $start, $end);
        foreach($zajecia as $object => $value) {
            if($email == $email_session) {
                $json_zajecia[] = array(
                    'title' => $value->przedmiot." - ".$title,
                    'start' => $value->dzien."T".$value->godzina,
                    'end' => $value->dzien."T".date("H:i:s",(strtotime($value->godzina) + $value->czas)),
                    'url' => $value->zoom,
                    'color' => $calender->color($value->przedmiot)
                );
            }
            if($email != $email_session) {
                $json_zajecia[] = array(
                    'title' => " ",
                    'start' => $value->dzien."T".$value->godzina,
                    'end' => $value->dzien."T".date("H:i:s",(strtotime($value->godzina) + $value->czas)),
                    'color' => "#717171"
                );
            }
        }
    }

    header('Content-Type: application/json');
    echo json_encode($json_zajecia);
