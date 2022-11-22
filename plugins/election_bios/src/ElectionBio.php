<?php

namespace DigraphCMS_Plugins\unmous\election_bios;

use DigraphCMS\Content\AbstractPage;

class ElectionBio extends AbstractPage
{
    public function parentPage(): ?ElectionBioList
    {
        return parent::parentPage();
    }
}
