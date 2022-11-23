<h1>Election bio management</h1>
<?php

use DigraphCMS\UI\Format;
use DigraphCMS\UI\Pagination\ColumnDateFilteringHeader;
use DigraphCMS\UI\Pagination\ColumnStringFilteringHeader;
use DigraphCMS\UI\Pagination\ColumnUserFilteringHeader;
use DigraphCMS\UI\Pagination\PaginatedTable;
use DigraphCMS_Plugins\unmous\election_bios\ElectionBioList;
use DigraphCMS_Plugins\unmous\election_bios\ElectionBioListSelect;

echo new PaginatedTable(
    new ElectionBioListSelect,
    function (ElectionBioList $list): array {
        return [
            $list->url()->html(),
            $list->bios()->count(),
            Format::date($list->created()),
            $list->createdBy(),
            Format::date($list->updated()),
            $list->updatedBy()
        ];
    },
    [
        new ColumnStringFilteringHeader('Name', 'name'),
        'Bios',
        new ColumnDateFilteringHeader('Created', 'created'),
        new ColumnUserFilteringHeader('Created by', 'created_by'),
        new ColumnDateFilteringHeader('Updated', 'updated'),
        new ColumnUserFilteringHeader('Updated by', 'updated_by')
    ]
);
