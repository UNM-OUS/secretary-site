<?php

namespace DigraphCMS_Plugins\unmous\election_bios;

use DigraphCMS\Content\AbstractPage;
use DigraphCMS\Content\Filestore;
use DigraphCMS\Media\ImageFile;
use DigraphCMS\SafeContent\SafeBBCode;

class ElectionBio extends AbstractPage
{
    const DEFAULT_SLUG = '[uuid]';

    public function parentPage(): ?ElectionBioList
    {
        return parent::parentPage() instanceof ElectionBioList ? parent::parentPage() : null;
    }

    public function portrait(): ?ImageFile
    {
        if ($this['portrait'] && $portrait = Filestore::get($this['portrait'])) {
            return $portrait->image();
        } else return null;
    }

    public function jobTitle(): string
    {
        return $this['title'];
    }

    public function statement(): string
    {
        return $this['statement'] ? SafeBBCode::parse($this['statement']) : '';
    }

    public function bio(): string
    {
        return $this['bio'] ? SafeBBCode::parse($this['bio']) : '';
    }
}
