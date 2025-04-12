<?php
$host = "localhost";
$dbname = "gourmet"; 
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
 }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    if (!empty($name) && !empty($email) && !empty($message)) {
        try {
            $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (:name, :email, :message)");
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":message", $message);
            $stmt->execute();
            $success = "Message sent successfully!";
        } catch (PDOException $e) {
            $error = "Error saving message: " . $e->getMessage();
        }
    } else {
        $error = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le Gourmet - Contact</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/dashboard/">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'BodoniModa-Italic' !important;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
            color: #333;
        }
        .contact {
            text-align: center;
            padding: 50px 20px;
        }
        .contact h2 {
            color: #060834;
            margin-bottom: 20px;
            font-size: 28px;
        }
        form {
            max-width: 500px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        form input, form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            position: relative;
            border: none;
            background: transparent;
            padding: 0;
            cursor: pointer;
            outline-offset: 4px;
            transition: filter 250ms;
            user-select: none;
            touch-action: manipulation;
        }
        .shadow {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 12px;
            background: rgba(6, 8, 52, 0.25);
            will-change: transform;
            transform: translateY(2px);
            transition: transform 600ms cubic-bezier(.3, .7, .4, 1);
        }
        .edge {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 12px;
            background: #060834;
        }
        .front {
            display: block;
            position: relative;
            padding: 12px 27px;
            border-radius: 12px;
            font-size: 1.1rem;
            color: white;
            background: #060834;
            will-change: transform;
            transform: translateY(-4px);
            transition: transform 600ms cubic-bezier(.3, .7, .4, 1);
        }
        button:hover {
            filter: brightness(110%);
        }
        button:hover .front {
            transform: translateY(-6px);
            transition: transform 250ms cubic-bezier(.3, .7, .4, 1.5);
        }
        button:active .front {
            transform: translateY(-2px);
            transition: transform 34ms;
        }
        button:hover .shadow {
            transform: translateY(4px);
            transition: transform 250ms cubic-bezier(.3, .7, .4, 1.5);
        }
        button:active .shadow {
            transform: translateY(1px);
            transition: transform 34ms;
        }
        button:focus:not(:focus-visible) {
            outline: none;
        }
        .success, .error {
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        @media (max-width: 600px) {
            nav ul li {
                display: block;
                margin: 10px 0;
            }
            form {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <?php include "header.php"; ?>

    <section class="contact">
        <br><br><br>
        <h2>Contact Us</h2>
        <?php
        if (isset($success)) {
            echo "<div class='success'>$success</div>";
        }
        if (isset($error)) {
            echo "<div class='error'>$error</div>";
        }
        ?>
        <form id="contactForm" method="post" action="contact.php">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <textarea name="message" placeholder="Your Message" required></textarea>
            <button type="submit">
                <span class="shadow"></span>
                <span class="edge"></span>
                <span class="front text">Send message</span>
            </button>
        </form>
    </section>

    <?php include "footer.php"; ?>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>