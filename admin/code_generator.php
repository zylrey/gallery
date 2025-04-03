<?php
// ... existing code ...

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Generate a random code
    $code = bin2hex(random_bytes(15)); // Generates a random 30-character hexadecimal string
    $date_created = date('Y-m-d H:i:s');

    // Database connection using DBConnection class
    require_once('../classes/DBConnection.php');
    $db = new DBConnection();
    $conn = $db->conn;

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO user_code (code, date_created) VALUES (?, ?)");
    $stmt->bind_param("ss", $code, $date_created);
    $stmt->execute();
    $stmt->close();

    // Redirect to a success page or back to the original page
    //header("Location: /"); // Redirect to the base URL
    //exit();
}

// ... existing code ...
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Random Code Generator</title>
</head>
<body>
<div class="container">
    <h1 class="mt-5">Random Code Generator</h1>
    <form method="POST" class="mt-3">
        <button type="submit" class="btn btn-primary">Generate Code</button>
        <a href="<?php echo base_url ?>" class="btn btn-secondary">Back</a>
    </form>
    <?php if (isset($code)): ?>
        <div class="alert alert-success mt-3">Generated Code: <?php echo $code; ?></div>
    <?php endif; ?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
