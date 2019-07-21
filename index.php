<?php

require_once 'app/init.php';

if (isset($_GET['global_search'])) {
    $global_search = $_GET['global_search'];
    $query = $es->search([
        'body' => [
            'query' => [
                'bool' => [
                    "should" => [
                        [
                            "match" => [
                                "name" => $global_search
                            ]
                        ],
                        [
                            "match" => [
                                "firstname" => $global_search
                            ]
                        ],
                        [
                            "match" => [
                                "diplomas" => $global_search
                            ]
                        ],
                        [
                            "match" => [
                                "experience" => $global_search
                            ]
                        ],
                        [
                            "match" => [
                                "competence" => $global_search
                            ]
                        ],
                        [
                            "match" => [
                                "hobbies" => $global_search
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]);
} else if (isset($_GET['identity_search'])) {
    $identity_search = $_GET['identity_search'];
    $query = $es->search([
        'body' => [
            'query' => [
                'bool' => [
                    "should" => [
                        [
                            "match" => [
                                "name" => $identity_search
                            ]
                        ],
                        [
                            "match" => [
                                "firstname" => $identity_search
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]);
}else if (isset($_GET['diplomas_search'])) {
    $diplomas_search = $_GET['diplomas_search'];
    $query = $es->search([
        'body' => [
            'query' => [
                'bool' => [
                    "should" => [
                        [
                            "match" => [
                                "diplomas" => $diplomas_search
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]);
}else if (isset($_GET['competences_search'])) {
    $competences_search = $_GET['competences_search'];
    $query = $es->search([
        'body' => [
            'query' => [
                'bool' => [
                    "should" => [
                        [
                            "match" => [
                                "competence" => $competences_search
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]);
}

if (isset($query) && $query['hits']['total'] >= 1) {
    $results = $query['hits']['hits'];
}
?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>ES Projet</title>

    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <form action="index.php" method="get" autocomplete="off">
        <label>
            <p> Recherche Global : </p>
            <input type="text" name="global_search">
            <input type="submit" style="margin-left: 15px;" value="Rechercher">
        </label>
    </form>
    <form action="index.php" method="get" autocomplete="off">
        <label>
            <p> Recherche sur l'identité : </p>
            <input type="text" name="identity_search">
            <input type="submit" style="margin-left: 15px;" value="Rechercher">
        </label>
    </form>
    <form action="index.php" method="get" autocomplete="off">
        <label>
            <p> Recherche sur les diplômes : </p>
            <input type="text" name="diplomas_search">
            <input type="submit" style="margin-left: 15px;" value="Rechercher">
        </label>
    </form>
    <form action="index.php" method="get" autocomplete="off">
        <label>
            <p> Recherche sur les compétences : </p>
            <input type="text" name="competences_search">
            <input type="submit" style="margin-left: 15px;" value="Rechercher">
        </label>
    </form>
    <?php

    if (isset($results)) {
        foreach ($results as $r) {
            ?>

            <div class="result">
                <a href="#<?php echo $r['_id']; ?>"><?php echo $r['_source']['name']; ?> <?php echo $r['_source']['firstname']; ?></a>
                <div class="result-diplomas"><?php echo implode(',', $r['_source']['diplomas']); ?></div>
                <div class="result-experience"><?php echo implode(',', $r['_source']['experience']); ?></div>
                <div class="result-competence"><?php echo implode(',', $r['_source']['competence']); ?></div>
                <div class="result-hobbies"><?php echo implode(',', $r['_source']['hobbies']); ?></div>
            </div>
        <?php
        }
    }

    ?>
</body>

</html>