<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    // Rediriger vers la page de connexion si non connecté
    header('Location: login.php');
    exit();
}

include '../db.php';

function calculerMoyenne($var1, $var2, $var3, $var4) {
    $somme = $var1 + $var2 + $var3 + $var4;
    $count = 4;
    $moyenne = $somme / $count;
    return $moyenne;
}
// Initialiser la variable $matricule
$id = intval($_GET['id']); // Convertir l'identifiant en entier pour des raisons de sécurité
$stmt = $pdo->query("SELECT * FROM etudiants WHERE id= '$id'");
$row = $stmt->fetch(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $math = trim($_POST['math']);
    $physic = trim($_POST['physic']);
    $info = trim($_POST['info']);
    $chimie = trim($_POST['chimie']);

    if (!empty($math) && !empty($physic) && !empty($info) && !empty($chimie)) {
        if($math >= 20 || $physic >= 20 || $info >= 20 || $chimie >= 20){
            $error = "La Moyenne est notée sur 20 !!";
        }else {
            $moyenne = calculerMoyenne($math, $physic, $info, $chimie);
            if ($moyenne >= 10) {
                $admis = "admis";
            }elseif ($moyenne < 10) {
                $admis = "recale";
            }
        
                try {
                    $stmt = $pdo->prepare('UPDATE etudiants SET math = :math, physic = :physic, informatique = :info, chimie = :chimie, moyenne = :moyenne, admission= :admis WHERE id = :id');
                    $stmt->execute(['math' => $math, 'physic' => $physic, 'info' => $info, 'chimie' => $chimie, 'moyenne' => $moyenne, 'admis' => $admis, 'id' => $id]);
                    $message = "Modification des Notes de l'Etudiant Reussi !!";
                    header('Location: note.php?message=' .urlencode($message)); // Redirection après mise à jour
                    exit();
                } catch (PDOException $e) {
                    
                    echo 'Erreur lors de l\'ajout de l\'étudiant : ' . htmlspecialchars($e->getMessage());
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
    <title>Modifier la Note</title>
    <link rel="stylesheet" href="../css/ajouter_etudiant.css">
</head>
<body>
    <div class="container">
        <h1>Modifier les Notes de l'Etudiants</h1>
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="post">
            <label>Math : /20 
            <input type='number' name='math' step="any" value="<?php echo $row["math"] ?>" required>
            </label>
            <label>Physic : /20
                <input type="number" name="physic" step="any" value="<?php echo $row["physic"] ?>" required>
            </label>
            <label>Informatique : /20
                <input type="number" name="info" step="any" value="<?php echo $row["informatique"] ?>" required>
            </label>
            <label>Chimie : /20
                <input type="number" name="chimie" step="any" value="<?php echo $row["chimie"] ?>" required>
            </label>
            
            <input type="submit" value="Ajouter">
            <input type="hidden" name="action" value="add_student">
        </form>
        <a href="note.php"><button id="retour">Annuler</button></a>
    </div>


</body>
</html>