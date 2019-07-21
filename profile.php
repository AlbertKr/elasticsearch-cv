<?php

require_once 'app/init.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $query = $es->search([
        'body' => [
            'query' => [
                'bool' => [
                    "should" => [
                        [
                            "match" => [
                                "_id" => $id
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
    <title>Recherche de CV</title>

    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <?php

    if (isset($results)) {
        foreach ($results as $r) {
            ?>

            <a href="#<?php echo $r['_id']; ?>" class="result-identity"><?php echo $r['_source']['name']; ?> <?php echo $r['_source']['firstname']; ?></a>
            <div>
                <p class="p_result">Diplômes</p>
                <div class="result-diplomas"><?php echo implode(", ", $r['_source']['diplomas']); ?></div>
            </div>
            <div>
                <p class="p_result">Expériences</p>
                <div class="result-experience"><?php echo implode(", ", $r['_source']['experience']); ?></div>
            </div>
            <div>
                <p class="p_result">Compétences</p>
                <div class="result-competence"><?php echo implode(", ", $r['_source']['competence']); ?></div>
            </div>
            <div>
                <p class="p_result">Hobbies</p>
                <div class="result-hobbies"><?php echo implode(", ", $r['_source']['hobbies']); ?></div>
            </div>
        <?php
        }
    }
    ?>
    <div id="div_header">
        <a href="index.php">
            <button> Rechercher un autre Profil </button>
        </a>
    </div>
</body>
<script type="text/javascript" src="./app/script.js"></script>

</html>