<?php
session_start();

// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=tp_php', 'root', '');

$error = '';
$email = '';
$password = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if ($email && $password) {
        try {
            $stmt = $pdo->prepare('SELECT * FROM admins WHERE email = :email');
            $stmt->execute(['email' => $email]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin) {
                if (password_verify($password, $admin['password'])) {
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['role'] = $admin['role'];
                    header('Location: includes/accueil.php');

                     // Stocker le message de succès dans la session
                    $_SESSION['success_message'] = 'Vous êtes connecté avec succès.';
                    header('Location: includes/accueil.php'); // Redirection après connexion
                    exit();
                } else {
                    $error = 'Mot de passe incorrect.';
                }
            } else {
                $error = 'Aucun utilisateur trouvé avec cet email.';
            }
        } catch (PDOException $e) {
            $error = 'Erreur lors de la connexion : ' . htmlspecialchars($e->getMessage());
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
    <title>Connexion</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

   

    <div class="container">
        <h1>Connexion</h1>
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form action="" method="post">
            <label>Email:
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </label>
            <label>Mot de passe:
                <input type="password" name="password" id="password" required>
            </label>
            <input type="submit" value="Se Connecter" id="login-button">
        </form>
    </div>


    <script src="js/login.js"></script>
</body>
</html>
