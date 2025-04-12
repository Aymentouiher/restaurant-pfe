<?php
include('cnx.php');
session_start();

if (!isset($_SESSION['type']) || $_SESSION['type'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}

$sql = "SELECT * FROM clients WHERE type = 'client' AND active = 1";
$result = mysqli_query($cnx, $sql);
if (!$result) {
    die("Query failed: " . mysqli_error($cnx));
}
$count = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="fr" data-bs-theme="auto">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Clients - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.2.0/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital@1&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Bodoni Moda', serif;
            background: #f8f9fa;
        }
        .container-fluid {
            padding: 0;
        }
        .main-content {
            padding: 20px;
        }
        .table-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
        }
        .btn-custom {
            border-radius: 20px;
            padding: 8px 20px;
        }
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
    <?php include("header.php"); ?>

    <div class="container-fluid">
        <div class="row">
            <nav class="sidebar col-md-3 col-lg-2 p-0 bg-light">
                <div class="offcanvas-md offcanvas-end bg-light" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
                    <div class="offcanvas-header border-bottom border-secondary">
                        <h5 class="offcanvas-title fw-bold" id="sidebarMenuLabel">
                            <i class="bi bi-person-circle me-2"></i> Admin Panel
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body d-md-flex flex-column p-0 pt-3 overflow-y-auto">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2 <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>" href="dashboard.php">
                                    <i class="bi bi-house-fill"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2 <?php echo basename($_SERVER['PHP_SELF']) == 'reservations.php' ? 'active' : ''; ?>" href="reservations.php">
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
                        </ul>
                        <hr class="my-3 border-secondary">
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

            <main class="col-md-9 ms-sm-auto col-lg-10 main-content">
                <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Gestion des Clients</h1>
                </div>

                <div class="table-container">
                    <table id="liste_clients" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Nom Complet</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($data = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($data['id']); ?></td>
                                    <td><?php echo htmlspecialchars($data['nom_complet']); ?></td>
                                    <td><?php echo htmlspecialchars($data['Email']); ?></td>
                                    <td><?php echo htmlspecialchars($data['telephone']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.0/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.0/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#liste_clients').DataTable({
                responsive: true,
                language: {
                    "decimal": ",",
                    "thousands": " ",
                    "info": "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
                    "infoEmpty": "Affichage de 0 à 0 sur 0 entrées",
                    "infoFiltered": "(filtré de _MAX_ entrées au total)",
                    "lengthMenu": "Afficher _MENU_ entrées",
                    "search": "Rechercher :",
                    "zeroRecords": "Aucune entrée correspondante trouvée",
                    "emptyTable": "Aucune donnée disponible dans le tableau",
                    "paginate": {
                        "first": "Premier",
                        "last": "Dernier",
                        "next": "Suivant",
                        "previous": "Précédent"
                    }
                }
            });
        });
    </script>
</body>
</html>