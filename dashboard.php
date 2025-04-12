<?php
include('cnx.php');
session_start();

if (!isset($_SESSION['type']) || $_SESSION['type'] !== 'admin') {
    header("Location: signin.php");
    exit();
}

// Query to fetch clients
$sql = mysqli_query($cnx, "SELECT * FROM clients WHERE `type` = 'client' AND active = 1");
$count_clients = mysqli_num_rows($sql);

$reservations_sql = mysqli_query($cnx, "SELECT * FROM reservations");
$count_reservations = mysqli_num_rows($reservations_sql);

if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($cnx, $_GET['delete_id']);
    $delete_sql = mysqli_query($cnx, "DELETE FROM plats WHERE id = '$delete_id'");
    if ($delete_sql) {
        header("Location: dashboard.php?deleted=1");
        exit();
    } else {
        echo "<script>alert('Erreur lors de la suppression.');</script>";
    }
}

if (isset($_POST['modifier'])) {
    $id = mysqli_real_escape_string($cnx, $_POST['id']);
    $nom = mysqli_real_escape_string($cnx, $_POST['nom']);
    $description = mysqli_real_escape_string($cnx, $_POST['description']);
    $prix = mysqli_real_escape_string($cnx, $_POST['prix']);
    $imagePath = mysqli_real_escape_string($cnx, $_POST['old_image']);

    if (!empty($_FILES["image"]["name"])) {
        $targetDir = "uploads/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $imageName = time() . "_" . basename($_FILES["image"]["name"]);
        $imagePath = $targetDir . $imageName;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
            if (file_exists($_POST['old_image']) && $_POST['old_image'] !== '') {
                unlink($_POST['old_image']);
            }
        } else {
            echo "<script>alert('Erreur lors du téléchargement de l\'image.');</script>";
        }
    }

    $update_sql = mysqli_query($cnx, "UPDATE plats SET nom = '$nom', description = '$description', prix = '$prix', image = '$imagePath' WHERE id = '$id'");
    if ($update_sql) {
        header("Location: dashboard.php?updated=1");
        exit();
    } else {
        echo "<script>alert('Erreur lors de la mise à jour.');</script>";
    }
}

