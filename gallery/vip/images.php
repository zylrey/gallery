<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `vip_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<div class="w-100 d-flex justify-content-between border-bottom py-2">
	<h3><?php echo $name ?></h3>
    <div>
        <a class="btn btn-flat btn-light border" href="./?page=vip" ><i class="fa fa-angle-left"></i> Back</a>
        <?php 
        $user_id = $_settings->userdata('id'); // Store the result in a variable
        if(isset($user_id)): // Check if user is logged in
        ?>
	        <button class="btn btn-flat btn-primary" type="button" id="add-new"><i class="fa fa-upload"></i> Upload</button>
        <?php endif; ?>
    </div>
</div>
<div class="row row-cols-4 row-cols-md-3 row-cols-sm-1 row-cols-lg-4 py-2">
	<div class="info">
		<p>Age: <?php echo $age ?></p>
		<p>Height: <?php echo $height ?></p>
		<p>Weight: <?php echo $weight ?></p>
		<p>Measurements: <?php echo $measurements ?></p><br>
		<p><?php echo $list1 ?></p>
		<p><?php echo $list2 ?></p><br>
		<p class="description"><?php echo $description ?></p>
	</div>
</div>
<div class="image-grid">
	<?php 
	$qry = $conn->query("SELECT * FROM `images` where `delete_f` = 0 and album_id = '{$_GET['id']}' order by `original_name` asc ");
	while($row = $qry->fetch_assoc()):
	?>
	<div class="col p-2 item">
		<a href="<?php echo validate_image($row['path_name']) ?>" data-lightbox="album" data-title="<?php echo $row['original_name'] ?>">
			<div class='img-view'>
				<img src="<?php echo validate_image($row['path_name']) ?>" class="img-thumbnail img-fluid img-thumb" alt="img" loading="lazy">
			</div>
		</a>
	</div>
	<?php endwhile; ?>
</div>
<div class="row">
    <div class="w-100 p-2 text-center" id="nData" style="display:none"><b>No Images</b></div>
</div>
<script>
	$(document).ready(function(){
        if($('.img-item').length <= 0){
            $('#nData').show('slow')
        }else{
            $('#nData').hide('slow')
        }
		$('#add-new').click(function(){
			uni_modal("<i class='fa fa-upload'></i> Create New Album", "albums/manage_image.php?album_id=<?php echo $_GET['id'] ?>")
		})
		$('.edit_image').click(function(){
			uni_modal("<i class='fa fa-edit'></i> Rename Image", "albums/rename_image.php?id="+$(this).attr('data-id'))
		})
		$('.move_image').click(function(){
			uni_modal("<i class='fa fa-arrows-alt'></i> Move Image", "albums/move_image.php?id="+$(this).attr('data-id'))
		})
        $('.img-item').click(function(){
            uni_modal("", "albums/view_img.php?id="+$(this).attr('data-id'))
        })
		$('.delete_image').click(function(){
			_conf("Are you sure to delete this Image ?","delete_image",[$(this).attr('data-id')])
		})
		$('.img-item').closest('.item').hover(function(){
			$(this).css({
				'background':'#005aff29',
				'border-radius':'5px'
			})
		})
		$('.img-item').closest('.item').mouseleave(function(){
			$(this).css({
				'background':'none',
				'border-radius':'5px'
			})
		})
	})
	function delete_image($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_vip",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>
<style>
    .info {
        color: #000;
        padding: -15px;
    }
    .info p {
        margin: 5px 0;
    }
    .description {
        margin-top: 20px;
    }
    .image-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
    }
    .img-view {
        overflow: hidden;
    }
    .img-thumb {
        width: 100%;
        height: auto;
        object-fit: cover;
    }
</style>