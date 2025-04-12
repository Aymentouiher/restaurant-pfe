<?php
include("cnx.php") ;
session_start();
$id = $_SESSION['id'];
//update 
if(isset($_POST['update'])){
  $nom_complet              = $_POST['nom_complet'];
  $telephone                = $_POST['telephone'];
  $email                    = $_POST['email'];

  //mdp
  $mdp_a                    =$_POST['mdp'];
  $nv_mdp                   =$_POST['nv_mdp'];
  $c_mdp                    =$_POST['c_mdp'] ;

  $mdp_a_c = sha1($mdp_a);
  $nv_mdp_c = sha1(nv_mdp);

  if(($mdp_a_c ==  $pwd_s ) &&($nv_mdp == $c_mdp) ){
    mysqli_query($cnx,"UPDATE `clients` 
                       SET `nom_complet`='$nom_complet',`Email`='$email',`telephone`='$telephone',`Mdp`='$mdp_a_c'
                       WHERE id='$id'");
  }else{
    mysqli_query($cnx,"UPDATE 'clients'
                        SET'nom_complet'='$nom_complet','email'='$email','telephone'='$telephone', WHERE id = '$id' ");

  } 
  header ("Location : profile.php");
}



    $sql   = mysqli_query($cnx,"SELECT * FROM clients WHERE id='$id'");
    $data  = mysqli_fetch_assoc($sql);


?>
<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head><script src="../assets/js/color-modes.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <title> Le gourmet</title> 

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/carousel/">
    <link  rel="Stylesheet" href="index2.css" >


  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

<link href="css/bootstrap.min.css" rel="stylesheet">
    
    <link href="css/carousel.css" rel="stylesheet">
    <style>
         body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        header {
            margin-bottom: 20px;
            background-color :  
        }

        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #343a40;
        }

        .form-label {
            font-weight: bold;
        }

        .form-text {
            color: #6c757d;
        }
                        
                button {
                position: relative;
                display: inline-block;
                cursor: pointer;
                outline: none;
                border: 0;
                vertical-align: middle;
                text-decoration: none;
                font-family: inherit;
                font-size: 15px;
                }

                button.learn-more {
                font-weight: 600;
                color: #382b22;
                text-transform: uppercase;
                padding: 1.25em 2em;
                background:rgb(61, 25, 224);
                border: 2px solid rgb(21, 14, 220);
                border-radius: 0.75em;
                -webkit-transform-style: preserve-3d;
                transform-style: preserve-3d;
                -webkit-transition: background 150ms cubic-bezier(0, 0, 0.58, 1), -webkit-transform 150ms cubic-bezier(0, 0, 0.58, 1);
                transition: transform 150ms cubic-bezier(0, 0, 0.58, 1), background 150ms cubic-bezier(0, 0, 0.58, 1), -webkit-transform 150ms cubic-bezier(0, 0, 0.58, 1);
                }

                button.learn-more::before {
                position: absolute;
                content: '';
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background:rgb(34, 30, 159);
                border-radius: inherit;
                -webkit-box-shadow: 0 0 0 2px #b18597, 0 0.625em 0 0 #ffe3e2;
                box-shadow: 0 0 0 2px #b18597, 0 0.625em 0 0 #ffe3e2;
                -webkit-transform: translate3d(0, 0.75em, -1em);
                transform: translate3d(0, 0.75em, -1em);
                transition: transform 150ms cubic-bezier(0, 0, 0.58, 1), box-shadow 150ms cubic-bezier(0, 0, 0.58, 1), -webkit-transform 150ms cubic-bezier(0, 0, 0.58, 1), -webkit-box-shadow 150ms cubic-bezier(0, 0, 0.58, 1);
                }

                button.learn-more:hover {
                background: #ffe9e9;
                -webkit-transform: translate(0, 0.25em);
                transform: translate(0, 0.25em);
                }

                button.learn-more:hover::before {
                -webkit-box-shadow: 0 0 0 2px #b18597, 0 0.5em 0 0 #ffe3e2;
                box-shadow: 0 0 0 2px #b18597, 0 0.5em 0 0 #ffe3e2;
                -webkit-transform: translate3d(0, 0.5em, -1em);
                transform: translate3d(0, 0.5em, -1em);
                }

                button.learn-more:active {
                background: #ffe9e9;
                -webkit-transform: translate(0em, 0.75em);
                transform: translate(0em, 0.75em);
                }

                button.learn-more:active::before {
                -webkit-box-shadow: 0 0 0 2px #b18597, 0 0 #ffe3e2;
                box-shadow: 0 0 0 2px #b18597, 0 0 #ffe3e2;
                -webkit-transform: translate3d(0, 0, -1em);
                transform: translate3d(0, 0, -1em);
                }
                /* From Uiverse.io by Maximinodotpy */ 
            /* From Uiverse.io by Praashoo7 */ 
                .input {
                border: none;
                outline: none;
                border-radius: 15px;
                padding: 1em;
                background-color: #ccc;
                box-shadow: inset 2px 5px 10px rgba(0,0,0,0.3);
                transition: 300ms ease-in-out;
                }

                .input:focus {
                background-color: white;
                transform: scale(1.05);
                box-shadow: 13px 13px 100px #969696,
                            -13px -13px 100px #ffffff;
                }
      
    
    </style>
   
  </head>
  <body>
    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
      <symbol id="check2" viewBox="0 0 16 16">
        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
      </symbol>
      <symbol id="circle-half" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
      </symbol>
      <symbol id="moon-stars-fill" viewBox="0 0 16 16">
        <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/>
        <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"/>
      </symbol>
      <symbol id="sun-fill" viewBox="0 0 16 16">
        <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
      </symbol>
    </svg>
     <?php
     include("header.php");
     ?>
     <div class="container">
     <form action="profile.php" method="POST">
         <h2>Modifier Votre Profil</h2>
         <input type="hidden" name="id" class="input" value="<?php echo $data['id']; ?>" required>
         <input type="text" name="nom_complet" class="input" value="<?php echo $data['nom_complet']; ?>" placeholder="Nom Complet" required>
         <hr>
         <input type="email" name="email" class="input" value="<?php echo $data['Email']; ?>" placeholder="Email" required>
         <hr>
         <input type="text" name="telephone" class="input" value="<?php echo $data['telephone']; ?>" placeholder="Téléphone" required>
         <hr>
         <input type="password" name="mdp_a" class="input" placeholder="Ancien mot de passe" required>
         <hr>
         <input type="password" name="nv_mdp" class="input" placeholder="Nouveau mot de passe" required>
         <hr>
         <input type="password" name="c_mdp" class="input" placeholder="Confirmer Nouveau mot de passe" required>
         <hr>
         <button class="learn-more" type="submit" name="update">Modifier</button>
     </form>
 </div>
            
         </form>
    </div>
    
 

<script src="js/bootstrap.bundle.min.js"></script>

    </body>
</html>
