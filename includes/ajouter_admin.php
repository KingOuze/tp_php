<?php
session_start(); // Démarrer la session
include '../db.php';


// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=tp_php', 'root', '');

// Connexion à MySQL pour gérer les utilisateurs
$pdo_mysql = new PDO('mysql:host=localhost', 'root', '');


// Récupérer tous les administrateurs
$stmt = $pdo->query('SELECT * FROM admins');
$admins = $stmt->fetchAll(PDO::FETCH_ASSOC);




if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_admin') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT); // Hash du mot de passe
    $role = trim($_POST['dropdown']);

    if (!empty($nom) && !empty($prenom) && !empty($email)) {
        // Vérifiez si l'email existe déjà
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM admins WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $count = $stmt->fetchColumn();


        if ($count > 0) {
            $error = 'Un admin avec cet email existe déjà.';
        } else {
                // Ajouter un message de succès dans la session
                 $_SESSION['message'] = 'Admin ajouté avec succès.';

            try {
                $stmt = $pdo->prepare('INSERT INTO admins (nom, prenom, email, password, role) VALUES (:nom, :prenom, :email, :password, :role)');
                $stmt->execute(['nom' => $nom, 'prenom' => $prenom, 'email' => $email, 'password' => $password, 'role'=> $role]);
                $message = "Ajout de l'Administrateur Réussi !!";
                header('Location: admin.php?message=' .urlencode($message)); // Redirection après ajout
                exit();
            } catch (PDOException $e) {
                echo 'Erreur lors de l\'ajout de l\'administrateur : ' . htmlspecialchars($e->getMessage());
            }
        }
    } else {
        $error = 'Tous les champs doivent être remplis.';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Admin</title>
    <link rel="stylesheet" href="../css/ajouter_etudiant.css">
</head>
<body>
    <div class="container">
        <h1>Ajouter un Admin</h1>
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="post">
            <label>Nom:
                <input type="text" name="nom" required>
            </label>
            <label>Prénom:
                <input type="text" name="prenom" required>
            </label>
            <label>Email:
                <input type="email" name="email" required>
            </label>
            <label>Password:
                <input type="password" name="password" required>
            </label>
            <label for="dropdown">Role :
            <select id="dropdown" name="dropdown">
                <option value="">Sélectionnez une option</option>
                <option value="user">USER</option>
                <option value="admin">ADMIN</option>
             </select>
            </label>
            <input type="submit" value="Ajouter">
            <input type="hidden" name="action" value="add_admin">
        </form>
        <a href="admin.php"><button id="retour">Annuler</button></a>
    </div>
</body>
</html>
