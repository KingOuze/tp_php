<?php
include 'db.php';

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/


session_start();
if (!isset($_SESSION['admin_id'])) {
    // Rediriger vers la page de connexion si non connecté
    header('Location: login.php');
    exit();
}



$pdo = new PDO('mysql:host=localhost;dbname=tp_php', 'root', '');

// Définir les données des étudiants






// Vérifier si un bouton a été cliqué
if (isset($_POST['button'])) {
    $button_clicked = $_POST['button'];
    
    // Filtrer la liste des étudiants en fonction du bouton cliqué
  
    if ($button_clicked == 'button1') {
         $stmt = $pdo->query('SELECT * FROM etudiants WHERE archive = 0 AND niveau = "L1"');

         //recupérer le nombre d'étudiants admis
         $nbreAdmis =$pdo->query('SELECT COUNT(*) FROM etudiants WHERE archive = 0 AND niveau = "L1" AND admission ="admis"');
         $admi = $nbreAdmis->fetchColumn();
         
         //recupérer le nombre d'étudiants recalé
         $nbreRecale =$pdo->query('SELECT COUNT(*) FROM etudiants WHERE archive = 0 AND niveau = "L1" AND admission ="recale"');
         $recale = $nbreRecale->fetchColumn();
         $titre = "Etudiants en LICENCE 1";
    } 
    elseif ($button_clicked == 'button2') {
         $stmt = $pdo->query('SELECT * FROM etudiants WHERE archive = 0 AND niveau = "L2"');

          //recupérer le nombre d'étudiants admis
          $nbreAdmis =$pdo->query('SELECT COUNT(*) FROM etudiants WHERE archive = 0 AND niveau = "L2" AND admission ="admis"');
          $admi = $nbreAdmis->fetchColumn();
          
          //recupérer le nombre d'étudiants recalé
          $nbreRecale =$pdo->query('SELECT COUNT(*) FROM etudiants WHERE archive = 0 AND niveau = "L2" AND admission ="recale"');
          $recale = $nbreRecale->fetchColumn();
          $titre = "Etudiants en LICENCE 2";
    }
    elseif ($button_clicked == 'button3') {
         $stmt = $pdo->query('SELECT * FROM etudiants WHERE archive = 0 AND niveau = "L3"');

          //recupérer le nombre d'étudiants admis
          $nbreAdmis =$pdo->query('SELECT COUNT(*) FROM etudiants WHERE archive = 0 AND niveau = "L3" AND admission ="admis"');
          $admi = $nbreAdmis->fetchColumn();
          
          //recupérer le nombre d'étudiants recalé
          $nbreRecale =$pdo->query('SELECT COUNT(*) FROM etudiants WHERE archive = 0 AND niveau = "L3" AND admission ="recale"');
          $recale = $nbreRecale->fetchColumn();
          $titre = "Etudiants en LICENCE 3";
    }
    elseif ($button_clicked == 'button4') {
         $stmt = $pdo->query('SELECT * FROM etudiants WHERE archive = 0 AND niveau = "M1"');

          //recupérer le nombre d'étudiants admis
          $nbreAdmis =$pdo->query('SELECT COUNT(*) FROM etudiants WHERE archive = 0 AND niveau = "M1" AND admission ="admis"');
          $admi = $nbreAdmis->fetchColumn();
          
          //recupérer le nombre d'étudiants recalé
          $nbreRecale =$pdo->query('SELECT COUNT(*) FROM etudiants WHERE archive = 0 AND niveau = "M1" AND admission ="recale"');
          $recale = $nbreRecale->fetchColumn();
          $titre = "Etudiants en MASTER 1";
    }
    elseif ($button_clicked == 'button5') {
         $stmt = $pdo->query('SELECT * FROM etudiants WHERE archive = 0 AND niveau = "M2"');

          //recupérer le nombre d'étudiants admis
          $nbreAdmis =$pdo->query('SELECT COUNT(*) FROM etudiants WHERE archive = 0 AND niveau = "M2" AND admission ="admis"');
          $admi = $nbreAdmis->fetchColumn();
          
          //recupérer le nombre d'étudiants recalé
          $nbreRecale =$pdo->query('SELECT COUNT(*) FROM etudiants WHERE archive = 0 AND niveau = "M2" AND admission ="recale"');
          $recale = $nbreRecale->fetchColumn();
          $titre = "Etudiants en MASTER 2";
    }
} else {
    $stmt = $pdo->query('SELECT * FROM etudiants WHERE archive = 0 AND niveau = "L1"');

    //recupérer le nombre d'étudiants admis
    $nbreAdmis =$pdo->query('SELECT COUNT(*) FROM etudiants WHERE archive = 0 AND niveau = "L1" AND admission ="admis"');
    $admi = $nbreAdmis->fetchColumn();
    
    //recupérer le nombre d'étudiants recalé
    $nbreRecale =$pdo->query('SELECT COUNT(*) FROM etudiants WHERE archive = 0 AND niveau = "L1" AND admission ="recale"');
    $recale = $nbreRecale->fetchColumn();
    $titre = "Etudiants en LICENCE 1";

} 

