<?php
    if(isset($_POST['id'])){
        include('calender.php');
        $calendar = new Database_Calender;
        $id = $_POST['id'];

        $stmt = $calendar->con->prepare("DELETE FROM materialy WHERE id_materialu = :id");
        $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
        $stmt -> execute();
    }