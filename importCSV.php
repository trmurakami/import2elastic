<?php

while ($line = fgets(STDIN)) {

    $row = explode("\t", $line);
    $numberOfLines = count($row);
    if (!isset($rowLabel)) {
        $rowLabel = $row;
    }
    $doc = Record::Build($row, $rowLabel, $numberOfLines);

    print_r($doc);

}

class Record
{
    public static function build($row, $rowLabel, $numberOfLines)
    {

        $i = 0;
        while ($i <= $numberOfLines) {
            $doc["doc"][$rowLabel[$i]] = $row[$i];
            $i++;
        }
        $doc["doc_as_upsert"] = true;
        return $doc;

    }
}

?>


