<div id="subject_modal">
    <div id="modal-content">
        <span id="close_grade_subject" class="close_grade">&times;</span>
        <h2>LEARNED SUBJECT</h2>
        <div class="modal-body">
            <input type="hidden" id="modal_id" value="<?php echo($user['id_uzytkownika'])?>">
            <label for="subjects">Subject</label>
            <select class="modal_element" id="modal_subject_select" name="subjects">
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
            <label for="cost" id="cost_label">Cost</label>
            <div type="number" name="cost" id="cost">
                <div>
                <label for="cprimary">Primary School:</label>
                    <input id="cprimary" class="modal_element_cost" type="number" name="cprimary">
                </div>
                <div>
                    <label for="csecondary">Seconadary School:</label>
                    <input id="csecondary" class="modal_element_cost" type="number" name="csecondary">
                </div>
                <div>
                    <label for="cstudia">University:</label>
                    <input id="cstudia" class="modal_element_cost" type="number" name="cstudia">
                </div>
            </div>
            <button id="button_subject" name ="button" type="submit">SUBMIT</button>
        </div>
    </div>
</div>
<script>
    document.getElementById("close_grade_subject").onclick = function() {
        var modal = document.getElementById("subject_modal");
        modal.style.display = "none";
    }
</script>