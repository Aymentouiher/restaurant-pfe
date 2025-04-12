<?php
include("cnx.php");
session_start();

if (isset($_SESSION['id'])) {
    $redirect = strtolower($_SESSION['type']) === 'admin' ? "dashboard.php" : "index.php";
    header("Location: " . $redirect);
    exit();
}

if (isset($_POST['signin'])) {
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $mdp_hashed = sha1($mdp);

    $stmt = $cnx->prepare("SELECT * FROM `clients` WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($data) {
        // Debug: Show password comparison
        echo "Stored password hash: " . $data['mdp'] . "<br>";
        echo "Entered password hash: " . $mdp_hashed . "<br>";

        // Verify password
        if ($data['mdp'] === $mdp_hashed) {
            // Set session variables
            $_SESSION['id'] = $data['id'];
            $_SESSION['nom'] = $data['nom_complet'] ?? '';
            $_SESSION['email'] = $data['email'] ?? '';
            $_SESSION['telephone'] = $data['telephone'] ?? '';
            $_SESSION['type'] = $data['type'] ?? '';

            echo "User type from DB: " . $data['type'] . "<br>";
            echo "Session type set to: " . $_SESSION['type'] . "<br>";
            $redirect = strtolower($_SESSION['type']) === 'admin' ? "dashboard.php" : "index.php";
            echo "Redirecting to: " . $redirect . "<br>";

            header("Location: " . $redirect);
            exit();
        } else {
            $error = "Mot de passe incorrect.";
        }
    } else {
        $error = "Aucun utilisateur trouvé avec cet email.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="fr" data-bs-theme="auto">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Le Gourmet</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/dashboard/">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <style>
        @font-face {
            font-family: "BodoniModa-Italic";
            src: url("fonts/BodoniModa-Italic-VariableFont_opsz,wght.ttf") format("truetype");
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
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
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
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
            background: rgba(128, 0, 32, 0.3);
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
        section {
            position: relative;
            max-width: 400px;
            background-color: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 245, 224, 0.3);
            border-radius: 20px;
            backdrop-filter: blur(15px);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 4rem 5rem;
            box-shadow: 0 0 20px rgba(6, 8, 52, 0.3);
            z-index: 1;
        }
        h1 {
            font-size: 2rem;
            color: #fff5e0;
            text-align: center;
            text-shadow: 0 2px 5px rgba(6, 8, 52, 0.4);
        }
        .inputbox {
            position: relative;
            margin: 30px 0;
            max-width: 310px;
            border-bottom: 2px solid #fff5e0;
            padding-bottom: 5px;
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
        input:focus ~ label, input:valid ~ label {
            top: -15px;
            font-size: 0.8rem;
            color: #fff5e0;
        }
        .inputbox input {
            width: 100%;
            height: 50px;
            background: transparent;
            border: none;
            outline: none;
            font-size: 1rem;
            padding: 0 5px;
            color: #fff;
        }
        .inputbox ion-icon {
            color: #fff5e0;
            margin-right: 5px;
        }
        .forget {
            margin: 35px 0;
            font-size: 0.85rem;
            color: #fff;
            display: flex;
            justify-content: space-between;
        }
        .forget label { display: flex; align-items: center; }
        .forget label input { margin-right: 3px; accent-color: #fff5e0; }
        .forget a { color: #fff5e0; text-decoration: none; font-weight: 600; }
        .forget a:hover { text-decoration: underline; color: #e6d8b3; }
        button {
            width: 100%;
            height: 40px;
            border-radius: 40px;
            background: linear-gradient(45deg, #060834, #1a2a5a);
            border: 1px solid #fff5e0;
            outline: none;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            color: #fff5e0;
            transition: all 0.4s ease;
            box-shadow: 0 4px 12px rgba(6, 8, 52, 0.3);
        }
        button:hover {
            background: linear-gradient(45deg, #1a2a5a, #060834);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(6, 8, 52, 0.5);
        }
        .register {
            font-size: 0.9rem;
            color: #fff;
            text-align: center;
            margin: 25px 0 10px;
        }
        .register p a { text-decoration: none; color: #fff5e0; font-weight: 600; }
        .register p a:hover { text-decoration: underline; color: #e6d8b3; }
        .error {
            color: #ff6b6b;
            text-align: center;
            margin-top: 10px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
<?php include('header.php'); ?>

    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <section>
        <form action="signin.php" method="POST">
            <h1>Connexion</h1>
            <div class="inputbox">
                <ion-icon name="mail-outline"></ion-icon>
                <input type="email" name="email" required>
                <label>Email</label>
            </div>
            <div class="inputbox">
                <ion-icon name="lock-closed-outline"></ion-icon>
                <input type="password" name="mdp" required>
                <label>Mot de passe</label>
            </div>
            <div class="forget">
                <label><input type="checkbox">Se souvenir de moi</label>
                <a href="#">Mot de passe oublié ?</a>
            </div>
            <button type="submit" name="signin">Se connecter</button>
            <?php if (isset($error)) { ?>
                <div class="error"><?php echo $error; ?></div>
            <?php } ?>
            <div class="register">
                <p>Pas de compte ? <a href="signup.php">Inscrivez-vous</a></p>
            </div>
        </form>
    </section>
</body>
</html>