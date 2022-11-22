<?php

use DigraphCMS\Context;
use DigraphCMS\SafeContent\SafeBBCode;
use DigraphCMS\UI\Pagination\PaginatedTable;
use DigraphCMS_Plugins\unmous\election_bios\ElectionBio;
use DigraphCMS_Plugins\unmous\election_bios\ElectionBioList;

/** @var ElectionBioList */
$list = Context::page();

printf('<h1>%s</h1>', $list->name());

echo SafeBBCode::parse($list['body']);

$table = new PaginatedTable(
    $list->bios(),
    function (ElectionBio $bio): array {
        return [
            $bio->url()->name(),
            $bio['title']
        ];
    }
);
$table->paginator()->perPage(100);
echo $table;
