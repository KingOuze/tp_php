<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

// Connexion à la base de données
include 'bd.php';


$pdo = new PDO('mysql:host=localhost;dbname=tp_php', 'root', '');


// Assurez-vous que l'ID de l'étudiant est passé en paramètre GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID de l\'étudiant manquant.');
}

$etudiant_id = intval($_GET['id']); // Sécuriser l'ID

try {
    // Requête pour récupérer les informations de l'étudiant
    $stmt = $pdo->prepare("SELECT  e.nom, e.prenom, e.date_naiss, e.niveau, e.matricule, e.math, e.physic, e.informatique, e.chimie,moyenne,
            e.admission
        FROM etudiants e
        WHERE e.id = :id
    ");
    $stmt->execute(['id' => $etudiant_id]);

    $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$etudiant) {
        die('Étudiant non trouvé.');
    }

} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}

// Variables pour les notes
$notes = [
    'note1' => $etudiant['math'],
    'note2' => $etudiant['physic'],
    'note3' => $etudiant['informatique'],
    'note4' => $etudiant['chimie']
];

$total_notes = $etudiant['math'] + $etudiant['physic'] + $etudiant['informatique'] + $etudiant['chimie'];



?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin de Notes</title>
    <link rel="stylesheet" href="../css/bulletin.css">
    <style>
        .custom-download-link {
        position: relative;
        bottom: 200px;
        left: 280px;
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        color: #ffffff; /* Couleur du texte */
        background-color: #007bff; /* Couleur de fond */
        text-decoration: none; /* Supprimer le soulignement */
        border-radius: 5px; /* Coins arrondis */
        border: 2px solid transparent; /* Bordure initialement transparente */
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .custom-download-link:hover {
        background-color: #0056b3; /* Changement de couleur de fond au survol */
        border-color: #0056b3; /* Bordure colorée au survol */
        text-decoration: underline; /* Ajouter un soulignement au survol */
    }
    </style>
</head>
<body>
    <div class="bulletin-container">
        <header class="header">
            <img src="../img/1.webp" alt="Logo de l'École" style="width: 150px; height: auto;">
            <h1>BULLETIN DE NOTES</h1>
            <p>Année Scolaire : 2024</p>
            <button class="custom-download-link" onclick="window.print()">Imprimer le bulletin</button>
        </header>
        <section class="student-info">
            <h2>Informations de l'Étudiant</h2>
            <p><strong>Matricule :</strong> <?php echo htmlspecialchars($etudiant['matricule']); ?></p>
            <p><strong>Prenom :</strong> <?php echo htmlspecialchars($etudiant['nom']); ?></p>
            <p><strong>Nom :</strong> <?php echo htmlspecialchars($etudiant['prenom']); ?></p>
            <p><strong>Date de Naissance :</strong> <?php echo htmlspecialchars($etudiant['date_naiss']); ?></p>
            <p><strong>Classe :</strong> <?php echo htmlspecialchars($etudiant['niveau']); ?></p>
        </section>
        <section class="grades">
            <h2>Notes</h2>
            <table class="grades-table">
                <thead>
                    <tr>
                        <th>Matière</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Mathematique</td>
                        <td><?php echo htmlspecialchars($notes['note1']); ?> / 20</td>
                    </tr>
                    <tr>
                        <td>Physique</td>
                        <td><?php echo htmlspecialchars($notes['note2']); ?> / 20</td>
                    </tr>
                    <tr>
                        <td>informatique</td>
                        <td><?php echo htmlspecialchars($notes['note3']); ?> / 20</td>
                    </tr>
                    <tr>
                        <td>Chimie</td>
                        <td><?php echo htmlspecialchars($notes['note4']); ?> / 20</td>
                    </tr>
                </tbody>
            </table>
            <p><strong>Total des Notes :</strong> <?php echo htmlspecialchars($total_notes); ?> / 80</p>
            <p><strong>Moyenne :</strong> <?php echo htmlspecialchars($etudiant['moyenne']); ?> / 20</p>
            <p><strong>Statut :</strong> <?php echo htmlspecialchars($etudiant['admission']); ?></p>
        </section>
        <section class="comments">
            <h2>Commentaires du Professeur</h2>
            <p>Jean a montré une bonne compréhension des concepts, avec une progression notable en biologie. Il devrait continuer à travailler sur ses compétences en physique pour améliorer ses résultats.</p>
        </section>
        <footer class="footer">
            <p>SIMPLON - 2024</p>
        </footer>
        <div class="btn-return">
            <button class="btn-stylized2" onclick="window.history.back();">Retour</button>
        </div>
    </div>
</body>
</html>
