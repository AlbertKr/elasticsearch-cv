<?php

require_once 'app/init.php';

if (!empty($_POST)) {
    if (isset($_POST['title'], $_POST['body'], $_POST['keywords'])) {
        $title = $_POST['title'];
        $body = $_POST['body'];
        $keywords = explode(',', $_POST['keywords']);

        $indexed = $es->index([
            'index' => 'articles',
            'type' => 'article',
            'body' => [
                'title' => $title,
                'body' => $body,
                'keywords' => $keywords
            ]
        ]);

        if ($indexed) {
            print_r($indexed);
        }
    }
}

?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Ajouter Doc</title>

    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <form action="add.php" method="post" autocomplete="off">
        <label>
            Titre
            <input type="text" name="title">
        </label>
        <label>
            Contenu
            <textarea name="body" row="8"></textarea>
        </label>
        <label>
            Keywords
            <input type="text" name="keywords" placeholder="comma, separate">
        </label>

        <input type="submit" value="Add">
    </form>
</body>

</html>