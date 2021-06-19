<?php
    if(isset($_SESSION['email'])) {
        $user = $data->datas_user($_SESSION['email']);
        if($user['rola'] == 1) {
            $lessons = $calendar->find_nauczanie_uczen($user['id_uzytkownika']);
            $to_grade = $calendar->grade($lessons);
            if($to_grade) {
?>
<div id="grade_modal">
    <div class="modal_contener">
        <span id="close_grade" class="close_grade">&times;</span>
        <h2>RATE THE TUTOR</h2>
        <div id="info_grade">
            <div id="name_grade">
                <?php
                    $id_tutor = $calendar->teacher_grade($to_grade);
                    $tutor = $data->datas_user_id($id_tutor);

                    if(isset($_POST['button'])) {
                        $rate = $_POST['rate'];
                        $calendar->add_grade($rate, $to_grade, $id_tutor);
                    }

                    echo($tutor['imie']." ".$tutor['nazwisko']);    
                ?>
            </div>
            <form id="grading" method="POST">
                <div class="star-widget">
                    <input type="radio" name="rate" id="rate-5" value=5>
                        <label for="rate-5" class="fas fa-star"></label>
                    <input type="radio" name="rate" id="rate-4" value=4>
                        <label for="rate-4" class="fas fa-star"></label>
                    <input type="radio" name="rate" id="rate-3" value=3>
                        <label for="rate-3" class="fas fa-star"></label>
                    <input type="radio" name="rate" id="rate-2" value=2>
                        <label for="rate-2" class="fas fa-star"></label>
                    <input type="radio" name="rate" id="rate-1" value=1>
                        <label for="rate-1" class="fas fa-star"></label>
                </div>
                <div class="btn_grade">
                    <button id="button_btn" name ="button" type="submit">SUBMIT</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.getElementById("close_grade").onclick = function() {
        var modal = document.getElementById("grade_modal");
        modal.style.display = "none";
    }

    document.getElementById("button_btn").onclick = function() {
         var info = document.getElementById("info_grade");
         info.innerHTML = "Thanks for your opinion!";
    }
</script>
<?php
            }
        }
    }
?>