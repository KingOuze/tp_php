<?php
session_start(); // Démarrer la session

include 'function.php';
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=tp_php', 'root', '');

// Message de succès
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
unset($_SESSION['success_message']); // Effacer le message après l'avoir affiché

// Ajouter un nouvel administrateur
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_admin') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT); // Hash du mot de passe

    if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($password)) {
        // Insertion de l'administrateur dans la base de données
        $stmt = $pdo->prepare('INSERT INTO admins (nom, prenom, email, password) VALUES (:nom, :prenom, :email, :password)');
        $stmt->execute(['nom' => $nom, 'prenom' => $prenom, 'email' => $email, 'password' => $password]);

       
        // Message de succès
        $_SESSION['success_message'] = "Administrateur ajouté avec succès.";
        header('Location: admin.php'); // Redirection pour éviter la soumission du formulaire
        exit();
    } else {
        $_SESSION['error_message'] = 'Tous les champs doivent être remplis.';
        header('Location: admin.php');
        exit();
    }
}

// Récupérer les administrateurs existants
$admins = [];
try {
    $stmt = $pdo->query('SELECT * FROM admins');
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Gestion des erreurs de la requête
    $_SESSION['error_message'] = 'Erreur lors de la récupération des administrateurs: ' . $e->getMessage();
}

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
    <link rel="stylesheet" href="../css/admin.css">
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
        <section id="manage-admins">
            <h2>Gérer les Administrateurs</h2>

            <!-- Message d'erreur -->
            <?php if (!empty($_SESSION['error_message'])): ?>
                <div class="error-message"><?php echo htmlspecialchars($_SESSION['error_message']); ?></div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>
            <div id="popup-overlay" class="overlay"></div>

            
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


            <!-- Bouton pour afficher/masquer le formulaire -->
            <?php if($_SESSION['role'] == "admin") { ?>
                <a href="ajouter_admin.php"><button id="toggle-admin-form">Ajouter un Administrateur</button></a>
            <?php }?>

            <!-- Formulaire pour ajouter un nouvel administrateur -->
            <div id="add-admin-form" class="hidden">
                <h3>Ajouter un Administrateur</h3>
                <form method="POST" action="">
                    <input type="hidden" name="action" value="add_admin">
                    <label>Nom:
                        <input type="text" name="nom" required>
                    </label>
                    <label>Prénom:
                        <input type="text" name="prenom" required>
                    </label>
                    <label>Email:
                        <input type="email" name="email" required>
                    </label>
                    <label>Mot de passe:
                        <input type="password" name="password" required>
                    </label>
                    <input type="submit" value="Ajouter">
                </form>
            </div>

            <!-- Liste des administrateurs -->
            <div id="admin-list">
    <h3>Liste des Administrateurs</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($admins as $admin): ?>
            <tr>
                <td><?php echo htmlspecialchars($admin['id']); ?></td>
                <td><?php echo htmlspecialchars($admin['nom']); ?></td>
                <td><?php echo htmlspecialchars($admin['prenom']); ?></td>
                <td><?php echo htmlspecialchars($admin['email']); ?></td>
                <?php if($_SESSION['role'] == "admin") { ?>
                    <td>
                        <a class="actions modify" href="<?php echo generateUrl('modifier_admin', ['id' => $admin['id']]); ?>">Modifier</a>
                        <a class="actions delete" href="<?php echo generateUrl('supprimer_admin', ['id' => $admin['id']]); ?>">Supprimer</a>
                    </td>
                <?php }?>
                <?php if($_SESSION['role'] == "user") { ?>
                    <td>Non Authorisé</td>
                <?php }?>
                
                
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

        </section>
    </main><br><br><br><br><br>

    <div id="timerDisplay">Inactivité : <span id="timer"></span> secondes</div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Votre Entreprise</p>
    </footer>

    <script src="../js/admin.js"></script>
    </script>
</body>
</html>
