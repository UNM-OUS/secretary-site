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
            sprintf(
                '<a href="%s" style="display:block;"><strong>%s</strong><small><br>%s</small></a>',
                $bio->url(),
                $bio->name(),
                $bio->jobTitle()
            ),
            ($p = $bio->portrait())
                ? sprintf('<img src="%s" />', $p->crop(50, 50)->url())
                : ''
        ];
    }
);
$table->paginator()->perPage(100);
echo $table;