//Sur la page de destination
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste d'étudiants</title>
    <link rel="stylesheet" href="../css/accueil.css">
</head>
<body>
    <?php include 'menu_admin.php'; ?>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="message"><?php echo htmlspecialchars($_SESSION['message']); ?></div>
            <?php unset($_SESSION['message']); // Supprimer le message après affichage ?>
        <?php endif; ?>
        <h2>Gérer les NOTES</h2>

        <!-- Overlay pour griser la page -->
        <div id="popup-overlay" class="overlay"></div>

           
            <?php if ($message): 
                    if($message != "")?>
                        <div id="success-popup" class="popup">
                            <span class="close" onclick="closePopup()">&times;</span>
                            <p><?php echo htmlspecialchars($message); ?></p>
                            <?php $message == ""; ?>
                        </div>
            <?php endif; ?>
        </div>
    
    <!-- Boutons pour filtrer la liste -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <button type="submit" name="button" value="button1">LICENCE 1</button>
        <button type="submit" name="button" value="button2">LICENCE 2</button>
        <button type="submit" name="button" value="button3">LICENCE 3</button>
        <button type="submit" name="button" value="button4">MASTER 1</button>
        <button type="submit" name="button" value="button5">MASTER 2</button>
    </form>
    
    <!-- Afficher la liste des étudiants filtrée -->
    <h3><?php echo $titre; ?></h3>
    <table>
        <thead>
            <tr>
                <th>Matricule</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Moyenne</th>
                <th>Admission</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC) ): ?>
                <tr>
                    <td><?php echo $row['matricule']; ?></td>
                    <td><?php echo $row['prenom']; ?></td>
                    <td><?php echo $row['nom']; ?></td>
                    <td><?php echo $row["moyenne"]; ?></td>
                    <?php if($row["admission"] === "admis"){ ?>
                        <td class="admis"><?php echo $row['admission']; ?></td>
                    <?php }elseif ($row['admission'] === "recale") { ?>
                        <td class="recale"><?php echo $row['admission']; ?></td>                   
                     <?php } else{?>
                        <td class="cour"><?php echo $row['admission']; ?></td>
                    <?php }?>
                    <?php if($row['moyenne'] == 0){ ?>
                        <td><a class="actions modify" href="ajout_note.php?id=<?php echo htmlspecialchars($row['id']); ?>">Ajouter une note</a></td>
                    <?php }else{ ?>
                        <td><a class="actions ajouter" href="modifie_note.php?id=<?php echo htmlspecialchars($row['id']); ?>">Modifier la Note</a></td>
                        <td><a class="actions ajouter" href="generate_bulletin.php?id=<?php echo htmlspecialchars($row['id']); ?>">bulletin</a></td>
                    <?php }?>
                     
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <h3>Nombres d'Admis : <?php echo $admi ; ?></h3>
    <h3>Nombres de Recalé : <?php  echo $recale; ?></h3>

    <div id="timerDisplay">Inactivité : <span id="timer"></span> secondes</div>

    <script src="../js/accueil.js"></script>

   
</body>
</html>

