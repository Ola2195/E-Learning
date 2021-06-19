<div id="meeting_modal">
    <div id="modal-content">
        <span id="close_grade_meeting" class="close_grade">&times;</span>
        <h2>NEW MEETING</h2>
        <div class="modal-body">
            <button id="button_meeting" name ="button" type="submit">SUBMIT</button>
        </div>
    </div>
</div>
<script>
    document.getElementById("close_grade_meeting").onclick = function() {
        var modal = document.getElementById("meeting_modal");
        modal.style.display = "none";
    }
</script>