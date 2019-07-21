<?php

require_once 'app/init.php';

if (!empty($_POST)) {
    if (isset($_POST['name'], $_POST['firstname'], $_POST['diplomas'], $_POST['experience'], $_POST['competence'], $_POST['hobbies'])) {
        $name = $_POST['name'];
        $firstname = $_POST['firstname'];
        $diplomas = explode(';', $_POST['diplomas']);
        $experience = explode(';', $_POST['experience']);
        $competence = explode(';', $_POST['competence']);
        $hobbies = explode(';', $_POST['hobbies']);

        $indexed = $es->index([
            'index' => 'cvs',
            'type' => 'cv',
            'body' => [
                'name' => $name,
                'firstname' => $firstname,
                'diplomas' => $diplomas,
                'experience' => $experience,
                'competence' => $competence,
                'hobbies' => $hobbies
            ]
        ]);

        // if ($indexed) {
        //     print_r($indexed);
        // }
    }
}

?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Ajouter un CV</title>

    <link rel="stylesheet" href="css/add.css">
</head>

<body>
    <div id="div_header">
        <h1>Ajoutez un CV !</h1>
        <a href="index.php">
            <button> Accéder à la recherche de CV </button>
        </a>
    </div>

    <div id="div_global">
        <div id="div_form">
            <h2>Via le Formulaire </h2>
            <form action="add.php" method="post" autocomplete="off" class="form-add">
                <label>
                    <p>Nom : </p>
                    <input type="text" name="name">
                </label>
                <label>
                    <p>Prénom : </p>
                    <input type="text" name="firstname">
                </label>
                <label>
                    <p>Diplômes : </p>
                    <textarea name="diplomas" row="8" placeholder="Renseignez vos diplômes. (Séparées par des points virgules (;))"></textarea>
                </label>
                <label>
                    <p>Expériences : </p>
                    <textarea name="experience" row="8" placeholder="Décrivez vos différentes expériences. (Séparées par des points virgules (;))"></textarea>
                </label>
                <label>
                    <p>Compétences : </p>
                    <textarea name="competence" row="8" placeholder="Renseignez vos compétences sous forme de mots clés. (Séparées par des points virgules (;))"></textarea>
                </label>
                <label>
                    <p> Hobbies: </p>
                    <textarea name="hobbies" row="8" placeholder="Des hobbies en particulier ? Ajoutez les ici ! (Séparées par des points virgules (;))"></textarea>
                </label>
                <input type="submit" value="Soumettre">
            </form>
        </diV>

        <!-- <div id="div_file">
            <h2>Via un fichier PDF</h2>
            <form action="add.php" method="post" autocomplete="off" class="form-file">
                <label>
                    <p>Sélectionnez votre CV (Format PDF) : </p>
                    <input type="file" name="pdf_file">
                </label>
                <input type="submit" value="Envoyer !">
            </form>
        </diV> -->
    </diV>
</body>

</html>