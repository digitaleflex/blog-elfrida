<?php
require 'config.php';

$error = ""; // Variable pour afficher les erreurs

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération et nettoyage des données du formulaire
    $comment = htmlspecialchars(trim($_POST['comment']), ENT_QUOTES, 'UTF-8');

    // Vérification que le champ n'est pas vide
    if (empty($comment)) {
        $error = "Le champ commentaire est obligatoire.";
    } else {
        try {
            // Insertion dans la base de données avec les bons champs (structure mise à jour)
            $requete = $pdo->prepare("INSERT INTO commentaires (contenu, utilisateur_id, article_id) VALUES (?, ?, ?)");
            // Pour simplifier, on utilise des valeurs par défaut (à adapter selon votre système d'authentification)
            $utilisateur_id = 1; // À remplacer par l'ID réel de l'utilisateur connecté
            $article_id = 1;     // À remplacer par l'ID réel de l'article commenté
            if ($requete->execute([$comment, $utilisateur_id, $article_id])) {
                header("Location: index.php");
                exit;
            } else {
                $error = "Erreur lors de l'ajout du commentaire.";
            }
        } catch (PDOException $e) {
            $error = "Erreur de base de données : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLOG</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <!-- Barre de navigation -->
    <nav class="bg-white border-gray-200 dark:bg-gray-900">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Flowbite</span>
            </a>
            <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Ouvrir le menu principal</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                    <li><a href="#" class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500" aria-current="page">Accueil</a></li>
                    <li><a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">À propos</a></li>
                    <li><a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Services</a></li>
                    <li><a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Tarifs</a></li>
                    <li><a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Section d'accueil -->
    <section class="bg-center bg-no-repeat bg-gray-700 bg-blend-multiply">
        <div class="px-4 mx-auto max-w-screen-xl text-center py-24 lg:py-56">
            <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl">Bienvenue sur votre plateforme</h1>
            <p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl sm:px-16 lg:px-48">Connectez-vous pour en découvrir davantage.</p>
            <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
                <a href="login.php" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                    Connexion
                    <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                    </svg>
                </a>
                <a href="inscription.php" class="inline-flex justify-center hover:text-gray-900 items-center py-3 px-5 sm:ms-4 text-base font-medium text-center text-white rounded-lg border border-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">
                    Inscription
                </a>
            </div>
        </div>
    </section>

    <!-- Section des articles -->
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16">
            <?php if (!empty($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <!-- Article statique principal -->
            <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-8 md:p-12 mb-8">
                <a href="#" class="bg-blue-100 text-blue-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-blue-400 mb-2">Jour 1</a>
                <h1 class="text-gray-900 dark:text-white text-3xl md:text-5xl font-extrabold mb-2">Comment déployer rapidement un site statique</h1>
                <p class="text-lg font-normal text-gray-500 dark:text-gray-400 mb-6">Les sites statiques sont maintenant utilisés pour démarrer de nombreux sites web et deviennent la base de divers outils influençant les designers et développeurs.</p>
                <a href="#" class="comment-btn inline-flex justify-center items-center py-2.5 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                    Commenter
                </a>

                <!-- Affichage des commentaires -->
                <?php
                $requete = $pdo->query("SELECT contenu, date_creation FROM commentaires WHERE article_id = 1"); // À adapter selon l'article
                $commentaires = $requete->fetchAll(PDO::FETCH_ASSOC);

                if ($commentaires) {
                    echo '<div class="mt-6">';
                    echo '<ul class="space-y-4">';
                    foreach ($commentaires as $commentaire) {
                        echo '<li class="border-b border-gray-300 dark:border-gray-700 pb-4">';
                        echo '<p class="text-lg font-normal text-gray-700 dark:text-gray-300">' . htmlspecialchars($commentaire['contenu']) . '</p>';
                        echo '<p class="text-sm text-gray-500 dark:text-gray-400">' . $commentaire['date_creation'] . '</p>';
                        echo '</li>';
                    }
                    echo '</ul>';
                    echo '</div>';
                } else {
                    echo "<p class='text-center text-gray-500 text-lg mt-4'>Aucun commentaire pour cet article.</p>";
                }
                ?>
            </div>

            <!-- Articles dynamiques -->
            <div class="grid md:grid-cols-2 gap-8">
                <?php
                $requete = $pdo->query("SELECT * FROM articles LIMIT 2"); // Limite à 2 pour exemple
                $articles = $requete->fetchAll(PDO::FETCH_ASSOC);

                if ($articles) {
                    foreach ($articles as $article) {
                        echo '<div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-8 md:p-12">';
                        echo '<a href="#" class="bg-purple-100 text-purple-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-purple-400 mb-2">Article</a>';
                        echo '<h2 class="text-gray-900 dark:text-white text-3xl font-extrabold mb-2">' . htmlspecialchars($article['titre']) . '</h2>';
                        echo '<p class="text-lg font-normal text-gray-500 dark:text-gray-400 mb-4">' . htmlspecialchars($article['contenu']) . '</p>';
                        echo '<a href="#" class="comment-btn inline-flex justify-center items-center py-2.5 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900" data-article-id="' . $article['id'] . '">Commenter</a>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Boîte de commentaire -->
    <div id="commentBox" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-96">
            <h2 class="text-lg font-bold mb-2">Ajouter un commentaire</h2>
            <form method="POST" action="index.php">
                <input type="hidden" name="article_id" id="article_id">
                <textarea name="comment" class="w-full p-2 border rounded" placeholder="Écrivez votre commentaire ici..." required></textarea>
                <div class="flex justify-end mt-4">
                    <button type="button" id="closeCommentBox" class="px-4 py-2 bg-gray-500 text-white rounded mr-2">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Commenter</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Gestion de la boîte de commentaire
        const commentButtons = document.querySelectorAll(".comment-btn");
        const commentBox = document.getElementById("commentBox");
        const closeCommentBox = document.getElementById("closeCommentBox");
        const articleIdInput = document.getElementById("article_id");

        commentButtons.forEach(button => {
            button.addEventListener("click", (e) => {
                e.preventDefault();
                const articleId = button.getAttribute("data-article-id") || 1; // Par défaut article 1
                articleIdInput.value = articleId;
                commentBox.classList.remove("hidden");
            });
        });

        closeCommentBox.addEventListener("click", () => {
            commentBox.classList.add("hidden");
        });
    </script>
</body>
</html>