// Ajout d'un plat
if (isset($_POST['ajouter'])) {
    $nom = mysqli_real_escape_string($cnx, $_POST['nom']);
    $description = mysqli_real_escape_string($cnx, $_POST['description']);
    $prix = mysqli_real_escape_string($cnx, $_POST['prix']);
    $imagePath = "";

    if (!empty($_FILES["image"]["name"])) {
        $targetDir = "uploads/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $imageName = time() . "_" . basename($_FILES["image"]["name"]);
        $imagePath = $targetDir . $imageName;
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
            echo "<script>alert('Erreur lors du téléchargement de l\'image.');</script>";
        }
    }

    $sql = mysqli_query($cnx, "INSERT INTO plats (nom, description, prix, image) VALUES ('$nom', '$description', '$prix', '$imagePath')");
    if ($sql) {
        header("Location: dashboard.php?success=1");
        exit();
    } else {
        echo "<script>alert('Erreur lors de l\'ajout du plat.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - Restaurant</title>
    <link href="/PFE/css/bootstrap.min.css" rel="stylesheet">
    <link href="/PFE/css/dashboard.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.2.0/css/dataTables.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
      body {
                font-family: 'Bodoni Moda', serif !important;
                font-style: italic; /* Ajoutez ceci si vous voulez forcer l'italique */
            }
        .container-fluid {
            padding: 20px;
        }

        .plat-list-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
            margin-top: 20px;
        }

        .plat-item {
            display: flex;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding: 15px 0;
            transition: background-color 0.2s;
        }

        .plat-item:hover {
            background-color: #f8f9fa;
        }

        .plat-actions {
            flex: 0 0 150px;
            padding-right: 15px;
        }

        .plat-details {
            flex: 1;
            padding: 0 15px;
        }

        .plat-image {
            max-width: 150px;
            height: auto;
            border-radius: 5px;
            object-fit: cover;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .btn-add {
            margin-bottom: 20px;
        }

        h3 {
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            background: #fff;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }
        .sidebar .nav-link {
            padding: 12px 20px;
            color: #333;
            transition: all 0.2s;
            border-left: 4px solid transparent;
        }
        .sidebar .nav-link:hover {
            background: #f1f3f5;
            border-left-color: #007bff;
        }
        .sidebar .nav-link.active {
            border-left-color: #007bff;
            color: #fff;
            background: #007bff;
            font-weight: bold;
        }
        .sidebar .bi {
            font-size: 1.2rem;
        }
        @media (max-width: 767.98px) {
            .sidebar {
                position: static;
            }
        }
    </style>
</head>

<body>
    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
    </svg>

    <!-- Header -->
    <header>
        <?php include("header.php"); ?>
    </header>

    <br><br><br>

    <!-- Main Content -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="sidebar col-md-3 col-lg-2 p-0 bg-light">
                <div class="offcanvas-md offcanvas-end bg-light" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
                    <!-- Sidebar Header -->
                    <div class="offcanvas-header border-bottom border-secondary">
                        <h5 class="offcanvas-title fw-bold" id="sidebarMenuLabel">
                            <i class="bi bi-person-circle me-2"></i> Admin Panel
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>

                    <!-- Sidebar Body -->
                    <div class="offcanvas-body d-md-flex flex-column p-0 pt-3 overflow-y-auto">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2 <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>" href="dashboard.php">
                                    <i class="bi bi-house-fill"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2 <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="index.php">
                                    <i class="bi bi-file-earmark"></i> Accueil
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2 <?php echo basename($_SERVER['PHP_SELF']) == 'reservations.php' ? 'active' : ''; ?>" href="reservation.php">
                                    <i class="bi bi-calendar-check"></i> Réservations
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2 <?php echo basename($_SERVER['PHP_SELF']) == 'menu.php' ? 'active' : ''; ?>" href="menu.php">
                                    <i class="bi bi-menu-button-wide"></i> Menu
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2 <?php echo basename($_SERVER['PHP_SELF']) == 'galerie.php' ? 'active' : ''; ?>" href="galerie.php">
                                    <i class="bi bi-images"></i> Galerie
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2 <?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>" href="contact.php">
                                    <i class="bi bi-envelope"></i> Contact
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2 <?php echo basename($_SERVER['PHP_SELF']) == 'clients.php' ? 'active' : ''; ?>" href="clients.php">
                                    <i class="bi bi-people"></i> Clients
                                </a>
                            </li>
                        </ul>

                        <!-- Divider -->
                        <hr class="my-3 border-secondary">

                        <!-- Logout -->
                        <ul class="nav flex-column mb-auto">
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2" href="logout.php">
                                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Main Section -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>

                <!-- Cards -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                            <div class="card-body">
                                <svg class="bi"><use xlink:href="#people"/></svg>
                                <h5 class="card-title">Clients</h5>
                                <p class="card-text"><?php echo $count_clients; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                            <div class="card-body">
                                <svg class="bi"><use xlink:href="#calendar3"/></svg>
                                <h5 class="card-title">Reservations</h5>
                                <p class="card-text"><?php echo $count_reservations; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-info mb-3" style="max-width: 18rem;">
                            <div class="card-body">
                                <svg class="bi"><use xlink:href="#cart"/></svg>
                                <h5 class="card-title">Plats</h5>
                                <p class="card-text"><?php echo mysqli_num_rows(mysqli_query($cnx, "SELECT * FROM plats")); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Ajouter un plat
                </button>

                <div class="plat-list-container">
                    <h3>Liste des plats</h3>
                    <?php
                    $plats_query = mysqli_query($cnx, "SELECT * FROM plats ORDER BY id DESC");
                    if (mysqli_num_rows($plats_query) > 0) {
                        while ($plat = mysqli_fetch_assoc($plats_query)) {
                            ?>
                            <div class="plat-item">
                                <div class="plat-actions">
                                    <button class="btn btn-warning btn-sm mb-2" data-bs-toggle="modal" 
                                            data-bs-target="#editModal<?php echo $plat['id']; ?>">Modifier</button>
                                    <a href="dashboard.php?delete_id=<?php echo $plat['id']; ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Voulez-vous vraiment supprimer ce plat ?');">Supprimer</a>
                                </div>
                                <div class="plat-details">
                                    <h5><?php echo htmlspecialchars($plat['nom']); ?></h5>
                                    <p><?php echo htmlspecialchars($plat['description']); ?></p>
                                    <p><strong>Prix:</strong> <?php echo htmlspecialchars($plat['prix']); ?> €</p>
                                </div>
                                <?php if (!empty($plat['image'])): ?>
                                    <img src="<?php echo htmlspecialchars($plat['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($plat['nom']); ?>" 
                                         class="plat-image">
                                <?php endif; ?>
                            </div>

                            <!-- Modal pour modifier -->
                            <div class="modal fade" id="editModal<?php echo $plat['id']; ?>" tabindex="-1" 
                                 aria-labelledby="editModalLabel<?php echo $plat['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="editModalLabel<?php echo $plat['id']; ?>">
                                                Modifier le plat
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="dashboard.php" method="POST" enctype="multipart/form-data">
                                                <input type="hidden" name="id" value="<?php echo $plat['id']; ?>">
                                                <input type="hidden" name="old_image" value="<?php echo $plat['image']; ?>">
                                                <div class="form-group">
                                                    <label for="nom<?php echo $plat['id']; ?>">Nom du plat :</label>
                                                    <input type="text" name="nom" id="nom<?php echo $plat['id']; ?>" 
                                                           value="<?php echo htmlspecialchars($plat['nom']); ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description<?php echo $plat['id']; ?>">Description :</label>
                                                    <textarea name="description" id="description<?php echo $plat['id']; ?>">
                                                        <?php echo htmlspecialchars($plat['description']); ?>
                                                    </textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="prix<?php echo $plat['id']; ?>">Prix :</label>
                                                    <input type="number" name="prix" id="prix<?php echo $plat['id']; ?>" 
                                                           step="0.01" value="<?php echo htmlspecialchars($plat['prix']); ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="image<?php echo $plat['id']; ?>">Image :</label>
                                                    <input type="file" name="image" id="image<?php echo $plat['id']; ?>" 
                                                           accept="image/*">
                                                </div>
                                                <button type="submit" name="modifier" class="btn btn-primary">Mettre à jour</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<p class="text-muted">Aucun plat trouvé.</p>';
                    }
                    ?>
                </div>

                <!-- Modal pour ajouter -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter un Plat</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="dashboard.php" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="nom">Nom du plat :</label>
                                        <input type="text" name="nom" id="nom" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description :</label>
                                        <textarea name="description" id="description"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="prix">Prix :</label>
                                        <input type="number" name="prix" id="prix" step="0.01" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Image :</label>
                                        <input type="file" name="image" id="image" accept="image/*">
                                    </div>
                                    <button type="submit" name="ajouter" class="btn btn-primary">Ajouter</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Scripts -->
    <script src="/PFE/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js" integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.2.0/js/dataTables.min.js"></script>
    <script>
        // Notification alerts
        <?php if (isset($_GET['success'])) { ?>
            alert('Plat ajouté avec succès!');
        <?php } elseif (isset($_GET['updated'])) { ?>
            alert('Plat mis à jour avec succès!');
        <?php } elseif (isset($_GET['deleted'])) { ?>
            alert('Plat supprimé avec succès!');
        <?php } ?>
    </script>
</body>
</html>