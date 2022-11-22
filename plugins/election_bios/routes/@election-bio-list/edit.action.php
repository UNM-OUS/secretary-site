<h1>Edit election bio list</h1>
<?php

use DigraphCMS\Context;
use DigraphCMS\HTML\Forms\Field;
use DigraphCMS\HTML\Forms\FormWrapper;
use DigraphCMS\HTTP\RedirectException;
use DigraphCMS\SafeContent\SafeBBCodeField;
use DigraphCMS_Plugins\unmous\election_bios\ElectionBioList;

/** @var ElectionBioList */
$list = Context::page();

$form = new FormWrapper();
$form->button()->setText('Add election bio list');

$name = (new Field('Bio list name'))
    ->setDefault($list->name())
    ->setRequired(true)
    ->addForm($form);

$body = (new SafeBBCodeField('Extra info for visitors'))
    ->setDefault($list['body'])
    ->addForm($form);

if ($form->ready()) {
    $list->name($name->value());
    $list['body'] = $body->value();
    $list->update();
    throw new RedirectException($list->url());
}

echo $form;
