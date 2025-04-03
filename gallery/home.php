<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<div class="hero-section">
    <div class="hero-text">
        <h1>Metro Gensan's #1 Escort Service.</h1>
        <p>We Are Open 24/7</p>
        <p>Drama and Scam free environment! Browse and enjoy the best escort agency in the Philippines!</p>
    </div>
</div>

<div class="info-section">
    <p>What you see is what you get. Always!</p>
    <p>Feel free to call, text or chat with our operator for inquiries or bookings.</p>
</div>

<div class="gallery-section">
    <h2>Our Models</h2>
    <p>100% Real and Recent Pictures Guaranteed or pay NO rejection fee</p>
    <div class="gallery">
        <!-- Example images, replace with dynamic content -->
        <?php
        $images = glob('albums/*.jpg'); // Fetch all jpg images from the albums folder
        foreach($images as $image): ?>
            <div class="image-box">
                <img src="<?php echo $image; ?>" alt="Model Image">
            </div>
        <?php endforeach; ?>
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
</div>

<style>
    body {
        margin: 0;
    }
    .hero-section {
        background-image: url('cityscape.jpg'); /* Replace with your image */
        background-size: cover;
        background-position: center;
        padding: 150px 20px;
        color: #fff;
        text-align: center;
        position: relative;
    }
    .hero-text {
        background-color: rgba(0, 0, 0, 0.6);
        display: inline-block;
        padding: 30px;
        border-radius: 10px;
    }
    .info-section {
        background-color: #333;
        color: #fff;
        text-align: center;
        padding: 40px 20px;
    }
    .gallery-section {
        background-color: #f8f9fa;
        padding: 40px 20px;
        text-align: center;
    }
    .gallery img {
        width: 30%;
        margin: 10px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .image-container {
        height: 300px; /* Adjust height as needed */
        overflow: hidden;
        position: relative;
        border-radius: 10px; /* Add border radius for rounded corners */
    }
    .profile-image {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Ensures the image covers the container */
        transition: transform 0.3s ease;
    }
    .profile-card {
        transition: all 0.3s ease;
        background: white;
        border: 1px solid #eee; /* Adjust border as needed */
        border-radius: 10px; /* Add border radius for rounded corners */
        overflow: hidden; /* Ensures no overflow */
    }
    .profile-info {
        padding: 10px; /* Adjust padding for better spacing */
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
</style>
