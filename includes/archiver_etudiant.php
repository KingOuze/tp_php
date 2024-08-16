<?php
    session_start(); // Démarrer la session
    include '../db.php';

    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['admin_id'])) {
        // Rediriger vers la page de connexion si non connecté
        header('Location: ../login.php');
        exit();
    }


    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $date = date("Y-m-d H:i:s");
        // Mettre à jour l'étudiant pour le marquer comme archivé
        $stmt = $pdo->prepare('UPDATE etudiants SET archive = 1, date_archiv = :date_archiv WHERE id = :id');
        $stmt->execute(['date_archiv' => $date, 'id' => $id]);

        // Rediriger vers la page d'accueil après l'archivage
        $message = "Etudiant Archivé avec succes !!";
        header('Location: accueil.php?message=' .urlencode($message));
        exit;
    } 
