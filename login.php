<?php
session_start();

require "config.php";

$error = ""; // Initialisation de la variable pour afficher les erreurs


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération et validation des données du formulaire
    $username = trim($_POST['username']);
    $password = $_POST['password'];


    // Requête préparée pour éviter les injections SQL
    $requete=$pdo->prepare("SELECT * FROM `inscription` WHERE username = :username");

    // Exécution de la requête avec les paramètres
     $requete->execute(['username' => $username]);

    // Vérification si l'utilisateur existe
    if ($requete->rowCount() > 0) {
        $user = $requete->fetch(PDO::FETCH_ASSOC);

        // Vérification du mot de passe
        if (password_verify($password, $user['password'])) {
            $_SESSION['uid'] = $user['id']; // Stocker l'ID dans la session
            $_SESSION['role'] = $user['role'];
            $_SESSION['username'] = $user['username'];

                header('location: index.php');
                exit;
            }
            if ($user['role'] == 'user') {
                header('location: index.php');
                exit;
            } else {
                header('location: inscription.php');
                exit;
            }
           
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Nom d'utilisateur introuvable.";
    }

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSCRIPTION</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
    <h1 class="text-3xl font-bold underline  text-center">CONNEXION</h1>

    <form action="" method="post" class="max-w-md mx-auto mt-8 bg-white p-6 rounded shadow">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <div class="mb-4">
            <label for="username" class="block text-gray-700 text-sm font-bold mb-2">USERNAME</label>
            <input type="text" name="username" id="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">PASSWORD</label>
            <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>


        <div class="md:w-2/3 text-center"> 
            <input type="submit" value="connexion" class="shadow bg-purple-700 hover:bg-purple-700 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">
        </div>
        
        <div class="flex items-center justify-center space-x-7">
            <p>Pas encore de compte ? </p>
            <div class="justify">
            <a href="inscription.php"  class="inline-flex justify-center py-2 px-4 text-base font-medium text-white rounded-lg bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 dark:focus:ring-purple-900">INSCRIVEZ-VOUS</a>
            </div>
            
        </div>
       
    </form>
</body>
</html>