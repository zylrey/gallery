<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$timeout_duration = 120;

if (isset($_SESSION['start_time'])) {
    $session_lifetime = time() - $_SESSION['start_time'];
    
    if ($session_lifetime > $timeout_duration) {
        session_unset();
        session_destroy();
        echo '<script>window.location.href = "' . base_url . '?page=albums";</script>';
        exit;
    }
} else {
    $_SESSION['start_time'] = time();
}

function checkAccess() {
    global $conn;
    
    if (isset($_SESSION['access_code']) && !empty($_SESSION['access_code'])) {
        $access_code = $_SESSION['access_code'];
        
        $qry = $conn->query("SELECT * FROM user_code WHERE code = '$access_code' LIMIT 1");
        
        if ($qry->num_rows === 0) {
            echo '<script>window.location.href = "' . base_url . '?page=albums";</script>';
            exit; // Stop further execution
        }
    } else {
        echo '<script>window.location.href = "' . base_url . '?page=albums";</script>';
        exit; // Stop further execution
    }
}

// Check if the user is trying to access the VIP page
if ($_GET['page'] == 'vip') {
    checkAccess(); // Call the function to validate access
}
?>


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
            <div class="h5 mb-1">
                <h4 class="text-success fw-bold mb-1">WELCOME TO VIP AREA</h4>
            </div>
            <small class="text-muted">Regular Clients Access Only</small>
            <div id="countdown" class="text-danger fw-bold mt-2"></div>
        </div>
    </div>

    <!-- Modal -->
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
            $qry = $conn->query("SELECT * FROM vip_list WHERE `delete_f` = 0 ORDER BY `name` ASC");
            while($row = $qry->fetch_assoc()):
                $img = [];
                $imgs = $conn->query("SELECT * FROM `images` WHERE album_id = '{$row['id']}' AND delete_f = 0 ORDER BY unix_timestamp(date_updated) DESC LIMIT 1");
                while ($irow = $imgs->fetch_assoc()){
                    $img[] = $irow['path_name'];
                }
        ?>
        <div class="col">
            <div class="profile-card shadow-sm rounded overflow-hidden">
                <a href="<?php echo base_url ?>?page=vip/images&id=<?php echo $row['id'] ?>" class="text-decoration-none text-dark">
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
        uni_modal("<i class='fa fa-plus'></i> Create New Album", "vip/manage_album.php")
    });

    $('.profile-card').hover(
        function(){ $(this).css('transform', 'translateY(-5px)') },
        function(){ $(this).css('transform', 'none') }
    );
});

function submitCode() {
    const code = document.getElementById('accessCode').value;
    if (code) {
        // Handle the code submission (e.g., validate the code)
        alert("You entered: " + code); // Replace this with actual validation logic
        $('#codeModal').modal('hide'); // Close the modal after submission
    } else {
        alert("Please enter a code.");
    }
}

let timeLeft = <?php echo $timeout_duration; ?> - (Math.floor(Date.now() / 1000) - <?php echo isset($_SESSION['start_time']) ? $_SESSION['start_time'] : 'time()'; ?>); // Calculate remaining time
const countdownElement = document.getElementById('countdown');

const countdownTimer = setInterval(() => {
    if (timeLeft <= 0) {
        clearInterval(countdownTimer);
        countdownElement.innerHTML = "Session expired! Redirecting...";
        // Redirect to the albums page after a short delay
        setTimeout(() => {
            window.location.href = "<?php echo base_url; ?>?page=albums";
        }, 2000); // 2 seconds delay
    } else {
        countdownElement.innerHTML = `Session will expire in: ${timeLeft} seconds`;
        timeLeft--;
        localStorage.setItem('timeLeft', timeLeft); // Store the remaining time in local storage
    }
}, 1000);

// Clear the local storage when the session is destroyed
window.addEventListener('beforeunload', function() {
    localStorage.removeItem('timeLeft'); // Optional: Clear the timer when leaving the page
});
</script>

<style>
.vip-section {
    background: #d4edda; /* Changed to a light green background */
    border: 1px solid #c3e6cb; /* Updated border color to match the green theme */
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
