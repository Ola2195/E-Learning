<?php
    include('functions/needed.php');
    $data = new Database_Need;
    $teachers = $data->theBestTutors();
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

<div class="content">
    <div class="search_description">
        <a href="search.php"><button class="search_button">FIND PERFECT TUTOR</button></a>
    </div>

    <div class="opis_strony">
        <div class="description">  
            <div id="opis">
                <p>
                    This page is an innovative project.
                    This is the first website of its kind where you can advertise yourself as a tutor
                    or find a tutor for you who can teach you online or in your city!
                </p>
                <p>
                    In our search engine you can select which subject you need tutoring in
                    and whether you want them to be online or stationary.
                    A reliable system will allow you to find a teacher who will meet your expectations!</p>
                <p>
                    What's more, our website allows you to view the nearest available date for the tutor you are interested in.
                    And contacting him directly.
                </p>
                <p>
                    Try now. Find your perfect tutor.
                </p>
            </div>
            <div id="border-bottom"></div>
        </div>
        <div id="brain_image">
            <img src="https://cdn.iqcertificate.org/images/put-your-mind.jpg" id="brain">
        </div>
    </div>

    <h3 id="tutors">The Best Tutors</h3>
    <div class="glide subject_slider">
        <div class="glide__track slider_contener" data-glide-el="track">
            <ul class="glide__slides slider_contener">
                <?php
                    $i = -1;
                    foreach($teachers as $object => $kolumn) {
                        $i++;
                ?>
                    <li class="glide__slide tutor" onclick="window.open('./sb_profil.php?email=<?php echo($kolumn->email)?>', '_self');">
                        <?php echo('<img class="glide_photo" src="img/profil/2'.'-'.$kolumn->plec.'.png">');?>
                        <div class="glide_name"><?=$kolumn->imie?></div>
                        <div class="glide_name"><?=$kolumn->nazwisko?></div>
                        <div class="information info_stars">   
                            <div class="stars-outer">
                                <div class="stars-inner">

                                </div>
                            </div>
                            <div class="opinion">
                                <?=$kolumn->ocena?>
                                <?php
                                    if($kolumn->ocena == '') {
                                        echo("0.00");
                                    }
                                ?>
                            </div>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', getRatings);

                            function getRatings() {
                                var i = <?php echo($i)?>;
                                var starPercentage = <?php echo($kolumn->ocena)?>;
                                var starPercentage = Math.round(((starPercentage/5)*100)/10)*10; 
                                var starPercentageRounded = `${starPercentage}%`;
                                document.getElementsByClassName("stars-inner")[i].style.width = starPercentageRounded;
                                console.log(document.getElementsByClassName("stars-inner")[i]);
                            }
                        </script>
                    </li>
                <?php
                    }
                ?>
            </ul>
        </div>
        <div class="glide__arrows" data-glide-el="controls">
            <button class="glide__arrow glide__arrow--left" data-glide-dir="<"><i class="fa fa-arrow-left"></i></button>
            <button class="glide__arrow glide__arrow--right" data-glide-dir=">"><i class="fa fa-arrow-right"></i></button>
        </div>
    </div>
</div>