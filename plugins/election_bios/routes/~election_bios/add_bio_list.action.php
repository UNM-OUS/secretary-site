<h1>Add election bio list</h1>
<?php

use DigraphCMS\HTML\Forms\Field;
use DigraphCMS\HTML\Forms\FormWrapper;
use DigraphCMS\HTTP\RedirectException;
use DigraphCMS\SafeContent\SafeBBCodeField;
use DigraphCMS_Plugins\unmous\election_bios\ElectionBioList;

$form = new FormWrapper();
$form->button()->setText('Add election bio list');

$name = (new Field('Bio list name'))
    ->setRequired(true)
    ->addForm($form);

$body = (new SafeBBCodeField('Extra info for visitors'))
    ->addForm($form);

if ($form->ready()) {
    $list = new ElectionBioList();
    $list->name($name->value());
    $list['body'] = $body->value();
    $list->insert();
    throw new RedirectException($list->url());
}

echo $form;
