<?php

namespace DigraphCMS_Plugins\unmous\shared_permissions;

use DigraphCMS\Datastore\DatastoreItem;
use DigraphCMS\Datastore\DatastoreNamespace;
use DigraphCMS\Plugins\AbstractPlugin;
use DigraphCMS\UI\UserMenu;
use DigraphCMS\URL\URL;
use DigraphCMS\Users\Permissions;
use DigraphCMS\Users\User;

class SharedPermissions extends AbstractPlugin
{
    public static function storage(): DatastoreNamespace
    {
        return new DatastoreNamespace('ous_group_membership');
    }

    public static function addPersonToGroup(string $netid, string $group)
    {
        static::storage()->set($netid, $group, 'member');
    }

    public static function removePersonFromGroup(string $netid, string $group)
    {
        static::storage()->delete($netid, $group);
    }

    public static function allNetids(): array
    {
        static $cache;
        return $cache ?? $cache = array_map(
            function (DatastoreItem $person) {
                return $person->groupName();
            },
            static::storage()
                ->select()
                ->group('grp')
                ->fetchAll()
        );
    }

    public static function groups(string $netid): array
    {
        static $cache = [];
        return $cache[$netid] ?? $cache[$netid] = array_map(
            function (DatastoreItem $person) {
                return $person->key();
            },
            static::storage()
                ->select()
                ->where('grp', $netid)
                ->fetchAll()
        );
    }

    public function onStaticUrlPermissions_shared_permissions(URL $url, User $user): ?bool
    {
        if ($url->action() == 'known_netids.yaml') return true;
        else return Permissions::inGroup('admins');
    }

    public function onStaticUrlPermissions_groups(URL $url, User $user): ?bool
    {
        if ($url->action() == 'index.php') return true;
        else return null;
    }

    public function onUserMenu_user(UserMenu $menu)
    {
        $menu->addURL(new URL('/shared_permissions/'));
    }
}
