<?php

function createIndex($indexName, $client)
    {
        $createIndexParams = [
            'index' => $indexName,
            'body' => [
                'settings' => [
                    'number_of_shards' => 1,
                    'number_of_replicas' => 0,
                    'analysis' => [
                        'filter' => [
                            'portuguese_stop' => [
                                'type' => 'stop',
                                'stopwords' => '_portuguese_'
                            ],
                            'my_ascii_folding' => [
                                'type' => 'asciifolding',
                                'preserve_original' => true
                            ],
                            'portuguese_stemmer' => [
                                'type' => 'stemmer',
                                'language' =>  'light_portuguese'
                            ]
                        ],
                        'analyzer' => [
                            'rebuilt_portuguese' => [
                                'tokenizer' => 'standard',
                                'filter' =>  [ 
                                    'lowercase', 
                                    'my_ascii_folding',
                                    'portuguese_stop',
                                    'portuguese_stemmer'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $responseCreateIndex = $client->indices()->create($createIndexParams);
    }

    ?>