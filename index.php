<?php
session_start();
?>

<!doctype html>
<html lang="fr" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Le Gourmet - Une expérience gastronomique française unique">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <title>Le Gourmet</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/carousel/">
    <link rel="stylesheet" href="index2.css">
    <link rel="icon" href="pictures/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/carousel.css" rel="stylesheet">

    <style>
        @font-face {
            font-family: "BodoniModa-Italic";
            src: url("fonts/BodoniModa-Italic-VariableFont_opsz,wght.ttf") format("truetype");
            font-weight: normal;
            font-style: italic;
        }

        body {
            font-family: "BodoniModa-Italic", serif;
            background-color: #f5f5f5;
        }

        .hero-image {
            width: 100%;
            height: 500px;
            object-fit: cover;
            position: relative;
        }

        #ps {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #800020;
            font-size: 36px;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-align: center;
        }

        .AA {
            font-family: "BodoniModa", serif;
            color: #333;
        }

        h2.AA {
            font-family: "BodoniModa-Italic", serif;
            color: #800020;
        }

        .col-lg-4 {
            margin-top: 20px;
        }

        .bd-placeholder-img.rounded-circle {
            width: 140px;
            height: 140px;
            object-fit: cover;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .bd-placeholder-img.rounded-circle:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .featurette-image {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 500px;
            height: 500px;
            object-fit: cover;
        }

        /* Style pour les modals */
        .modal-content {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background-color: #800020;
            color: white;
            border-bottom: none;
        }

        .modal-body {
            padding: 20px;
            font-family: "BodoniModa", serif;
            color: #333;
        }

        .modal-body img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 15px;
        }

        @media (max-width: 768px) {
            #ps {
                font-size: 24px;
            }
            .hero-image {
                height: 300px;
            }
            .featurette-image {
                width: 100%;
                height: auto;
            }
            .bd-placeholder-img.rounded-circle {
                width: 100px;
                height: 100px;
            }
            .modal-body img {
                width: 150px;
                height: 150px;
            }
        }
    </style>
</head>
<body>
    <?php include "header.php"; ?>

    <main>
        <div style="position: relative;">
            <img class="hero-image" src="pictures/img23.jpg" alt="Façade extérieure du restaurant Le Gourmet">
            <h1 id="ps">Bienvenue</h1>
        </div>

        <div class="container marketing">
            <div class="row">
                <div class="col-lg-4">
                    <img src="pictures/chef1.jpg" class="bd-placeholder-img rounded-circle" width="140" height="140" alt="Chef 1" data-bs-toggle="modal" data-bs-target="#chef1Modal">
                    <p class="AA">Maître des saveurs, il réinvente la tradition avec audace et passion.</p>
                </div>
                <div class="col-lg-4">
                    <img src="pictures/chef2.jpg" class="bd-placeholder-img rounded-circle" width="140" height="140" alt="Chef 2" data-bs-toggle="modal" data-bs-target="#chef2Modal">
                    <p class="AA">Artiste culinaire, elle sublime les produits simples en plats d’exception.</p>
                </div>
                <div class="col-lg-4">
                    <img src="pictures/chef3.jpg" class="bd-placeholder-img rounded-circle" width="140" height="140" alt="Chef 3" data-bs-toggle="modal" data-bs-target="#chef3Modal">
                    <p class="AA">Expert en gastronomie, il allie précision et créativité pour votre plaisir.</p>
                </div>
            </div>

            <!-- Modals pour les profils des chefs -->
            <!-- Chef 1 Modal -->
            <div class="modal fade" id="chef1Modal" tabindex="-1" aria-labelledby="chef1ModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="chef1ModalLabel">Chef Pierre Dubois</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="pictures/chef1.jpg" alt="Chef Pierre Dubois">
                            <p><strong>Spécialité :</strong> Cuisine française revisitée</p>
                            <p>Avec plus de 20 ans d’expérience, Pierre Dubois est un maître dans l’art de réinventer les classiques. Passionné par les produits du terroir, il apporte une touche d’audace à chaque plat, transformant les saveurs traditionnelles en expériences modernes et mémorables.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chef 2 Modal -->
            <div class="modal fade" id="chef2Modal" tabindex="-1" aria-labelledby="chef2ModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="chef2ModalLabel">Chef Élise Moreau</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="pictures/chef2.jpg" alt="Chef Élise Moreau">
                            <p><strong>Spécialité :</strong> Pâtisserie et plats végétariens</p>
                            <p>Élise Moreau est une artiste dans l’âme. Elle excelle à transformer des ingrédients simples en créations extraordinaires, avec une prédilection pour les desserts raffinés et les plats végétariens qui surprennent par leur équilibre et leur beauté.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chef 3 Modal -->
            <div class="modal fade" id="chef3Modal" tabindex="-1" aria-labelledby="chef3ModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="chef3ModalLabel">Chef Julien Lefèvre</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="pictures/chef3.jpg" alt="Chef Julien Lefèvre">
                            <p><strong>Spécialité :</strong> Cuisine fusion franco-méditerranéenne</p>
                            <p>Julien Lefèvre allie précision et créativité dans chacune de ses assiettes. Inspiré par les saveurs méditerranéennes, il fusionne les techniques françaises avec des influences du sud pour offrir des plats vibrants et uniques.</p>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="featurette-divider">

            <div class="row featurette">
                <div class="col-md-7">
                    <h2 class="AA">Notre Ambition</h2>
                    <p class="AA">À Le Gourmet, nous voulons révolutionner la cuisine française en alliant terroir et modernité. Nos plats, simples mais raffinés, rendent la gastronomie accessible dans une ambiance chaleureuse et conviviale.</p>
                </div>
                <div class="col-md-5">
                    <img src="pictures/rest.9.jpg" class="featurette-image img-fluid mx-auto" width="500" height="500" alt="Vue du rooftop Le Gourmet">
                </div>
            </div>

            <hr class="featurette-divider">

            <div class="row featurette">
                <div class="col-md-7 order-md-2">
                    <h2 class="AA">Que veut dire Le Gourmet ?</h2>
                    <p class="AA">Le Gourmet incarne l’élégance culinaire française : un hommage aux traditions, enrichi d’une touche créative. Chaque plat célèbre des saveurs raffinées pour un plaisir gustatif inoubliable.</p>
                </div>
                <div class="col-md-5 order-md-1">
                    <img src="pictures/rest.10.jpg" class="featurette-image img-fluid mx-auto" width="500" height="500" alt="Détail d’un plat raffiné">
                </div>
            </div>

            <hr class="featurette-divider">

            <div class="row featurette">
                <div class="col-md-7">
                    <h2 class="AA">Notre Vision</h2>
                    <p class="AA">Nous voyons la cuisine comme un art qui éveille les sens. Avec des ingrédients authentiques et un savoir-faire unique, nous créons des plats pour inspirer et rassembler autour d’un repas mémorable.</p>
                </div>
                <div class="col-md-5">
                    <img src="pictures/rest.11.jpg" class="featurette-image img-fluid mx-auto" width="500" height="500" alt="Présentation élégante d’un plat">
                </div>
            </div>

            <hr class="featurette-divider">
        </div>

        <?php include "footer.php"; ?>
    </main>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/color-modes.js"></script>
</body>
</html>