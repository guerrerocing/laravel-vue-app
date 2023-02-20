<?php

$cwd = __DIR__;

$filePath = $cwd.'/../../schema-directives.graphql';
$content = file_get_contents($filePath);

file_put_contents(
    $filePath,
    str_replace(
        'directive @namespace repeatable on FIELD_DEFINITION | OBJECT',
        'directive @namespace(field: String, paginate: String) repeatable on FIELD_DEFINITION | OBJECT',
        $content
    )
);

die(0);
