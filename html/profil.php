<?php
include('functions/needed.php');
$data = new Database_Need;

include('functions/calender.php');
$calendar = new Database_Calender;

$email = $_GET['email'];

$email_session = '';
if(isset($_SESSION['email'])) {
    $email_session = $_SESSION['email'];
}

$user = $data->datas_user($email);
$age = $data->datas_birth($email);
if($user['rola'] == 1) {
    $student = $data->datas_student($user['id_uzytkownika']);
    $lessons = $calendar->find_nauczanie_uczen($user['id_uzytkownika']);
}
if($user['rola'] == 2) {
    $teacher = $data->datas_teacher($user['id_uzytkownika']);
    $subjects = $data->datas_subjects($user['id_uzytkownika']);
    $lessons = $calendar->find_nauczanie_nauczyciel($user['id_uzytkownika']);
}
?>

<div id="profil_header">
    <div id="photo">
        <?php
        echo('<img class="photo" src="img/profil/'.$user['rola'].'-'.$user['plec'].'.png">');
        ?>
    </div>
    <div id="name">
        <?=$user['imie']?>
        <?=$user['nazwisko']?>
    </div>
    <div id="age">
        <?=$age['wiek']?> lat
    </div>
</div>


<div class="content">
    <?php
        if($user['rola'] == 2) {
    ?>
    <div class="information info_stars">   
        <div id="stars-outer">
            <div id="stars-inner">

            </div>
        </div>
        <div id="opinion">
            <?=$teacher['ocena']?>
        </div>
        <div id="count_opinions">
            / ilość opinii: <?=$teacher['ilosc_ocen']?>
        </div>
    </div>
    <?php
        }
    ?>

    <?php
        if($user['rola'] == 1) {
    ?>
    <div class="information info_levels">
        <div class="info">
            <?php
                if($student['poziom_nauczania'] == 'podstawowa') {
                    echo("Uczeń szkoły podstawowej");
                }
                if($student['poziom_nauczania'] == 'srednia') {
                    echo("Uczeń szkoły średniej");
                }
                if($student['poziom_nauczania'] == 'studia') {
                    echo("Student");
                }
            ?>
        </div>
    </div>
    <?php
        }
    ?>

    <?php
        if($user['rola'] == 2) {
    ?>
    <?php
        if(isset($_SESSION['email'])) {
            if($_SESSION['email'] == $email) {
    ?>
    <div id="set_subject" class="set" data-id="<?php echo($user['id_uzytkownika'])?>">Add more subjects <i class="fas fa-plus-circle"></i></div>
    <?php
            }
        }
    ?>
    <div class="information info_subjects">
        <?php
            $used_subject = [];
            foreach($subjects as $object => $kolumn) {
                if(!in_array($kolumn->przedmiot, $used_subject)) {
        ?>
            <div class="info subjects_info" data-id="<?php echo($user['id_uzytkownika'])?>" data-subject="<?php echo($kolumn->przedmiot)?>">
                <div id="przedmiot" class="subject">
                    <?=$kolumn->przedmiot?>
                    <i class="fas fa-sort-down"></i>
                </div>
                <?php
                    array_push($used_subject, $kolumn->przedmiot);
                    foreach($subjects as $object => $kolumn){
                        if($kolumn->przedmiot == $used_subject[count($used_subject)-1]) {
                ?>
                    <div class="inf_des">
                        <?=$kolumn->poziom?> -
                        <i class="fas fa-coins"></i>
                        <?=$kolumn->koszt?> ZŁ
                    </div>
                <?php
                        }
                    }
                ?>
            </div>
        <?php
                }
            }
        ?>
    </div>
    <?php
        }
    ?>

    <div class="information info_descripton">   
        <?php
            if($user['rola'] == 2) {
        ?>
            <?=$teacher['opis']?>
        <?php
            }
        ?>
    </div>

    <div class="information info_contact">
        <div class="info">
            <i class="fas fa-phone"></i>
            <?=$user['telefon']?>
        </div>
        <div class="info">
            <i class="fas fa-envelope"></i>
            <?=$user['email']?>
        </div>
        <div class="info">
            <i class="fas fa-map-marker-alt"></i>
            <?=$user['miejsce_zamieszkania']?>
            <?php
                if($user['miejsce_zamieszkania'] == '') {
                    echo("BRAK");
                }
            ?>
        </div>
    </div>
    
    <?php
        if(isset($_SESSION['email'])) {
            if($_SESSION['email'] == $email) {
                if($user['rola'] == 2) {
    ?>
    <div id="set_meeting" class="set" data-id="<?php echo($user['id_uzytkownika'])?>">Add new meeting <i class="fas fa-plus-circle"></i></div>
    <?php
                }
            }
        }
    ?>
    <div class="calendar">
        <div id="calendar"></div>

    </div>
</div>

<script>
    <?php
        if($user['rola'] == 2) {
    ?>
        document.addEventListener('DOMContentLoaded', getRatings);

        function getRatings() {
            var starPercentage = <?php echo($teacher['ocena']);?>;
            var starPercentage = Math.round(((starPercentage/5)*100)/10)*10; 
            var starPercentageRounded = `${starPercentage}%`;
            document.getElementById("stars-inner").style.width = starPercentageRounded;
        }
    <?php
        }
    ?>

    document.addEventListener('DOMContentLoaded', draw);

    function draw() {

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            eventSources: [{
                url: 'functions/calendar_datas.php',
                method: 'POST',
                dataType: "JSON",
                extraParams: {
                    id: <?php echo($user['id_uzytkownika'])?>,
                    rola: <?php echo($user['rola'])?>,
                    email: '<?php echo($user['email'])?>',
                    email_session: '<?php echo($email_session)?>',
                }
            }],
        });
        calendar.render();
    }
</script>