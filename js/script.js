var menu = document.getElementById("menu-bar");
var burger = document.getElementById("hamburger_menu");

function hamburger() {
    if(menu.style.display == "none" || menu.style.display == "") {
        menu.style.display = "flex";
        burger.style.backgroundColor = "#5897a7";
    }
    else {
        menu.style.display = "none";
        burger.style.backgroundColor = "#3093ac";
    }
}

$(document).ready(function() {
    $(window).scroll(function () {
        if ($(window).scrollTop() > 1) {
            $('.header').addClass('header-fixed');
        }
        if ($(window).scrollTop() < 1) {
            $('.header').removeClass('header-fixed');
        }
    });
})

$(document).on('click', '#file_delete', function(){
    let id = $(this).attr('data-id');
    $.ajax({
        url: 'functions/delete.php',
        type: 'POST',
        data: {id:id},
        success: function(){
            location.reload();
        } 
    });
})

$(document).on('click', '.subjects_info', function(){
    $("#button_subject").removeClass("add");
    $("#button_subject").addClass("edit");
    $('#subject_modal').show();
    let user_id = $(this).attr("data-id");
    let user_subject = $(this).attr("data-id");
    $(document).on('click', '.edit', function(){
        $.ajax({
            url: 'functions/fetch_subject.php',
            method: 'POST',
            data: {
                id:user_id,
                subject:user_subject
            },
            dataType: 'JSON',
            success: function(data){
                $('#modal_id').val(data.id);
                $('#modal_subject_select').val(data.subject);
                $('#cprimary').val(data.cost1);
                $('#csecondary').val(data.cost2);
                $('#cstudia').val(data.cost3);
            }
        })
    })
})

$(document).on('click', '.edit', function(){
    let id = $('#modal_id').val();
    let subject = $('#modal_subject_select').val();
    let cost1 = $('#cprimary').val();
    let cost2 = $('#csecondary').val();
    let cost3 = $('#cstudia').val();
    $.ajax({
        url: 'functions/edit_subject.php',
        method: 'POST',
        data: {
            id:id,
            subject:subject,
            cost1:cost1,
            cost2:cost2,
            cost3:cost3
        },
        success: function(){
            location.reload();
        }
    })
})

$(document).on('click', '#set_subject', function(){
    let user_id = $(this).attr("data-id");
    $("#button_subject").removeClass("edit");
    $("#button_subject").addClass("add");
    $('#modal_id').val(user_id);
    $('#modal_subject_select').val("");
    $('#cprimary').val("");
    $('#csecondary').val("");
    $('#cstudia').val("");
    $('#subject_modal').show();
    $(document).on('click', '.add', function(){
        let id = $('#modal_id').val();
        let subject = $('#modal_subject_select').val();
        let cost1 = $('#cprimary').val();
        let cost2 = $('#csecondary').val();
        let cost3 = $('#cstudia').val();
        $.ajax({
            url: 'functions/add_subject.php',
            method: 'POST',
            data: {
                id:id,
                subject:subject,
                cost1:cost1,
                cost2:cost2,
                cost3:cost3
            },
            success: function(){
                location.reload();
            }
        })
    })
})

$(document).on('click', '#set_meeting', function(){
    let user_id = $(this).attr("data-id");
    $("#button_subject").removeClass("edit_meeting");
    $("#button_subject").addClass("add_meeting");
    $('#id').val(user_id);
    $('#nauczanie').val("");
    $('#dzien').val("");
    $('#godzina').val("");
    $('#czas').val("");
    $('#zoom').val("");
    $('#meeting_modal').show();
    // $(document).on('click', '.add_meeting', function(){
    //     // let id = $('#modal_id').val();
    //     // let subject = $('#modal_subject_select').val();
    //     // let cost1 = $('#cprimary').val();
    //     // let cost2 = $('#csecondary').val();
    //     // let cost3 = $('#cstudia').val();
    //     $.ajax({
    //         url: 'functions/add_meeting.php',
    //         // method: 'POST',
    //         // data: {
    //         //     id:id,
    //         //     subject:subject,
    //         //     cost1:cost1,
    //         //     cost2:cost2,
    //         //     cost3:cost3
    //         // },
    //         success: function(){
    //             location.reload();
    //         }
    //     })
    // })
})

function checkRole() {
    if(document.getElementById("student").checked) {
        document.getElementById("level").style.display = "block";
    }else{
        document.getElementById("level").style.display = "none";
    }
}

var glide = new Glide('.glide', {
    type: 'carousel',
    autoplay: 5000,
    animationDuration: 1000,
    startAt: 1,
    perView: 1,
    gap: 20
});

glide.mount();

var subject_slider = new Glide('.subject_slider', {
    type: 'carousel',
    autoplay: 5000,
    animationDuration: 1000,
    startAt: 1,
    perView: 6,
    breakpoints: {
        1500: { perView: 5 },
        1300: { perView: 4 }, 
        1000: { perView: 3 },
        800: { perView: 2 },
        600: { perView: 1 }
    }
});

subject_slider.mount();





function filtr() {
    var table, tr, td, i, txtValue1, txtValue2;
    table = document.getElementById("teachers");
    tr = table.getElementsByTagName("tr");

    var input, filter;
    input = document.getElementById("search_input");
    filter = input.value.toUpperCase();

    var subject_selector, subject, subject_filter;
    subject_selector = document.getElementById("osubjects");
    subject = subject_selector.selectedOptions;
    subject = subject[0].value;
    subject_filter = subject.toUpperCase();

    var level_selector, level, level_filter;
    level_selector = document.getElementById("olevels");
    level = level_selector.selectedOptions;
    level = level[0].value;
    level_filter = level.toUpperCase();

    for (i = 0; i < tr.length; i++) {
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                tr[i].style.display = "none";
            }
        }
    }


    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td");
        td1 = tr[i].getElementsByTagName("td")[1];
        td2 = tr[i].getElementsByTagName("td")[2];
            if (td) {
                txtValue1 = td1.textContent || td1.innerText;
                txtValue2 = td2.textContent || td2.innerText;
                if (txtValue1.toUpperCase().indexOf(filter) > -1  && txtValue2.toUpperCase().indexOf(level_filter) > -1 && txtValue2.toUpperCase().indexOf(subject_filter) > -1) {
                    tr[i].style.display = "";
                } else {
                tr[i].style.display = "none";
            }
        }
    }
}


function sortTable() {
    var table = document.getElementById("teachers");
    var switching = true;
    while (switching) {
        switching = false;
        var rows = table.rows;
        for (var i = 0; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            var x = rows[i].getElementsByClassName("opinion")[0].innerHTML;
            console.log(x);
            var y = rows[i+1].getElementsByClassName("opinion")[0].innerHTML;
            console.log(y);
            if (x < y) {
                var shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i+1], rows[i]);
            switching = true;
        }
    }
}
