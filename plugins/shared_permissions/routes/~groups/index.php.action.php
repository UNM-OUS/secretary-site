<?php

use DigraphCMS\Context;
use DigraphCMS_Plugins\unmous\shared_permissions\SharedPermissions;

$netid = strtolower(Context::arg('netid'));

if ($netid) $groups = SharedPermissions::groups($netid);
else $groups = [];

Context::response()->filename('groups.json');
echo json_encode($groups);
