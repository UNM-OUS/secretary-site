<?php

namespace DigraphCMS_Plugins\unmous\election_bios;

use DigraphCMS\Content\PageSelect;
use DigraphCMS\DB\DB;

/**
 * @method ElectionBio|null fetch()
 * @method ElectionBio[] fetchAll()
 */
class ElectionBioSelect extends PageSelect
{
    public function __construct()
    {
        parent::__construct(DB::query()->from('page'));
        $this->where('class', 'election-bio');
        $this->order('${data.lastname} ASC');
        $this->order('${data.firstname} ASC');
    }
}
