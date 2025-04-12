<?php
include("cnx.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom        = $_POST['nom'];
    $email      = $_POST['email'];
    $telephone  = $_POST['telephone'];
    $date       = $_POST['date'];
    $heure      = $_POST['heure'];
    $personnes  = $_POST['personnes'];

    $reservation_time = $date . ' ' . $heure . ':00';

    $stmt = $cnx->prepare("INSERT INTO reservations (`nom`, `email`, `telephone`, `heure`, `personnes`) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nom, $email, $telephone, $reservation_time, $personnes);

    if ($stmt->execute()) {
        $message = "<p class='success'>✅ Réservation effectuée avec succès !</p>";
        // Générer le QR code
        require_once 'phpqrcode/qrlib.php';
        $qrContent = "Réservation\nNom: $nom\nDate: $date\nHeure: $heure\nPersonnes: $personnes";
        $qrFile = "qrcodes/reservation_" . time() . ".png"; // Nom unique avec timestamp
        QRcode::png($qrContent, $qrFile, QR_ECLEVEL_L, 5);
        $message .= "<p>Scannez ce QR code au restaurant :</p><img src='$qrFile' alt='QR Code' style='max-width: 200px;'>";
    } else {
        $message = "<p class='error'>❌ Erreur lors de la réservation : " . $stmt->error . "</p>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation - Le Gourmet</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <style>
        @font-face {
            font-family: "BodoniModa-Italic";
            src: url("fonts/BodoniModa-Italic-VariableFont_opsz,wght.ttf") format("truetype");
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            min-height: 100vh;
            font-family: 'BodoniModa-Italic', sans-serif !important;
            background: linear-gradient(120deg, #060834, #1a2a5a, #060834);
            background-size: 200% 200%;
            animation: gradientBG 10s ease infinite;
            position: relative;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
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
            z-index: 0;
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
        .reservation-container {
            position: relative;
            max-width: 500px;
            background-color: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 245, 224, 0.3);
            border-radius: 20px;
            backdrop-filter: blur(15px);
            padding: 40px;
            box-shadow: 0 0 20px rgba(6, 8, 52, 0.3);
            z-index: 1;
            margin: 20px auto;
        }
        h2 {
            font-size: 2rem;
            color: #fff5e0;
            text-align: center;
            margin-bottom: 30px;
            text-shadow: 0 2px 5px rgba(6, 8, 52, 0.4);
        }
        .success {
            color: #fff5e0;
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
            background: rgba(6, 8, 52, 0.2);
            padding: 10px;
            border-radius: 5px;
        }
        .error {
            color: #800020;
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
            background: rgba(255, 255, 255, 0.1);
            padding: 10px;
            border-radius: 5px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        .inputbox {
            position: relative;
            margin: 20px 0;
            border-bottom: 2px solid #fff5e0;
        }
        input {
            width: 100%;
            height: 50px;
            background: transparent;
            border: none;
            outline: none;
            font-size: 1rem;
            padding: 0 35px 0 5px;
            color: #fff;
            font-family: 'BodoniModa-Italic', sans-serif;
        }
        input[name="nom"],
        input[name="email"],
        input[name="telephone"],
        input[name="date"],
        input[name="heure"] {
            border-bottom: 2px solid #fff5e0;
        }
        input[name="nom"]:focus,
        input[name="nom"]:valid,
        input[name="email"]:focus,
        input[name="email"]:valid,
        input[name="telephone"]:focus,
        input[name="telephone"]:valid,
        input[name="date"]:focus,
        input[name="date"]:valid,
        input[name="heure"]:focus,
        input[name="heure"]:valid {
            border-bottom: 2px solid #fff5e0;
        }
        input[name="nom"] ~ label,
        input[name="email"] ~ label,
        input[name="telephone"] ~ label,
        input[name="date"] ~ label,
        input[name="heure"] ~ label {
            top: -5px;
            font-size: 0.8rem;
            color: #fff5e0;
            transition: none;
        }
        input[name="personnes"]:focus,
        input[name="personnes"]:valid {
            border-bottom: 2px solid #e6d8b3;
        }
        .inputbox ion-icon {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            color: #fff5e0;
            font-size: 1.2rem;
        }
        label {
            position: absolute;
            top: 50%;
            left: 5px;
            transform: translateY(-50%);
            color: #fff;
            font-size: 1rem;
            pointer-events: none;
            transition: all 0.3s ease;
        }
        input[name="personnes"]:focus ~ label,
        input[name="personnes"]:valid ~ label {
            top: -5px;
            font-size: 0.8rem;
            color: #fff5e0;
        }
        button {
            width: 100%;
            height: 45px;
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
            text-transform: uppercase;
            margin-top: 20px;
        }
        button:hover {
            background: linear-gradient(45deg, #1a2a5a, #060834);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(6, 8, 52, 0.5);
        }
        footer {
            width: 100%;
            text-align: center;
            padding: 20px;
            color: #fff5e0;
            position: relative;
            z-index: 1;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <?php include("header.php"); ?>

    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <div class="reservation-container">
        <h2>Réserver une Table</h2>
        
        <?php if (isset($message)) echo $message; ?>

        <form action="" method="POST">
            <div class="inputbox">
                <ion-icon name="person-outline"></ion-icon>
                <input type="text" name="nom" placeholder=" " required>
                <label>Nom complet</label>
            </div>
            <div class="inputbox">
                <ion-icon name="mail-outline"></ion-icon>
                <input type="email" name="email" placeholder=" " required>
                <label>Email</label>
            </div>
            <div class="inputbox">
                <ion-icon name="call-outline"></ion-icon>
                <input type="tel" name="telephone" placeholder=" " required>
                <label>Téléphone</label>
            </div>
            <div class="inputbox">
                <ion-icon name="calendar-outline"></ion-icon>
                <input type="date" name="date" placeholder=" " required>
                <label>Date</label>
            </div>
            <div class="inputbox">
                <ion-icon name="time-outline"></ion-icon>
                <input type="time" name="heure" placeholder=" " required>
                <label>Heure</label>
            </div>
            <div class="inputbox">
                <ion-icon name="people-outline"></ion-icon>
                <input type="number" name="personnes" min="1" placeholder=" " required>
                <label>Nombre de personnes</label>
            </div>
            <button type="submit">Réserver</button>
        </form>
    </div>

    <?php include("footer.php"); ?>
</body>
</html>