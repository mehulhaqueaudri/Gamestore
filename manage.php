<?php
require_once('DBconnect.php');
$message = "";


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_qty'])) {
    $game_id = $_POST['game_id'];
    $new_qty = $_POST['new_qty'];

    $sql = "UPDATE games SET quantity = ? WHERE game_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $new_qty, $game_id);

    if (mysqli_stmt_execute($stmt)) {
        $message = "Inventory updated successfully!";
    } else {
        $message = "Error updating inventory: " . mysqli_error($conn);
    }
}


$sql = "SELECT game_id, title, genre, quantity, price, no_of_wishlists FROM games ORDER BY title ASC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin | Inventory Management</title>
    <style>
        :root {
            --bg: #0f0f0f;
            --card: #1a1a1a;
            --accent: #ffc107;
            --text: #e0e0e0;
            --danger: #ff5252;
            --wishlist: #ff4081;
        }

        body { font-family: 'Segoe UI', sans-serif; background: var(--bg); color: var(--text); padding: 40px; margin: 0; }
        
        .header-container { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 30px;
        }

        .header-left { border-left: 4px solid var(--accent); padding-left: 20px; }
        h1 { color: var(--accent); letter-spacing: 1px; margin: 0; text-transform: uppercase; }
        
        .logout { color: #ff5252; text-decoration: none; font-weight: bold; margin-left: 5px; }
        .logout:hover { text-decoration: underline; }

        /* Navigation Button Styling - Backward Arrow Feel */
        .btn-nav {
            display: inline-flex;
            align-items: center;
            background: #262626;
            color: var(--accent);
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            border: 1px solid #444;
            transition: all 0.3s ease;
        }

        .btn-nav:hover {
            background: var(--accent);
            color: #000;
            transform: translateX(-8px); /* Moves left to indicate "Back" */
            box-shadow: 0 0 20px rgba(255, 193, 7, 0.2);
        }

        .btn-nav span { margin-right: 10px; font-size: 1.2rem; }
        
        .alert { background: rgba(76, 175, 80, 0.1); color: #4caf50; border: 1px solid #4caf50; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        
        table { width: 100%; border-collapse: collapse; background: var(--card); border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        th { background: #262626; color: var(--accent); text-align: left; padding: 18px; font-size: 0.85rem; text-transform: uppercase; }
        td { padding: 15px; border-bottom: 1px solid #333; }
        
        .low-stock { color: var(--danger); font-weight: bold; }
        .stock-badge { padding: 4px 8px; border-radius: 4px; background: #333; font-size: 0.9rem; }
        .wish-badge { color: var(--wishlist); font-weight: bold; display: flex; align-items: center; gap: 5px; }

        input[type="number"] {
            background: #262626; color: white; border: 1px solid #444; padding: 8px; border-radius: 4px; width: 80px; outline: none;
        }

        .btn-save {
            background: var(--accent); color: #000; border: none; padding: 8px 15px; border-radius: 4px; font-weight: bold; cursor: pointer; transition: 0.2s;
        }

        .btn-save:hover { background: #ffca2c; transform: translateY(-1px); }
    </style>
</head>
<body>

<div class="header-container">
    <div class="header-left">
        <h1>Inventory Control</h1>
        <p>Logged in as Administrator | <a class="logout" href="index.php">Logout</a></p>
    </div>

    <a href="handle.php" class="btn-nav">
       <span>⬅</span> Support Ticket Management 
    </a>
</div>

<?php if($message): ?>
    <div class="alert"><?php echo $message; ?></div>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Game Title</th>
            <th>Wishlists</th>
            <th>Current Stock</th>
            <th>Set New Quantity</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td>#<?php echo $row['game_id']; ?></td>
            <td>
                <strong><?php echo htmlspecialchars($row['title']); ?></strong><br>
                <small style="color: #666;"><?php echo htmlspecialchars($row['genre']); ?></small>
            </td>
            <td>
                <span class="wish-badge">
                    ❤️ <?php echo $row['no_of_wishlists']; ?>
                </span>
            </td>
            <td>
                <span class="stock-badge <?php echo ($row['quantity'] < 5) ? 'low-stock' : ''; ?>">
                    <?php echo $row['quantity']; ?> pcs
                    <?php if($row['quantity'] < 5) echo " ⚠️ LOW"; ?>
                </span>
            </td>
            <td>
                <form method="POST" style="display: flex; gap: 10px; align-items: center;">
                    <input type="hidden" name="game_id" value="<?php echo $row['game_id']; ?>">
                    <input type="number" name="new_qty" value="<?php echo $row['quantity']; ?>" min="0" required>
                    <button type="submit" name="update_qty" class="btn-save">Update</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>