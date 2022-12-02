<h1>Shared permissions</h1>
<p>
    The group assignments made here apply across all OUS sites.
</p>
<?php

use DigraphCMS\Config;
use DigraphCMS\Datastore\DatastoreItem;
use DigraphCMS\HTML\Forms\Field;
use DigraphCMS\HTML\Forms\FormWrapper;
use DigraphCMS\HTML\Forms\SELECT;
use DigraphCMS\UI\CallbackLink;
use DigraphCMS\UI\Format;
use DigraphCMS\UI\Pagination\ColumnDateFilteringHeader;
use DigraphCMS\UI\Pagination\ColumnStringFilteringHeader;
use DigraphCMS\UI\Pagination\ColumnUserFilteringHeader;
use DigraphCMS\UI\Pagination\PaginatedTable;
use DigraphCMS_Plugins\unmous\ous_digraph_module\Forms\NetIDInput;
use DigraphCMS_Plugins\unmous\shared_permissions\SharedPermissions;

echo "<div id='shared-permissions-interface' class='navigation-frame navigation-frame--stateless' data-targe='shared-permissions-interface'>";

echo "<h2>Add a user to a group</h2>";
$form = new FormWrapper();
$netid = (new Field('NetID', new NetIDInput))
    ->setRequired(true)
    ->addForm($form);
$group = (new Field('Group', $select = new SELECT))
    ->setRequired(true)
    ->addForm($form);
$select->setOption(null, '-- select --');
foreach (Config::get('unm.shared_permissions.groups') as $key => $value) {
    $select->setOption($key, $value);
}
if ($form->ready()) {
    SharedPermissions::addPersonToGroup($netid->value(), $group->value());
}
echo $form;

echo "<div id='shared-permissions-existing-interface' class='navigation-frame navigation-frame--stateless' data-targe='shared-permissions-existing-interface'>";

echo "<h2>User groups</h2>";

$permissions = SharedPermissions::storage()->select()
    ->order(null)
    ->order('updated DESC');

echo new PaginatedTable(
    $permissions,
    function (DatastoreItem $person): array {
        return [
            $person->groupName(),
            $person->key(),
            Format::date($person->created()),
            $person->createdBy(),
            Format::date($person->updated()),
            $person->updatedBy(),
            (new CallbackLink([$person, 'delete']))
                ->addChild('delete')
                ->setData('target','shared-permissions-existing-interface'),
        ];
    },
    [
        new ColumnStringFilteringHeader('NetID', 'grp'),
        new ColumnStringFilteringHeader('Group', 'key'),
        new ColumnDateFilteringHeader('Created', 'created'),
        new ColumnUserFilteringHeader('Created by', 'created_by'),
        new ColumnDateFilteringHeader('Updated', 'updated'),
        new ColumnUserFilteringHeader('Updated by', 'updated_by'),
        ''
    ]
);

echo "</div>";

echo "</div>";
