<?php

require_once 'app/init.php';

if (isset($_GET['q'])) {
    $q = $_GET['q'];

    $query = $es->search([
        'body' => [
            'query' => [
                'bool' => [
                    'should' => [
                        'match' => ['title' => $q],
                        'match' => ['body' => $q],
                        'match' => ['keywords' => $q]
                    ]
                ]
            ]
        ]
    ]);

    if ($query['hits']['total'] >= 1) {
        $results = $query['hits']['hits'];
    }
}
?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>ES Projet</title>

    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <form action="index.php" method="get" autocomplete="off">
        <label>
            Rechercher quelque chose
            <input type="text" name="q">
            <input type="submit" value="Rechercher">
        </label>
    </form>
    <?php

    if (isset($results)) {
        foreach ($results as $r) {
            ?>

            <div class="result">
                <a href="#<?php echo $r['_id']; ?>"><?php echo $r['_source']['title']; ?></a>
                <div class="result-keywords"><?php echo implode(',', $r['_source']['keywords']); ?></div>
            </div>

        <?php
        }
    }

    ?>
</body>

</html>