<?php

namespace DigraphCMS_Plugins\unmous\election_bios;

use DigraphCMS\Plugins\AbstractPlugin;
use DigraphCMS\UI\UserMenu;
use DigraphCMS\URL\URL;
use DigraphCMS\Users\Permissions;

class ElectionBios extends AbstractPlugin
{
    public function onStaticUrlPermissions_election_bios(URL $url)
    {
        return Permissions::inMetaGroup('electionbios__edit');
    }

    public function onUserMenu_user(UserMenu $menu)
    {
        $menu->addURL(new URL('/election_bios/'));
    }
}
