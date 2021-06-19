<?php
    $conn = mysqli_connect('localhost', 'root', '', 'korepetycje');
    mysqli_set_charset($conn, "UTF8");
    $sql = "SELECT * FROM uzytkownik WHERE rola=2";
    $result = mysqli_query($conn, $sql);

    include('functions/needed.php');
    $data = new Database_Need;
?>

<div id="slider" class="glide">
    <div class="glide__track slider_contener" data-glide-el="track">
        <ul class="glide__slides slider_contener">
            <li id="slide1" class="glide__slide slide"></li>
            <li id="slide2" class="glide__slide slide"></li>
            <li id="slide3" class="glide__slide slide"></li>
        </ul>
    </div>
    <div class="glide__arrows" data-glide-el="controls">
        <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i class="fa fa-arrow-left"></i></button>
        <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i class="fa fa-arrow-right"></i></button>
    </div>
    <div class="glide__bullets" data-glide-el="controls[nav]">
        <button class="glide__bullet" data-glide-dir="=0"></button>
        <button class="glide__bullet" data-glide-dir="=1"></button>
        <button class="glide__bullet" data-glide-dir="=2"></button>
    </div>
</div>

<div id="search-content" class="content">
    <div id="filtr">
        <input id="search_input" type="text" onkeyup="filtr()" placeholder="What are you looking for?"></input>
        <select id="osubjects" name="subjects" onclick="filtr()">
            <option id="selected" value="" selected>All Subjects</option>
            <option value="plastyka">Art</option>
            <option value="biologia">Biology</option>
            <option value="chemia">Chemistry</option>
            <option value="chiński">Chinese</option>
            <option value="angielski">English</option>
            <option value="francuski">French</option>
            <option value="geografia">Geography</option>
            <option value="niemiecki">German</option>
            <option value="historia">History</option>
            <option value="historia sztuki">History of Art</option>
            <option value="informatyka">IT</option>
            <option value="włoaski">Italian</option>
            <option value="matematyka">Maths</option>        
            <option value="fizyka">Physics</option>
            <option value="polski">Polish</option>
            <option value="portugalski">Portuguese</option>
            <option value="rosyjski">Russian</option>
            <option value="hiszpański">Spanish</option>       
        </select>
        <select id="olevels" name="levels" onclick="filtr()">
            <option id="selected" value="" selected>All Levels</option>
            <option value="podstawowa">Primary School</option>
            <option value="srednia">Seconadary School</option>
            <option value="studia">University</option>  
        </select>
        <button id="sort_button" onclick="sortTable()">Sort by rating</button>
    </div>
    <table id="teachers">
        <?php
            $i = -1;
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_array($result)){
                    $i++;
                    $age = $data->datas_birth($row['email']);
                    $subjects = $data->datas_subjects($row['id_uzytkownika']);
                    $teacher = $data->datas_teacher($row['id_uzytkownika']);
        ?>
            <tr class="teacher_row" onclick="window.open('./sb_profil.php?email=<?php echo($row['email'])?>', '_self');">
                <td class="teacher-item" id="tphoto">
                    <?php echo('<img class="table_photo" src="img/profil/2'.'-'.$row['plec'].'.png">');?>
                </td>

                <td class="teacher-item" id="tname">
                    <?= $row['imie']?> <?= $row['nazwisko']?>
                    <div id="tage"><?= $age['wiek']?> lat</div>

                    <div class="information info_stars">   
                        <div class="stars-outer">
                            <div class="stars-inner">

                            </div>
                        </div>
                        <div class="opinion">
                            <?=$teacher['ocena']?>
                            <?php
                                if($teacher['ocena'] == '') {
                                    echo("0.00");
                                }
                            ?>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', getRatings);

                        function getRatings() {
                            var i = <?php echo($i)?>;
                            console.log(i);
                            var starPercentage = <?php echo($teacher['ocena']);?>;
                            var starPercentage = Math.round(((starPercentage/5)*100)/10)*10; 
                            var starPercentageRounded = `${starPercentage}%`;
                            console.log(starPercentageRounded);
                            document.getElementsByClassName("stars-inner")[i].style.width = starPercentageRounded;
                        }
                    </script>
                </td>

                <td class="teacher-item" id="tsubject">
                    <?php
                        $used_subject = [];
                        foreach($subjects as $object => $kolumn) {
                            if(!in_array($kolumn->przedmiot, $used_subject)) {
                    ?>
                        <div class="tsubject"> 
                            <?=$kolumn->przedmiot?>
                            <?php
                                array_push($used_subject, $kolumn->przedmiot);
                                foreach($subjects as $object => $kolumn){
                                    if($kolumn->przedmiot == $used_subject[count($used_subject)-1]) {
                            ?>
                            <div class="tlevel"> <?=$kolumn->poziom?> - <i class="fas fa-coins"></i> <?=$kolumn->koszt?></div>
                            <?php
                                    }
                                }
                            ?>
                        </div>
                    <?php
                            }
                        }
                    ?>
                </td>
                <td class="teacher-item" id="tplace">
                    <i class="fas fa-map-marker-alt"></i>
                    <?= $row['miejsce_zamieszkania']?>
                    <?php
                        if($row['miejsce_zamieszkania'] == '') {
                            echo("BRAK");
                        }
                    ?>
                </td>
            </tr>
        <?php
                }
            }
        ?>    
    </table>
</div>
