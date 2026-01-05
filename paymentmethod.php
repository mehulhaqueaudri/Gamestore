<?php
require_once('DBconnect.php');


$u_id = isset($_GET['u_id']) ? $_GET['u_id'] : null;


if (!$u_id) {
    die("Error: User identity lost. Please login again.");
}

$message = "";
$message_type = "";


if (isset($_POST['save_payment'])) {
    $current_uid = $_POST['user_id_hidden'];
    $m_type = $_POST['method_type'];

    
    $sql = "INSERT INTO payment_method (user_id, method_type) 
            VALUES (?, ?) 
            ON DUPLICATE KEY UPDATE method_type = VALUES(method_type)";
    
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "is", $current_uid, $m_type);
        if (mysqli_stmt_execute($stmt)) {
            $message = "Payment method updated successfully!";
            $message_type = "success";
        } else {
            $message = "Error: " . mysqli_error($conn);
            $message_type = "error";
        }
        mysqli_stmt_close($stmt);
    }
}


$existing_method = "";
$fetch_sql = "SELECT method_type FROM payment_method WHERE user_id = ?";
$fetch_stmt = mysqli_prepare($conn, $fetch_sql);
mysqli_stmt_bind_param($fetch_stmt, "i", $u_id);
mysqli_stmt_execute($fetch_stmt);
$res = mysqli_stmt_get_result($fetch_stmt);
if ($row = mysqli_fetch_assoc($res)) {
    $existing_method = $row['method_type'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Settings</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #121212; color: #e0e0e0; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background-color: #1e1e1e; padding: 30px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); width: 350px; border: 1px solid #333; }
        h2 { text-align: center; margin-bottom: 5px; color: #fff; }
        .u-info { text-align: center; color: #888; font-size: 0.8rem; margin-bottom: 20px; }
        label { display: block; margin-bottom: 10px; font-size: 0.9rem; }
        select { width: 100%; padding: 12px; background: #2c2c2c; border: 1px solid #444; color: white; border-radius: 6px; margin-bottom: 20px; outline: none; cursor: pointer; }
        button { width: 100%; padding: 12px; background: #3d5afe; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; transition: 0.3s; }
        button:hover { background: #2e4ad1; }
        .alert { padding: 10px; border-radius: 5px; text-align: center; margin-bottom: 15px; font-size: 0.9rem; }
        .success { background: #1b5e20; color: #c8e6c9; }
        .error { background: #b71c1c; color: #ffcdd2; }
        .back { display: block; text-align: center; margin-top: 15px; color: #888; text-decoration: none; font-size: 0.8rem; }
        .back:hover { color: #3d5afe; }
    </style>
</head>
<body>

<div class="card">
    <h2>Payment Method</h2>
    <p class="u-info">User ID: #<?php echo htmlspecialchars($u_id); ?></p>

    <?php if($message): ?>
        <div class="alert <?php echo $message_type; ?>"><?php echo $message; ?></div>
    <?php endif; ?>

    <form action="paymentmethod.php?u_id=<?php echo $u_id; ?>" method="POST">
        
        <input type="hidden" name="user_id_hidden" value="<?php echo htmlspecialchars($u_id); ?>">

        <label for="method_type">Select your payment type:</label>
        <select name="method_type" id="method_type" required>
            <option value="" disabled <?php if($existing_method == "") echo "selected"; ?>>-- Choose One --</option>
            <option value="credit_card" <?php if($existing_method == "credit_card") echo "selected"; ?>>💳 Credit Card</option>
            <option value="paypal" <?php if($existing_method == "paypal") echo "selected"; ?>>🅿️ PayPal</option>
            <option value="crypto" <?php if($existing_method == "crypto") echo "selected"; ?>>🪙 Cryptocurrency</option>
            <option value="bank_transfer" <?php if($existing_method == "bank_transfer") echo "selected"; ?>>🏦 Bank Transfer</option>
        </select>

        <button type="submit" name="save_payment">Save Changes</button>
    </form>

    <a href="home.php?u_id=<?php echo $u_id; ?>" class="back">← Return to Dashboard</a>
</div>

</body>
</html>