<?php

namespace DigraphCMS_Plugins\unmous\election_bios;

use DigraphCMS\Content\PageSelect;
use DigraphCMS\DB\DB;

/**
 * @method ElectionBioList|null fetch()
 * @method ElectionBioList[] fetchAll()
 */
class ElectionBioListSelect extends PageSelect
{
    public function __construct()
    {
        parent::__construct(DB::query()->from('page'));
        $this->where('class', ElectionBioList::class());
        $this->order('created DESC');
    }
}
