<style>
  /* Existing styles */
  .user-img{
        position: absolute;
        height: 27px;
        width: 27px;
        object-fit: cover;
        left: -7%;
        top: -12%;
  }
  .btn-rounded{
        border-radius: 50px;
  }

  /* Responsive Navbar Styles */
  .navbar-top {
    background-color: #333;
    color: white;
    padding: 10px 20px;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
  }

  .navbar-brand {
    font-family: 'Cursive', sans-serif;
    font-size: 24px;
    color: white;
    display: flex;
    align-items: center;
    max-width: 70%;
  }

  .navbar-brand img {
    height: 40px;
    margin-right: 10px;
  }

  .contact-info {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
  }

  .contact-info span {
    display: none;
  }

  .navbar-bottom {
    background-color: #222;
    padding: 10px 20px;
    position: relative;
  }

  .hamburger {
    display: none;
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
  }

  .navbar-nav {
    display: flex;
    list-style: none;
    padding-left: 0;
    margin: 0;
    flex-direction: row;
    justify-content: center;
  }

  .navbar-nav .nav-item {
    margin-right: 15px;
  }

  .navbar-nav .nav-link {
    color: white;
    font-weight: bold;
    text-decoration: none;
    padding: 8px 12px;
    white-space: nowrap;
  }

  /* Mobile Styles */
  @media (max-width: 768px) {
    .navbar-brand {
      font-size: 18px;
    }
    
    .navbar-brand img {
      height: 30px;
    }

    .contact-info span {
      display: inline !important;
    }

    .contact-info a:not(.nav-link) {
      display: none;
    }

    .hamburger {
      display: block;
    }

    .navbar-nav {
      display: none;
      flex-direction: column;
      width: 100%;
      position: absolute;
      top: 100%;
      left: 0;
      background-color: #222;
      z-index: 1000;
      padding: 10px 0;
    }

    .navbar-nav.active {
      display: flex;
    }

    .navbar-nav .nav-item {
      margin-right: 0;
      width: 100%;
      text-align: center;
    }

    .navbar-nav .nav-link {
      padding: 12px;
      display: block;
    }

    .contact-info {
      order: 3;
      width: 100%;
      justify-content: center;
      margin-top: 10px;
      display: none;
    }
  }

  @media (max-width: 480px) {
    .navbar-brand div span {
      display: none;
    }
    
    .navbar-brand div small {
      font-size: 12px;
    }
  }
</style>

<!-- Top Navbar -->
<div class="navbar-top">
  <a href="<?php echo base_url ?>" class="navbar-brand">
    <img src="<?php echo validate_image($_settings->info('logo')) ?>" alt="Logo">
    <div>
      <span><?php echo $_settings->info('name'); ?></span>
      <br>
      <small>#1 Escort Agency in the Philippines</small>
    </div>
  </a>
  
  <div class="contact-info">
    <span>Manila and Philippines Escorts Girls</span>
    <a href="tel:+639772641926">+63 977 264 1926</a>
    <a href="#"><i class="fab fa-whatsapp"></i></a>
    <a href="#"><i class="fab fa-viber"></i></a>
    <?php if ($_settings->userdata('id')): ?>
      <button id="openModal" class="btn btn-primary" data-toggle="modal" data-target="#generateCodeModal">Generate Code</button>
      <button onclick="location.href='<?php echo base_url.'/classes/Login.php?f=logout' ?>'" class="btn btn-danger">LOGOUT</button>
    <?php endif; ?>
  </div>
</div>

<!-- Bottom Navbar -->
<nav class="navbar-bottom">
  <button class="hamburger">☰</button>
  <div class="container">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a href="<?php echo base_url ?>" class="nav-link">HOME</a>
      </li>
      <li class="nav-item">
        <a href="<?php echo base_url."?page=albums" ?>" class="nav-link">GALLERY</a>
      </li>
      <li class="nav-item">
        <a href="<?php echo base_url."?page=rates" ?>" class="nav-link">RATES</a>
      </li>
      <li class="nav-item">
        <a href="<?php echo base_url."?page=casting" ?>" class="nav-link">CASTING</a>
      </li>
      <li class="nav-item">
        <a href="<?php echo base_url."?page=faq" ?>" class="nav-link">FAQ'S</a>
      </li>
      <li class="nav-item">
        <a href="<?php echo base_url."?page=contactus" ?>" class="nav-link">CONTACT US</a>
      </li>
    </ul>
  </div>
</nav>

<!-- Modal Structure using Bootstrap -->
<div id="generateCodeModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="generateCodeModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="generateCodeModalLabel">Generate Code</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Click the button below to generate your code.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button onclick="location.href='<?php echo base_url.'admin/code_generator.php' ?>'" class="btn btn-primary">Generate Code</button>
      </div>
    </div>
  </div>
</div>

<script>
document.querySelector('.hamburger').addEventListener('click', function() {
  document.querySelector('.navbar-nav').classList.toggle('active');
});

// Close menu when clicking outside
document.addEventListener('click', function(event) {
  const nav = document.querySelector('.navbar-nav');
  const hamburger = document.querySelector('.hamburger');
  
  if (!nav.contains(event.target) && !hamburger.contains(event.target)) {
    nav.classList.remove('active');
  }
});

// Close menu on resize
window.addEventListener('resize', function() {
  if (window.innerWidth > 768) {
    document.querySelector('.navbar-nav').classList.remove('active');
  }
});

// Open the modal
document.getElementById('openModal').addEventListener('click', function() {
  document.getElementById('generateCodeModal').style.display = 'block';
});

// Close the modal when the close button is clicked
document.querySelector('.close').addEventListener('click', function() {
  document.getElementById('generateCodeModal').style.display = 'none';
});

// Close the modal when clicking outside of it
window.addEventListener('click', function(event) {
  const modal = document.getElementById('generateCodeModal');
  if (event.target === modal) {
    modal.style.display = 'none';
  }
});
</script>