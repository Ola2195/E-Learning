<?php
include('functions/needed.php');
$data = new Database_Need;

include('functions/calender.php');
$calendar = new Database_Calender;

$email = $_SESSION['email'];

$user = $data->datas_user($email);
if($user['rola'] == 1) {
    $lessons = $calendar->find_nauczanie_uczen($user['id_uzytkownika']);
}
if($user['rola'] == 2) {
    $lessons = $calendar->find_nauczanie_nauczyciel($user['id_uzytkownika']);
}

if(isset($_POST['submit'])) {
    $files = array(
        'id' => $_POST['id'],
        'name' => $_FILES['myfile']['name'],
        'data' => date("Y/m/d"),
        'type' => $_FILES['myfile']['type'],
        'material' => file_get_contents($_FILES['myfile']['tmp_name'])
    ); 
    $calendar->add_files($files);
    header("location: ./files.php"); 
}

?>
<div id="platform_header">
</div>

<div class="content">
    <?php
        if($user['rola'] == 2) {
    ?>
    <form id="dodaj_file" method="POST" enctype="multipart/form-data">
        <label>Select student </label><br>
        <select class="file_element" name="id">
            <?php
                foreach($lessons as $object => $kolumn){
                    $student = $data->datas_user_id($kolumn->id_ucznia);
            ?>
                <option value=<?=$kolumn->id_nauczania?>><?=$student['imie']?> <?=$student['nazwisko']?></option>  
            <?php
                }
            ?>
        </select>
        <input class="file_element" name="myfile" type="file"/>
        <button class="file_button file_element" name="submit">Add new</button>
    </form>
    <?php
        }
    ?>
    <div class="select_files">
        <?php
            foreach($lessons as $object => $kolumn){
                $result = $calendar->find_files($kolumn->id_nauczania);
                foreach($result as $objects => $value){
                    if($user['rola'] == 1) {
                        $from = "OD: ";
                        $with = $data->datas_user_id($kolumn->id_nauczyciela);
                    }
                    if($user['rola'] == 2) {
                        $from = "DO: ";
                        $with = $data->datas_user_id($kolumn->id_ucznia);
                    }

                    $type = '';
                    if(strpos($value->typ, 'audio/')!==false) {
                        $type = 'audio';
                    }
                    if(strpos($value->typ, 'image/')!==false) {
                        $type = 'image';
                    }
                    if(strpos($value->typ, 'text/')!==false) {
                        $type = 'text';
                    }
                    if(strpos($value->typ, 'video/')!==false) {
                        $type = 'video';
                    }
                    if(strpos($value->nazwa, '.xlsx')) {
                        $type = 'excel';
                    }
                    if(strpos($value->nazwa, '.pptx')) {
                        $type = 'power';
                    }
                    if(strpos($value->nazwa, '.docx')) {
                        $type = 'word';
                    }
                    if(strpos($value->nazwa, '.zip') || strpos($value->nazwa, '.rar')) {
                        $type = 'excel';
                    }
                    if(strpos($value->nazwa, '.pdf')) {
                        $type = 'pdf';
                    }
        ?>
            <div class="file">
                <div class="file_icon <?=$type?>_file"></div>
                <div class="name_file file_datas"><?=$value->nazwa?></div>
                <div class="file_datas"><?=$value->data?></div>
                <div class="file_datas file_name"><?=$from?> <?=$with['imie']?> <?=$with['nazwisko']?></div>
                <a href="functions/download.php?id=<?=$value->id_materialu?>"><i data-id="<?=$value->id_materialu?>" id="file_download" class="file_datas fas fa-download"></i></a>
                <?php
                    if($user['rola'] == 2) {
                ?>
                <i data-id="<?=$value->id_materialu?>" id="file_delete" class="file_datas fas fa-trash-alt"></i>
                <?php
                    }
                ?>
            </div>
        <?php   
                }
            }
        ?>
    </div>
</div>