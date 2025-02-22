<?php
session_start();

require "config.php";

$error = ""; // Initialisation de la variable pour afficher les erreurs

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération et validation des données du formulaire
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Veuillez remplir tous les champs.";
    } else {
        // Requête préparée pour éviter les injections SQL
        $requete = $pdo->prepare("SELECT * FROM `inscription` WHERE username = :username");
        $requete->execute(['username' => $username]);

        // Vérification si l'utilisateur existe
        if ($requete->rowCount() > 0) {
            $user = $requete->fetch(PDO::FETCH_ASSOC);

            // Vérification du mot de passe
            if (password_verify($password, $user['password'])) {
                $_SESSION['uid'] = $user['id']; // Stocker l'ID dans la session
                $_SESSION['role'] = $user['role'];
                $_SESSION['username'] = $user['username'];

                // Redirection en fonction du rôle
                if ($user['role'] == 'admin') {
                    header('location: admin.php');
                } else {
                    header('location: index.php');
                }
                exit;
            } else {
                $error = "Mot de passe incorrect.";
            }
        } else {
            $error = "Nom d'utilisateur introuvable.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONNEXION</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h1 class="text-3xl font-bold text-center text-purple-700 mb-6">CONNEXION</h1>

            <?php if ($error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 text-sm font-bold mb-2">USERNAME</label>
                    <input type="text" name="username" id="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">PASSWORD</label>
                    <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-purple-700 hover:bg-purple-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Connexion
                    </button>
                    <a href="inscription.php" class="inline-block align-baseline font-bold text-sm text-purple-700 hover:text-purple-800">
                        Pas encore de compte ? Inscrivez-vous
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>