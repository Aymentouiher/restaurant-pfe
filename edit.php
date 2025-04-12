<?php
session_start();
include('cnx.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = mysqli_query($cnx, "SELECT * FROM clients WHERE id='$id'");
    $data = mysqli_fetch_assoc($sql);
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nom_complet = $_POST['nom_complet'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];

    $sql_update = mysqli_query($cnx, "UPDATE clients 
                                      SET nom_complet='$nom_complet', 
                                          email='$email', 
                                          telephone='$telephone' 
                                      WHERE id='$id'");

    if ($sql_update) {
        header("Location: edit.php?id=$id&success");
    } else {
        header("Location: edit.php?id=$id&error");
    }
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
    <title>Edit</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/carousel/">
    <link rel="stylesheet" href="index2.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/carousel.css" rel="stylesheet">
    <style>
            button {
            --color: #560bad;
            font-family: inherit;
            display: inline-block;
            width: 8em;
            height: 2.6em;
            line-height: 2.5em;
            margin: 20px;
            position: relative;
            cursor: pointer;
            overflow: hidden;
            border: 2px solid var(--color);
            transition: color 0.5s;
            z-index: 1;
            font-size: 17px;
            border-radius: 6px;
            font-weight: 500;
            color: var(--color);
            }

            button:before {
            content: "";
            position: absolute;
            z-index: -1;
            background: var(--color);
            height: 150px;
            width: 200px;
            border-radius: 50%;
            }

            button:hover {
            color: #fff;
            }

            button:before {
                top: 100%;
                left: 100%;
                transition: all 0.7s;
            }

            button:hover:before {
            top: -30px;
            left: -30px;
            }

            button:active:before {
            background: #3a0ca3;
            transition: background 0s;
            }
            .form-control {
            font-weight: 500;
            font-size: .8vw;
            color: #fff;
            background-color: rgb(28,28,30);
            box-shadow: 0 0 .4vw rgba(0,0,0,0.5), 0 0 0 .15vw transparent;
            border-radius: 0.4vw;
            border: none;
            outline: none;
            padding: 0.4vw;
            max-width: 190px;
            transition: .4s;
            }

            .form-control:hover {
            box-shadow: 0 0 0 .15vw rgba(135, 207, 235, 0.186);
            }

            .form-control:focus {
            box-shadow: 0 0 0 .15vw skyblue;
            }
            .form__group {
            position: relative;
            padding: 20px 0 0;
            width: 100%;
            max-width: 180px;
            }

            .form__field {
            font-family: inherit;
            width: 100%;
            border: none;
            border-bottom: 2px solid #9b9b9b;
            outline: 0;
            font-size: 17px;
            color: #000;
            padding: 7px 0;
            background: transparent;
            transition: border-color 0.2s;
            }

            .form__field::placeholder {
            color: transparent;
            }

            .form__field:placeholder-shown ~ .form__label {
            font-size: 17px;
            cursor: text;
            top: 20px;
            }

            .form__label {
            position: absolute;
            top: 0;
            display: block;
            transition: 0.2s;
            font-size: 17px;
            color: #9b9b9b;
            pointer-events: none;
            }

            .form__field:focus {
            padding-bottom: 6px;
            font-weight: 700;
            border-width: 3px;
            border-image: linear-gradient(to right, #116399, #38caef);
            border-image-slice: 1;
            }

            .form__field:focus ~ .form__label {
            position: absolute;
            top: 0;
            display: block;
            transition: 0.2s;
            font-size: 17px;
            color: #38caef;
            font-weight: 700;
            }

            .form__field:required, .form__field:invalid {
            box-shadow: none;
            }
                        
            .error {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
                Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
            width: 320px;
            padding: 12px;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: start;
            border-radius: 50px;
            background: -webkit-linear-gradient(to right, #f45c43, #eb3349);
            background: linear-gradient(to right, #f45c43, #eb3349);
            box-shadow: 0 0px 10px #de1c3280;
            }

            .error__icon {
            width: 20px;
            height: 20px;
            transform: translateY(-2px);
            margin-right: 8px;
            filter: drop-shadow(2px 1px 2px rgb(0 0 0 / 0.4));
            }

            .error__icon path {
            fill: #fff;
            }

            .error__title {
            font-weight: 500;
            font-size: 14px;
            color: #fff;
            }

            .error__close {
            width: 20px;
            height: 20px;
            cursor: pointer;
            margin-left: auto;
            filter: drop-shadow(2px 1px 2px rgb(0 0 0 / 0.4));
            }

            .error__close path {
            fill: #fff;
            }


     </style>
 </head>
  <body>
    <?php include("header.php"); ?>
    <div class="container">
      <br>
      <?php if (isset($_GET['success'])) { ?>
        <div class="error my-4">
          <div class="error__icon">
            <svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
              <path d="m13 13h-2v-6h2zm0 4h-2v-2h2zm-1-15c-1.3132..." fill="#393a37"></path>
            </svg>
          </div>
          <div class="error__title">Vous avez bien modifié vos informations !</div>
          <div class="error__close">
            <svg height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg">
              <path d="m15.8333 5.34166-1.175..." fill="#393a37"></path>
            </svg>
          </div>
        </div>
      <?php } elseif (isset($_GET['error'])) { ?>
        <div class="error my-4">
          <div class="error__icon">
            <svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
              <path d="m13 13h-2v-6h2zm0 4h-2v-2h2zm-1-15c-1.3132..." fill="#393a37"></path>
            </svg>
          </div>
          <div class="error__title">Une erreur s'est produite lors de la modification des informations !</div>
          <div class="error__close">
            <svg height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg">
              <path d="m15.8333 5.34166-1.175..." fill="#393a37"></path>
            </svg>
          </div>
        </div>
      <?php } ?>
      <h3 class="my-5">Modifier l'utilisateur:</h3>
      <form action="edit.php?id=<?php echo $data['id']; ?>" method="POST">
        <div class="form__group field">
          <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
        </div>
        <div class="form__group field">
          <input type="text" name="nom_complet" class="form__field" value="<?php echo $data['nom_complet']; ?>" placeholder="Nom complet">
          <label for="nom_complet" class="form__label">Nom complet</label>
        </div>
        <br>
        <div class="form__group field">
          <input type="email" name="email" class="form__field" value="<?php echo $data['email']; ?>" placeholder="Email">
          <label for="email" class="form__label">Email</label>
        </div>
        <br>
        <div class="form__group field">
          <input type="text" name="telephone" class="form__field" value="<?php echo $data['telephone']; ?>" placeholder="Téléphone">
          <label for="telephone" class="form__label">Téléphone</label>
        </div>
        <button type="submit" name="update">Modifier</button>
      </form>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>

</head>
  <body>
   