<?php
require 'config.php';

$error = ""; // Variable pour afficher les erreurs
$success = ""; // Variable pour afficher les succès

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire et nettoyage
    $titre = htmlspecialchars(trim($_POST['titre']));
    $contenu = htmlspecialchars(trim($_POST['contenu']));

    // Vérification que les champs ne sont pas vides
    if (empty($titre) || empty($contenu)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif (strlen($titre) < 5 || strlen($titre) > 255) {
        $error = "Le titre doit contenir entre 5 et 255 caractères.";
    } elseif (strlen($contenu) < 10) {
        $error = "Le contenu doit contenir au moins 10 caractères.";
    } else {
        // Insertion dans la base de données
        $requete = $pdo->prepare("INSERT INTO articles (titre, contenu) VALUES (?, ?)");
        if ($requete->execute([$titre, $contenu])) {
            $success = "Article publié avec succès ! Redirection en cours...";
            header("Refresh: 2; url=index.php"); // Redirection après 2 secondes
        } else {
            $error = "Une erreur s'est produite lors de la publication de l'article.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes articles</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Barre de navigation -->
    <nav class="bg-white border-gray-200 dark:bg-gray-900">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Flowbite</span>
            </a>
            <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                    <li>
                        <a href="#" class="block py-2 px-3 text-white bg-blue-700 rounded-sm md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500" aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">About</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Services</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Formulaire de publication -->
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold text-center text-purple-700 mb-6">Publier un article</h1>

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

        <form action="" method="post" class="bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="titre" class="block text-gray-700 text-sm font-bold mb-2">Titre</label>
                <input type="text" name="titre" id="titre" placeholder="Titre de l'article" value="<?= htmlspecialchars($_POST['titre'] ?? '') ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>

            <div class="mb-4">
                <label for="contenu" class="block text-gray-700 text-sm font-bold mb-2">Contenu</label>
                <textarea id="contenu" name="contenu" rows="8" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Écrivez votre article ici..." required><?= htmlspecialchars($_POST['contenu'] ?? '') ?></textarea>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-purple-700 hover:bg-purple-800 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Publier l'article
                </button>
            </div>
        </form>
    </div>
</body>
</html>