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
} else if (isset($_GET['diplomas_search'])) {
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
} else if (isset($_GET['competences_search'])) {
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
// print_r($results);die();
?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Recherche de CV</title>

    <link rel="stylesheet" href="css/index.css">
</head>

<body>

    <div id="div_header">
        <div>
            <p>Sélectionnez un type de recherche :</p>
            <div id="div_search_js">
                <div class="div_radio">
                    <input type="radio" id="global" onChange="change()" name="search" value="Global" checked>
                    <label for="global">Global</label>
                </div>

                <div class="div_radio">
                    <input type="radio" id="diplomas" onChange="change()" name="search" value="Diplômes">
                    <label for="diplomas">Diplômes</label>
                </div>

                <div class="div_radio">
                    <input type="radio" id="competences" onChange="change()" name="search" value="Compétences">
                    <label for="competences">Compétences</label>
                </div>
            </div>
        </div>
        <a href="add.php">
            <button> Ajouter un CV </button>
        </a>
    </div>
    <form id="form_global" action="index.php" method="get" autocomplete="off">
        <label>
            <p> Recherche Global : </p>
            <input type="text" name="global_search">
            <input type="submit" style="margin-left: 15px;" value="Rechercher">
        </label>
    </form>
    <form id="form_diplomas" action="index.php" method="get" autocomplete="off" style="display:none;">
        <label>
            <p> Recherche sur les diplômes : </p>
            <input type="text" name="diplomas_search">
            <input type="submit" style="margin-left: 15px;" value="Rechercher">
        </label>
    </form>
    <form id="form_competences" action="index.php" method="get" autocomplete="off" style="display:none;">
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
            <?php
            if (!isset($r['_source']['content'])) {
                ?>
                <div class="result">
                    <div class="div_result">
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
                    </div>
                    <form id="form_profile_redirect" action="profile.php" method="post" autocomplete="off">
                        <input type="hidden" name="id" value="<?php echo $r['_id']; ?>">
                        <input type="submit" id="profile_access" value="Accéder à sa fiche">
                    </form>
                </div>
            <?php
            } else {

                $pdf_decoded = base64_decode($r['_source']['content']);
                $pdf = fopen($r['_id'] . '.pdf', 'w');
                fwrite($pdf, $pdf_decoded);
                fclose($pdf);
                ?>

                <div class="result">
                    <div class="div_result">
                        <a href="#<?php echo $r['_id']; ?>" class="result-identity"><?php echo $r['_source']['name']; ?> <?php echo $r['_source']['firstname']; ?></a>
                        <div>
                            <p class="p_result">PDF</p>
                            <a href="<?php echo $r['_id']; ?>.pdf" target="_blank" class="result-hobbies"> Cliquez ici pour ouvrir le CV </a>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        <?php
        }
    }

    ?>
</body>
<script type="text/javascript" src="./app/script.js"></script>

</html>