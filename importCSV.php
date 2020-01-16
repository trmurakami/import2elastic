<?php

if (isset($_FILES['file'])) {

    $fh = fopen($_FILES['file']['tmp_name'], 'r+');
    $row = fgetcsv($fh, 108192, ",");

    $numberOfLines = count($row);

    foreach ($row as $key => $value) {
        $rowNum[$key] = $value;                        
    }


    while (($row = fgetcsv($fh, 108192, ",")) !== false) {
        $doc = Record::Build($row, $rowNum);
        print_r($doc);
        
        //$sha256 = hash('sha256', ''.$doc["doc"]["source_id"].'');
        //if (!is_null($sha256)) {
            //$resultElastic = Elasticsearch::update($sha256, $doc);
        //}        
        //echo "<br/><br/><br/>";
        //flush();        

    }
    fclose($row);
}

class Record
{
    public static function build($row, $rowNum, $tag = "")
    {

        $i = 0;
        while ($i <= $numberOfLines) {
            $doc["doc"][$rowNum[$i]] = $row[$rowNum[$i]];
            $i++;
        }
        $doc["doc_as_upsert"] = true;
        return $doc;

    }
}

?>


