<?php
session_start(); // Démarrer la session

include 'function.php';
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['admin_id'])) {
    // Rediriger vers la page de connexion si non connecté
    header('Location: login.php');
    exit();
}

// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=tp_php', 'root', '');

// Requête pour obtenir les étudiants non archivés
$stmt_non_archive = $pdo->query('SELECT * FROM etudiants WHERE archive = 0');

// Requête pour obtenir les étudiants archivés
$stmt_archive = $pdo->query('SELECT * FROM etudiants WHERE archive = 1');

// Récupérer le message de succès de la session
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
unset($_SESSION['success_message']); // Effacer le message après l'avoir affiché


// Sur la page de destination
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Administration</title>
    <link rel="stylesheet" href="../css/accueil.css">
</head>
<body>
<?php 
     if ($_SESSION['role'] == 'admin') {
        include 'menu_admin.php';
     }elseif ($_SESSION['role'] == 'user') {
        include 'menu_user.php';
     }
        
    ?>

    <main>
        <!-- Section pour gérer les étudiants -->
        <section id="manage-students">
            <h2>Gérer les Étudiants</h2>
            <?php if($_SESSION['role'] == "admin") { ?>
                <a href="ajouter_etudiant.php"><button id="toggle-student-form">Ajouter un Étudiant</button></a>
            <?php }?>


            <?php if (isset($_SESSION['message'])): ?>
                <div class="message"><?php echo htmlspecialchars($_SESSION['message']); ?></div>
                <?php unset($_SESSION['message']); // Supprimer le message après affichage ?>
            <?php endif; ?>


            <!-- Overlay pour griser la page -->
            <div id="popup-overlay" class="overlay"></div>

             <!-- Popup message -->
                <?php if ($success_message): ?>
                    <div id="success-popup" class="popup">
                        <span class="close" onclick="closePopup()">&times;</span>
                        <p><?php echo htmlspecialchars($success_message); ?></p>
                    </div>
                <?php endif; ?>
                <?php if ($message): ?>
                    <div id="success-popup" class="popup">
                        <span class="close" onclick="closePopup()">&times;</span>
                        <p><?php echo htmlspecialchars($message); ?></p>
                    </div>
                <?php endif; ?>
            </div>




            <!-- Liens pour basculer entre les listes -->
            <h3>
               <a href="#" id="toggle-list">Étudiants Archivés / Étudiants Non Archivés</a>
               
            </h3>

            <!-- Liste des étudiants -->
            <div id="student-list">
                <!-- Tableau des étudiants non archivés -->
                <div id="non-archived-list">
                    <h3>Liste des Étudiants Non Archivés</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Matricule</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Date Naissance</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Niveau</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $stmt_non_archive->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['matricule']); ?></td>
                                <td><?php echo htmlspecialchars($row['nom']); ?></td>
                                <td><?php echo htmlspecialchars($row['prenom']); ?></td>
                                <td><?php echo htmlspecialchars($row['date_naiss']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['tel']); ?></td>
                                <td><?php echo htmlspecialchars($row['niveau']); ?></td>
                                <?php if($_SESSION['role'] == "admin") { ?>
                                    <td>
                                        <a class="actions modify" href="modifier_etudiant.php?id=<?php echo htmlspecialchars($row['id']); ?>">Modifier</a>
                                        <a class="actions delete" href="supprimer_etudiant.php?id=<?php echo htmlspecialchars($row['id']); ?>">Supprimer</a>
                                        <a class="actions archive" href="archiver_etudiant.php?id=<?php echo htmlspecialchars($row['id']); ?>">Archiver</a>
                                    </td>
                                <?php }?>
                                <?php if($_SESSION['role'] == "user") { ?>
                                    <td>Non Authorisé</td>
                             <?php }?>
                                
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Tableau des étudiants archivés -->
                <div id="archived-list" style="display: none;">
                    <h3>Liste des Étudiants Archivés</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Matricule</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Date Naissance</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Niveau</th>
                                <th>Date d'Archivage</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $stmt_archive->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['matricule']); ?></td>
                                <td><?php echo htmlspecialchars($row['nom']); ?></td>
                                <td><?php echo htmlspecialchars($row['prenom']); ?></td>
                                <td><?php echo htmlspecialchars($row['date_naiss']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['tel']); ?></td>
                                <td><?php echo htmlspecialchars($row['niveau']); ?></td>
                                <td><?php echo htmlspecialchars($row['date_archiv']); ?></td>
                                <?php if($_SESSION['role'] == "admin") { ?>
                                    <td>
                                    <a class="actions archive" href="desarchiver_etudiant.php?id=<?php echo htmlspecialchars($row['id']); ?>">Desarchiver</a>
                                </td>
                                <?php }?>
                                <?php if($_SESSION['role'] == "user") { ?>
                                    <td>Non Authorisé</td>
                                <?php }?>
                                
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main><br><br><br><br>

    <div id="timerDisplay">Inactivité : <span id="timer"></span> secondes</div>

 <?php include 'footer.php'; ?>
<script src="../js/accueil.js"></script>
</body>
</html>
