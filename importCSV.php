<?php

/* Config */

$index = "capesbtd";

/* Load libraries for PHP composer */ 
require (__DIR__.'/vendor/autoload.php'); 

$hosts=["localhost"];

/* Load Elasticsearch Client */ 
$client = \Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build(); 



while ($line = fgets(STDIN)) {

    $row = explode("\t", $line);
    $numberOfLines = count($row);
    if (!isset($rowLabel)) {
        $rowLabel = $row;
    }
    $doc = Record::Build($row, $rowLabel, $numberOfLines);

    $sha256 = hash('sha256', ''.str_shuffle($doc["doc"]["NM_PRODUCAO"]).'');

    $params = [];
    $params["index"] = $index;
    $params["id"] = $sha256;
    $params["body"] = $doc;
    $response = $client->update($params);
    print_r($response);

}

class Record
{
    public static function build($row, $rowLabel, $numberOfLines)
    {

        $i = 0;
        while ($i < $numberOfLines) {
            $doc["doc"][$rowLabel[$i]] = $row[$i];
            $i++;
        }
        $doc["doc_as_upsert"] = true;
        return $doc;

    }
}

?>


