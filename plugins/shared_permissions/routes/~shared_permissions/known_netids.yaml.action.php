<?php

use DigraphCMS\Context;
use DigraphCMS_Plugins\unmous\ous_digraph_module\PersonInfo;
use DigraphCMS_Plugins\unmous\shared_permissions\SharedPermissions;

$known_netids = [];

foreach (SharedPermissions::allNetids() as $netid) {
    $known_netids[$netid] = [
        'groups' => SharedPermissions::groups($netid)
    ];
    if ($name = PersonInfo::getFullNameFor($netid)) {
        $known_netids[$netid]['name'] = $name;
    }
}

ksort($known_netids);

Context::response()->filename('known_netids.yaml');
Context::response()->mime('text/plain');
echo '# ' . time() . PHP_EOL;
echo spyc_dump($known_netids);
