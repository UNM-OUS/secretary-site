<?php

use DigraphCMS\Context;
use DigraphCMS_Plugins\unmous\shared_permissions\SharedPermissions;

$netid = strtolower(Context::arg('netid'));

if ($netid) $groups = SharedPermissions::groups($netid);
else $groups = [];

// correct names of standard groups for legacy systems
$groups = array_map(
    function(string $group) {
        if ($group == 'admins') return 'admin';
        elseif($group == 'editors') return 'editor';
        else return $group;
    },
    $groups
);

Context::response()->filename('groups.json');
echo json_encode($groups);
