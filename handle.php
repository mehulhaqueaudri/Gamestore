<?php
require_once('DBconnect.php');

$message = "";


if (isset($_POST['update_status'])) {
    $ticket_id = $_POST['ticket_id'];
    $new_status = $_POST['new_status'];

    $update_sql = "UPDATE support_ticket SET status = ? WHERE ticket_id = ?";
    $stmt = mysqli_prepare($conn, $update_sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "si", $new_status, $ticket_id);
        if (mysqli_stmt_execute($stmt)) {
            $message = "Ticket #$ticket_id updated to $new_status successfully.";
        }
        mysqli_stmt_close($stmt);
    }
}


$sql = "SELECT * FROM support_ticket ORDER BY ticket_id DESC";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Database Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Manage Tickets</title>
    <style>
        :root {
            --bg: #0f0f0f;
            --card: #1a1a1a;
            --accent: #ffc107;
            --text: #e0e0e0;
            --btn-hover: #ffca2c;
        }

        body { 
            font-family: 'Segoe UI', sans-serif; 
            background: var(--bg); 
            color: var(--text); 
            padding: 40px; 
            margin: 0; 
        }

        /* Header Layout */
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .header-left {
            border-left: 4px solid var(--accent);
            padding-left: 20px;
        }

        .header-left h1 {
            color: var(--accent);
            letter-spacing: 1px;
            margin: 0;
            text-transform: uppercase;
        }

        .header-left p {
            margin: 5px 0 0 0;
            color: #888;
        }

        /* Forward Arrow Button Styling */
        .btn-forward {
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

        .btn-forward:hover {
            background: var(--accent);
            color: #000;
            transform: translateX(8px);
            box-shadow: 0 0 20px rgba(255, 193, 7, 0.2);
        }


        /* Table Styling */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            background: var(--card); 
            border-radius: 12px; 
            overflow: hidden; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.5); 
        }

        th { 
            background: #262626; 
            color: var(--accent); 
            text-align: left; 
            padding: 18px; 
            font-size: 0.8rem; 
            text-transform: uppercase; 
            letter-spacing: 1px;
        }

        td { 
            padding: 18px; 
            border-bottom: 1px solid #333; 
            font-size: 0.95rem; 
        }

        .desc-cell { 
            max-width: 400px; 
            line-height: 1.6; 
            color: #bbb; 
        }

        /* Status Badges */
        .status-badge { 
            padding: 5px 12px; 
            border-radius: 4px; 
            font-size: 0.75rem; 
            font-weight: bold; 
            display: inline-block; 
            text-transform: uppercase;
        }

        .Ongoing { background: #3d5afe; color: white; }
        .Fixed { background: #4caf50; color: white; }
        .New { background: #555; color: white; }

        /* Form Elements */
        select { 
            background: #262626; 
            color: white; 
            border: 1px solid #444; 
            padding: 8px; 
            border-radius: 4px; 
            outline: none; 
        }

        .btn-update { 
            background: var(--accent); 
            color: #000; 
            border: none; 
            padding: 8px 16px; 
            border-radius: 4px; 
            font-weight: bold; 
            cursor: pointer; 
            transition: 0.2s; 
        }

        .btn-update:hover { 
            background: var(--btn-hover); 
            transform: scale(1.05); 
        }

        .logout { 
            color: #ff5252; 
            text-decoration: none; 
            font-weight: bold; 
        }
        
        .logout:hover { text-decoration: underline; }

        .alert { 
            background: rgba(76, 175, 80, 0.1); 
            color: #4caf50; 
            border: 1px solid #4caf50; 
            padding: 15px; 
            border-radius: 8px; 
            margin-bottom: 25px; 
        }
    </style>
</head>
<body>

<div class="header-container">
    <div class="header-left">
        <h1>Support Ticket Management</h1>
        <p>Admin Control Panel | <a class="logout" href="index.php">Logout</a></p>
    </div>

    <a href="manage.php" class="btn-forward">
        Inventory Management 
    </a>
</div>

<?php if($message): ?>
    <div class="alert"><?php echo $message; ?></div>
<?php endif; ?>



<table>
    <thead>
        <tr>
            <th>Ticket ID</th>
            <th>User ID</th>
            <th>Issue Description</th>
            <th>Current Status</th>
            <th>Update Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): 
            $display_status = $row['status'] ?: "New";
        ?>
        <tr>
            <td>#<?php echo $row['ticket_id']; ?></td>
            <td><strong>User #<?php echo $row['user_id']; ?></strong></td>
            <td class="desc-cell"><?php echo htmlspecialchars($row['description']); ?></td>
            <td>
                <span class="status-badge <?php echo $display_status; ?>">
                    <?php echo $display_status; ?>
                </span>
            </td>
            <td>
                <form method="POST" style="display:flex; gap:10px; align-items: center;">
                    <input type="hidden" name="ticket_id" value="<?php echo $row['ticket_id']; ?>">
                    <select name="new_status">
                        <option value="Ongoing" <?php if($row['status'] == 'Ongoing') echo 'selected'; ?>>Ongoing</option>
                        <option value="Fixed" <?php if($row['status'] == 'Fixed') echo 'selected'; ?>>Fixed</option>
                    </select>
                    <button type="submit" name="update_status" class="btn-update">Save</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>