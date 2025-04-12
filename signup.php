<?php
// cnx
include("cnx.php"); 
$cnx = mysqli_connect('localhost', 'root', '', 'gourmet');
if (!$cnx) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();  

// requete sql 
if (isset($_POST['signup'])) {
    $nom       = $_POST['nom_complet'];  
    $email     = $_POST['email'];  
    $telephone = $_POST['telephone'];  
    $mdp       = $_POST['mdp'];  

    // insertion 
    $mdp = sha1($mdp); // Hash the password
    $sql_insert = "INSERT INTO `clients`(`nom_complet`, `email`, `telephone`, `mdp`, `type`, `active`)
                   VALUES ('$nom', '$email', '$telephone', '$mdp', 'client', '1')";
    $inserted = mysqli_query($cnx, $sql_insert);

    header('Location: signup.php?inserted'); 
}
?>

<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
    <script src="../assets/js/color-modes.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <title>Signup - Le Gourmet</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/carousel/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/carousel.css" rel="stylesheet">
    <!-- Ion Icons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <style>
        @font-face {
            src: url(fonts/BodoniModa-Italic-VariableFont_opsz,wght.ttf);
            font-family: "BodoniModa-Italic"; 
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            font-family: 'BodoniModa-Italic', sans-serif !important;
            background: linear-gradient(120deg, #060834, #1a2a5a, #060834);
            background-size: 200% 200%;
            animation: gradientBG 10s ease infinite;
            position: relative;
            overflow: hidden;
        }

        /* Background Animation */
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Subtle Texture Overlay */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.3;
            z-index: 0;
        }

        /* Floating Elements (Wine-inspired) */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            background: rgba(128, 0, 32, 0.3); /* Deep wine red */
            border-radius: 50%;
            box-shadow: 0 0 8px rgba(128, 0, 32, 0.2);
            animation: float 9s infinite ease-in-out;
        }

        .particle:nth-child(1) { width: 12px; height: 12px; top: 10%; left: 25%; animation-duration: 8s; }
        .particle:nth-child(2) { width: 18px; height: 18px; top: 65%; left: 75%; animation-duration: 10s; }
        .particle:nth-child(3) { width: 15px; height: 15px; top: 35%; left: 45%; animation-duration: 7s; }
        .particle:nth-child(4) { width: 10px; height: 10px; top: 80%; left: 15%; animation-duration: 11s; }
        .particle:nth-child(5) { width: 14px; height: 14px; top: 20%; left: 60%; animation-duration: 9s; }

        @keyframes float {
            0%, 100% { transform: translateY(0) translateX(0); opacity: 0.4; }
            50% { transform: translateY(-30px) translateX(10px); opacity: 0.7; }
        }

        .container {
            position: relative;
            max-width: 600px;
            background-color: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 245, 224, 0.3); /* Cream accent */
            border-radius: 20px;
            backdrop-filter: blur(15px);
            padding: 40px;
            box-shadow: 0 0 20px rgba(6, 8, 52, 0.3);
            z-index: 1;
        }

        h2 {
            font-size: 2rem;
            color: #fff5e0; /* Cream */
            text-align: center;
            margin-bottom: 30px;
            text-shadow: 0 2px 5px rgba(6, 8, 52, 0.4);
        }

        .inputbox {
            position: relative;
            margin: 25px 0;
            border-bottom: 2px solid #fff5e0; /* Cream */
        }

        .input {
            width: 100%;
            height: 50px;
            background: transparent;
            border: none;
            outline: none;
            font-size: 1rem;
            padding: 0 35px 0 5px;
            color: #fff;
            transition: all 0.3s ease;
        }

        .input:focus,
        .input:valid {
            border-bottom: 2px solid #e6d8b3; /* Lighter cream */
        }

        .inputbox ion-icon {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            color: #fff5e0; /* Cream */
            font-size: 1.2rem;
        }

        .inputbox label {
            position: absolute;
            top: 50%;
            left: 5px;
            transform: translateY(-50%);
            color: #fff;
            font-size: 1rem;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .input:focus ~ label,
        .input:valid ~ label {
            top: -5px;
            font-size: 0.8rem;
            color: #fff5e0; /* Cream */
        }

        .form-text {
            color: #ccc;
            font-size: 0.85rem;
            margin-top: 5px;
        }

        button {
            width: 100%;
            height: 45px;
            border-radius: 40px;
            background: linear-gradient(45deg, #060834, #1a2a5a); /* Navy gradient */
            border: 1px solid #fff5e0; /* Cream border */
            outline: none;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            color: #fff5e0; /* Cream text */
            transition: all 0.4s ease;
            box-shadow: 0 4px 12px rgba(6, 8, 52, 0.3);
            text-transform: uppercase;
        }

        button:hover {
            background: linear-gradient(45deg, #1a2a5a, #060834);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(6, 8, 52, 0.5);
        }
    </style>
    <?php include("header.php"); ?>
</head>
<body>
    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <div class="container">
        <form action="signup.php" method="POST">
            <h2>Formulaire d'inscription</h2>
            
            <div class="inputbox">
                <ion-icon name="person-outline"></ion-icon>
                <input type="text" autocomplete="off" name="nom_complet" class="input" placeholder=" " required>
                <label>Nom Complet</label>
            </div>

            <div class="inputbox">
                <ion-icon name="mail-outline"></ion-icon>
                <input type="email" autocomplete="off" name="email" class="input" placeholder=" " aria-describedby="emailHelp" required>
                <label>Email</label>
            </div>

            <div class="inputbox">
                <ion-icon name="call-outline"></ion-icon>
                <input type="text" autocomplete="off" name="telephone" class="input" placeholder=" " required>
                <label>Téléphone</label>
            </div>

            <div class="inputbox">
                <ion-icon name="lock-closed-outline"></ion-icon>
                <input type="password" autocomplete="off" name="mdp" class="input" placeholder=" " required>
                <label>Mot de passe</label>
            </div>

            <button type="submit" name="signup">S'inscrire</button>
        </form>
    </div>
</body>
</html>