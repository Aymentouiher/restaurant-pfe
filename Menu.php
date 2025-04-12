<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Le Gourmet</title>
    <link href="/PFE/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'BodoniModa-Italic';
            src: url('/PFE/fonts/BodoniModa-Italic-VariableFont_opsz,wght.ttf') format('truetype');
        }

        body {
            font-family: 'BodoniModa-Italic', sans-serif !important;
            background: linear-gradient(120deg, #060834, #1a2a5a, #060834);
            background-size: 200% 200%;
            animation: gradientBG 10s ease infinite;
            color: #fff5e0;
            margin: 0;
            padding: 0;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        h2 {
            text-align: center;
            padding: 40px 0;
            font-size: 2.5rem;
            color: #fff5e0;
            text-shadow: 0 2px 5px rgba(6, 8, 52, 0.4);
        }

        .menu-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .menu-card {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 245, 224, 0.3);
            border-radius: 15px;
            backdrop-filter: blur(10px);
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 10px rgba(6, 8, 52, 0.3);
        }

        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(6, 8, 52, 0.5);
        }

        .menu-card img {
            max-width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .menu-card h3 {
            font-size: 1.5rem;
            margin: 10px 0;
            color: #fff5e0;
        }

        .menu-card p {
            font-size: 1rem;
            color: #e6d8b3;
            margin: 5px 0;
        }

        .menu-card .price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #ff6b6b;
            margin-top: 10px;
        }

        .no-plats {
            text-align: center;
            font-size: 1.2rem;
            color: #e6d8b3;
            padding: 20px;
        }
    </style>
</head>
<body>

    <?php include("header.php"); ?>

    <h2>Notre Menu</h2>

    <div class="menu-container">
        <div class="menu-grid">
            <?php
            include("cnx.php");

            $sql = mysqli_query($cnx, "SELECT * FROM plats");

            if (mysqli_num_rows($sql) > 0) {
                while ($plat = mysqli_fetch_assoc($sql)) {
                    $image = !empty($plat['image']) ? htmlspecialchars($plat['image']) : '/PFE/uploads/default.jpg';
                    ?>
                    <div class="menu-card">
                        <img src="<?php echo $image; ?>" alt="<?php echo htmlspecialchars($plat['nom']); ?>">
                        <h3><?php echo htmlspecialchars($plat['nom']); ?></h3>
                        <p><?php echo htmlspecialchars($plat['description']); ?></p>
                        <p class="price"><?php echo htmlspecialchars($plat['prix']); ?> MAD</p>
                    </div>
                    <?php
                }
            } else {
                echo "<p class='no-plats'>Aucun plat disponible.</p>";
            }
            ?>
        </div>
    </div>

    <?php include("footer.php"); ?>

    <!-- Bootstrap JS -->
    <script src="/PFE/js/bootstrap.bundle.min.js"></script>
</body>
</html>