<?php
require_once('DBconnect.php');


$user_id = isset($_GET['u_id']) ? $_GET['u_id'] : null; 

if (!$user_id) {
    die("Error: User ID is required. Please login.");
}


$sql = "SELECT g.*, 
        (SELECT AVG(rating_value) FROM ratings WHERE game_id = g.game_id) AS avg_rating,
        (SELECT COUNT(*) FROM ratings WHERE game_id = g.game_id) AS total_votes,
        (SELECT COUNT(*) FROM wishlist WHERE game_id = g.game_id) AS total_wishlists
        FROM games g order by title ASC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GameStore | Browse Games</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #121212; color: #e0e0e0; margin: 0; padding: 20px; }
        .header { background: #1f1f1f; padding: 20px; border-radius: 10px; text-align: center; margin-bottom: 30px; border-bottom: 3px solid #3d5afe; }
        .container { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 25px; max-width: 1200px; margin: 0 auto; }
        
      
        .card { background: #1e1e1e; border-radius: 12px; overflow: hidden; border: 1px solid #333; transition: 0.3s; padding: 20px; position: relative; }
        .card:hover { border-color: #3d5afe; transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.5); }
        
        .title { font-size: 1.5rem; font-weight: bold; margin-bottom: 5px; color: #fff; }
        .genre { color: #3d5afe; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px; }
        
        .stats { display: flex; justify-content: space-between; background: #262626; padding: 10px; border-radius: 8px; margin: 15px 0; font-size: 0.85rem; }
        .rating { color: #ffca28; font-weight: bold; }
        .wish-count { color: #ff4081; font-weight: bold; }
        .stock-count { color: #aaa; }

        .price-tag { font-size: 1.4rem; color: #4caf50; font-weight: bold; margin-bottom: 20px; }
        
      
        .btn { display: block; text-align: center; padding: 12px; margin-bottom: 10px; border-radius: 6px; text-decoration: none; font-weight: bold; transition: 0.2s; }
        .buy-btn { background: #3d5afe; color: white; }
        .buy-btn:hover { background: #2e4ad1; }
        .wish-btn { border: 1px solid #ff4081; color: #ff4081; }
        .wish-btn:hover { background: #ff4081; color: white; }
        .out-of-stock { background: #444; color: #888; cursor: not-allowed; }
        
       
        .rate-box { background: #262626; padding: 10px; border-radius: 8px; text-align: center; margin-top: 10px; }
        .rate-label { font-size: 0.7rem; color: #888; margin-bottom: 5px; display: block; }
        .stars a { color: #555; text-decoration: none; font-size: 1.2rem; margin: 0 3px; transition: 0.2s; }
        .stars a:hover { color: #ffca28; }

        .alert { background: #4caf50; color: white; padding: 15px; border-radius: 8px; text-align: center; margin-bottom: 20px; max-width: 600px; margin-left: auto; margin-right: auto; }
    </style>
</head>
<body>

    <div class="header">
        <h1>GameStore Catalog</h1>
        <p>User ID: <span style="color:#3d5afe">#<?php echo htmlspecialchars($user_id); ?></span> | <a href="home.php?u_id=<?php echo $user_id; ?>" style="color:#aaa; text-decoration:none;">Dashboard</a></p>
    </div>

    <?php if(isset($_GET['msg'])): ?>
        <div class="alert">
            <?php echo htmlspecialchars($_GET['msg']); ?>
        </div>
    <?php endif; ?>

    <div class="container">
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <div class="card">
                <div class="genre"><?php echo $row['genre']; ?></div>
                <div class="title"><?php echo $row['title']; ?></div>
                <div style="font-size: 0.8rem; color: #888;">Publisher: <?php echo $row['publisher']; ?></div>

                <div class="stats">
                    <span class="rating">⭐ <?php echo $row['avg_rating'] ? number_format($row['avg_rating'], 1) : "0.0"; ?> (<?php echo $row['total_votes']; ?>)</span>
                    
                    <span class="wish-count">❤️ <?php echo $row['total_wishlists']; ?></span>
                    
                    <span class="stock-count">📦 <?php echo $row['quantity']; ?> Left</span>
                </div>

                <div class="price-tag">
                    $<?php echo number_format($row['price'], 2); ?>
                </div>

                <div class="actions">
                    <?php if($row['quantity'] > 0): ?>
                        <a href="buy.php?g_id=<?php echo $row['game_id']; ?>&u_id=<?php echo $user_id; ?>" class="btn buy-btn">BUY NOW</a>
                    <?php else: ?>
                        <a href="#" class="btn out-of-stock">OUT OF STOCK</a>
                    <?php endif; ?>

                    <a href="wishlist.php?g_id=<?php echo $row['game_id']; ?>&u_id=<?php echo $user_id; ?>" class="btn wish-btn">ADD TO WISHLIST</a>

                    <div class="rate-box">
                        <span class="rate-label">RATE THIS GAME</span>
                        <div class="stars">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <a href="rate.php?id=<?php echo $row['game_id']; ?>&u_id=<?php echo $user_id; ?>&rating=<?php echo $i; ?>" title="Rate <?php echo $i; ?>">
                                    <?php echo $i; ?>
                                </a>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

</body>
</html>