<?php
require 'config.php';

$error = ""; // Variable pour afficher les erreurs
$success = ""; // Variable pour afficher les succès

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire et nettoyage
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Vérification que les champs ne sont pas vides
    if (empty($nom) || empty($prenom) || empty($username) || empty($password) || empty($confirm_password)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif (strlen($password) < 8) {
        $error = "Le mot de passe doit contenir au moins 8 caractères.";
    } elseif ($password !== $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        // Vérifier si l'utilisateur existe déjà
        $checkUser = $pdo->prepare("SELECT * FROM inscription WHERE username = ?");
        $checkUser->execute([$username]);

        if ($checkUser->rowCount() > 0) {
            $error = "Ce nom d'utilisateur est déjà pris.";
        } else {
            // Hachage du mot de passe
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insertion dans la base de données
            $requete = $pdo->prepare("INSERT INTO inscription (nom, prenom, username, password) VALUES (?, ?, ?, ?)");
            if ($requete->execute([$nom, $prenom, $username, $hashedPassword])) {
                $success = "Inscription réussie ! Redirection en cours...";
                header("Refresh: 2; url=login.php"); // Redirection après 2 secondes
            } else {
                $error = "Une erreur s'est produite lors de l'inscription.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h1 class="text-3xl font-bold text-center text-purple-700 mb-6">Inscription</h1>

            <?php if (!empty($error)): ?>
                <div class="mb-4 p-2 bg-red-100 text-red-700 border border-red-400 rounded">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="mb-4 p-2 bg-green-100 text-green-700 border border-green-400 rounded">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="mb-4">
                    <label for="nom" class="block text-gray-700 text-sm font-bold mb-2">Nom</label>
                    <input type="text" name="nom" id="nom" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>

                <div class="mb-4">
                    <label for="prenom" class="block text-gray-700 text-sm font-bold mb-2">Prénom</label>
                    <input type="text" name="prenom" id="prenom" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>

                <div class="mb-4">
                    <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Nom d'utilisateur</label>
                    <input type="text" name="username" id="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Mot de passe</label>
                    <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required minlength="8">
                </div>

                <div class="mb-6">
                    <label for="confirm_password" class="block text-gray-700 text-sm font-bold mb-2">Confirmez le mot de passe</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required minlength="8">
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-purple-700 hover:bg-purple-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        S'inscrire
                    </button>
                    <a href="login.php" class="inline-block align-baseline font-bold text-sm text-purple-700 hover:text-purple-800">
                        Avez-vous un compte ? Connectez-vous
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>