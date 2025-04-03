<?php
require_once('../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `album_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<div class="container-fluid">
	<form action="" id="album-form">
		<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
		<input type="hidden" name ="user_id" value="<?php echo $_settings->userdata('id') ?>">
		<div class="form-group">
			<label for="name" class="control-label">Model Name</label>
			<input name="name" id="" autofocus class="form-control form no-resize" value="<?php echo isset($name) ? $name : ''; ?>" />
		</div>
        <div class="form-group">
			<label for="age" class="control-label">Age</label>
			<input name="age" id="age" class="form-control form no-resize" value="<?php echo isset($age) ? $age : ''; ?>" />
		</div>
        <div class="form-group">
			<label for="height" class="control-label">Height</label>
			<input name="height" id="height" class="form-control form no-resize" value="<?php echo isset($height) ? $height : ''; ?>" />
		</div>
        <div class="form-group">
			<label for="weight" class="control-label">Weight</label>
			<input name="weight" id="weight" class="form-control form no-resize" value="<?php echo isset($weight) ? $weight : ''; ?>" />
		</div>
        <div class="form-group">
			<label for="measurements" class="control-label">Measurements</label>
			<input name="measurements" id="measurements" class="form-control form no-resize" value="<?php echo isset($measurements) ? $measurements : ''; ?>" />
		</div>
        <div class="form-group">
			<label for="list1" class="control-label">List 1</label>
			<input name="list1" id="list1" class="form-control form no-resize" value="<?php echo isset($list1) ? $list1 : ''; ?>" />
		</div>
        <div class="form-group">
			<label for="list2" class="control-label">List 2</label>
			<input name="list2" id="list2" class="form-control form no-resize" value="<?php echo isset($list2) ? $list2 : ''; ?>" />
		</div>
        <div class="form-group">
			<label for="description" class="control-label">Description</label>
			<textarea name="description" id="description" class="form-control form no-resize"><?php echo isset($description) ? $description : ''; ?></textarea>
		</div>
	</form>
</div>
<script>
	$('#album-form').submit(function(e){
    e.preventDefault();
    var _this = $(this);
    $('.err-msg').remove();
    start_loader();

    var formData = new FormData(this); // Correct way to get form data
    console.log(...formData.entries()); // Debugging: log form data

    $.ajax({
        url: _base_url_+"classes/Master.php?f=save_album",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        dataType: 'json',
        error: err => {
            console.log(err);
            alert_toast("An error occurred", 'error');
            end_loader();
        },
        success: function(resp){
            console.log(resp); // Debugging response
            if(typeof resp == 'object' && resp.status == 'success'){
                location.reload();
            } else {
                alert_toast("An error occurred: " + resp.msg, 'error');
                console.log(resp.sql);
                end_loader();
            }
        }
    });
});

</script>