<?php

namespace DigraphCMS_Plugins\unmous\election_bios;

use DigraphCMS\Content\AbstractPage;

class ElectionBioList extends AbstractPage
{
    const DEFAULT_SLUG = '/election_bios/[uuid]';

    public function bios(): ElectionBioSelect
    {
        return (new ElectionBioSelect())
            ->leftJoin('page_link on page_link.end_page = page.uuid')
            ->select('page.*')
            ->where('page_link.start_page', $this->uuid());
    }
}
