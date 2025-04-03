<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<div class="container-fluid">
    <div class="w-100 d-flex justify-content-between border-bottom py-2 align-items-center">
        <h3 class="m-0">Gallery</h3>
        <?php if(isset($_SESSION['userdata'])): ?>
        <button class="btn btn-flat btn-primary" id="add-new"><i class="fa fa-plus"></i> Add New</button>
        <?php endif; ?>
    </div>

    <!-- VIP Section -->
    <div class="vip-section p-3 my-4 rounded">
        <div class="text-center">
            <h4 class="text-danger fw-bold mb-1">VIP</h4>
            <div class="h5 mb-1">
                <a href="#" data-toggle="modal" data-target="#codeModal">CLICK HERE TO ACCESS VIP</a>
            </div>
            <small class="text-muted">Regular Clients Access Only</small>
        </div>
    </div>

    <div class="modal fade" id="codeModal" tabindex="-1" role="dialog" aria-labelledby="codeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="codeModalLabel">Enter Access Code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" id="accessCode" class="form-control" placeholder="Enter your access code">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitCode()">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Profile Boxes -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php 
            $qry = $conn->query("SELECT * FROM album_list WHERE `delete_f` = 0 ORDER BY `name` ASC");
            while($row = $qry->fetch_assoc()):
                $img = [];
                $imgs = $conn->query("SELECT * FROM `images` WHERE album_id = '{$row['id']}' AND delete_f = 0 ORDER BY unix_timestamp(date_updated) DESC LIMIT 1");
                while ($irow = $imgs->fetch_assoc()){
                    $img[] = $irow['path_name'];
                }
        ?>
        <div class="col">
            <div class="profile-card shadow-sm rounded overflow-hidden">
                <a href="<?php echo base_url ?>?page=albums/images&id=<?php echo $row['id'] ?>" class="text-decoration-none text-dark">
                    <div class="image-container">
                        <?php if (!empty($img)): ?>
                        <img src="<?php echo validate_image($img[0]) ?>" class="profile-image" alt="<?php echo $row['name'] ?>">
                        <?php else: ?>
                        <div class="no-image d-flex align-items-center justify-content-center">
                            <i class="fa fa-image fa-3x text-muted"></i>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="profile-info p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="profile-name mb-0"><?php echo $row['name'] ?></h5>
                            <span class="profile-age text-muted"><?php echo $row['age'] ?>, y.o</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    <div class="row mt-4">
        <div class="w-100 p-4 text-center" id="nData" style="display:none"><b>No Albums Available</b></div>
    </div>
</div>

<script>
$(document).ready(function(){
    if($('.profile-card').length <= 0){
        $('#nData').show('slow');
    }
    
    $('#add-new').click(function(){
        uni_modal("<i class='fa fa-plus'></i> Create New Album", "albums/manage_album.php")
    });

    $('.profile-card').hover(
        function(){ $(this).css('transform', 'translateY(-5px)') },
        function(){ $(this).css('transform', 'none') }
    );
});

function submitCode() {
    const code = document.getElementById('accessCode').value;
    if (code) {
        $.ajax({
            url: "<?php echo base_url; ?>classes/Master.php?f=validate_code",
            method: "POST",
            data: { code: code },
            dataType: "json",
            success: function(response) {
                if (response.valid) {
                    window.location.href = "<?php echo base_url; ?>?page=vip"; // Redirect to VIP page
                } else {
                    alert("Invalid access code. Please try again.");
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status, error);
                alert("Something went wrong. Please try again.");
            }
        });
    } else {
        alert("Please enter a code.");
    }
}
</script>

<style>
.vip-section {
    background: #fff5f5;
    border: 1px solid #ffd6d6;
}

.profile-card {
    transition: all 0.3s ease;
    background: white;
    border: 45px solid #eee;
}

.profile-card:hover {
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

.image-container {
    height: 300px;
    overflow: hidden;
    position: relative;
}

.profile-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.profile-card:hover .profile-image {
    transform: scale(1.05);
}

.no-image {
    height: 300px;
    background: #f8f9fa;
    font-size: 24px;
}

.profile-info {
    background: white;
}

.profile-name {
    color: #2c3e50;
    font-weight: 600;
    font-size: 1.1rem;
}

.profile-age {
    font-size: 0.9rem;
    color: #95a5a6;
}

.btn-primary {
    background-color: #dc3545;
    border-color: #dc3545;
}

.btn-primary:hover {
    background-color: #bb2d3b;
}
</style>