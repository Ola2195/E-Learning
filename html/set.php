<?php
include('functions/needed.php');
$data = new Database_Need;

$user = $data->datas_user($_SESSION['email']);
$age = $data->datas_birth($_SESSION['email']);

if($user['rola'] == 1) {
    $student = $data->datas_student($user['id_uzytkownika']);
    $level = $student['poziom_nauczania'];
}
if($user['rola'] == 2) {
    $teacher = $data->datas_teacher($user['id_uzytkownika']);
    $opis = $teacher['opis'];
    $subjects = $data->datas_subjects($user['id_uzytkownika']);
}

$imie = $user['imie'];
$nazwisko = $user['nazwisko'];
$data_urodzenia = $user['data_urodzenia'];
$tel = $user['telefon'];
$miejsce = $user['miejsce_zamieszkania'];


if(isset($_POST['edit'])) {
    if($user['rola'] == 1) {
        $field = array(
            'name' => $_POST['name'],
            'surname' => $_POST['surname'],
            'gender' => $_POST['gender'],
            'birth' => $_POST['birth'],
            'phone' => $_POST['phone'],
            'place' => $_POST['place'],
            'level' => $_POST['level']
        );
    }
    if($user['rola'] == 2) {
        $field = array(
            'name' => $_POST['name'],
            'surname' => $_POST['surname'],
            'gender' => $_POST['gender'],
            'birth' => $_POST['birth'],
            'phone' => $_POST['phone'],
            'place' => $_POST['place'],
            'description' => $_POST['description']      
        );
    }
    $data->edit_datas($user['id_uzytkownika'], $user['rola'], $field);
    header("location: ./myprofil.php?email=".$_SESSION['email']);

}

?>

<div id="platform_header">
</div>

<div class="content">
    <h3>Edit your profile</h3>
    <form id="form_edit" method="POST">
        <!-- <label for="name">Profile picture: </label>
            <input class="text half1" type="file" name="picture"><br> -->
        <label for="name">Name: </label>
            <?php echo("<input type='text' name='name' value='$imie'><br>");?>
        <label for="surname">Surname: </label>
            <?php echo("<input type='text' name='surname' value='$nazwisko'><br>");?>
        <label for="gender">Gender: </label>
            <select class="text" name="gender">
                <option value="kobieta" <?php if($user['plec'] == 'kobieta') echo("selected") ?>>Female</option>
                <option value="mezczyzna" <?php if($user['plec'] == 'mezczyzna') echo("selected") ?>>Male</option>
            </select><br>
        <label for="birth">Date od Birth: </label>
            <?php echo("<input type='date' name='birth' value='$data_urodzenia'><br>");?>
        <label for="phone">Phone Number: </label>
            <?php echo("<input type='text' name='phone' value='$tel'><br>");?>
        <label for="place">Place of residence: </label>
            <?php echo("<input type='data' name='place' value='$miejsce'><br>");?>
        <?php
            if($user['rola'] == 1) {
        ?>
        <label for="level">Level: </label>
            <select class="text" id="level" name="level">
                <option value="podstawowa" <?php if($student['poziom_nauczania'] == 'podstawa') echo("selected") ?>>Primary School</option>
                <option value="srednia" <?php if($student['poziom_nauczania'] == 'srednia') echo("selected") ?>>Secondary School</option>
                <option value="studia" <?php if($student['poziom_nauczania'] == 'studia') echo("selected") ?>>University</option>
            </select><br>
        <?php
            }
        ?>
        <?php
            if($user['rola'] == 2) {
        ?>
        <label for="description">Description: </label>
            <?php echo("<textarea name='description'>$opis</textarea><br>");?>
        <?php
            }
        ?>
        <button class="submit_register" name="edit">SUMBIT</button><br>
    </form>
</div>
