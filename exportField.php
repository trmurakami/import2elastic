<?php

$file = "export.tsv";
header('Content-type: text/tab-separated-values; charset=utf-8');
header("Content-Disposition: attachment; filename=$file");

// Set directory to ROOT
//chdir('../');
// Include essencial files
include 'inc/config.php';

//$query = "";

$params = [];
$params["index"] = $index;
$params["type"] = $type;
$params["size"] = 50;
$params["scroll"] = "30s";
$params["_source"] = ["_id", "ID_PRODUCAO_INTELECTUAL", "DS_PALAVRA_CHAVE"];
$params["body"] = $query;

$cursor = $client->search($params);
$total = $cursor["hits"]["total"]["value"];


$content[] = "_id\tID_PRODUCAO_INTELECTUAL\tDS_PALAVRA_CHAVE";

foreach ($cursor["hits"]["hits"] as $r) {
    unset($fields);

    foreach ($r as $r_field) {
        if (is_array($r_field)) {
            $fields[] = implode("|", $r_field);
        } else {
            $fields[] = $r_field;
        }        
    }   

    $content[] = implode("\t", $fields);
    unset($fields);


}


while (isset($cursor['hits']['hits']) && count($cursor['hits']['hits']) > 0) {
    $scroll_id = $cursor['_scroll_id'];
    $cursor = $client->scroll(
        [
        "scroll_id" => $scroll_id,
        "scroll" => "30s"
        ]
    );

    foreach ($cursor["hits"]["hits"] as $r) {
        unset($fields);

        foreach ($r as $r_field) {
            if (is_array($r_field)) {
                $fields[] = implode("|", $r_field);
            } else {
                $fields[] = $r_field;
            }        
        }

        $content[] = implode("\t", $fields);
        unset($fields);

    }
}
echo implode("\n", $content);


?>