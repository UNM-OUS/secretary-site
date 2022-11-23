<h1>Add bio</h1>
<?php

use DigraphCMS\Content\Filestore;
use DigraphCMS\Content\FilestoreFile;
use DigraphCMS\Context;
use DigraphCMS\HTML\DIV;
use DigraphCMS\HTML\Forms\Field;
use DigraphCMS\HTML\Forms\FormWrapper;
use DigraphCMS\HTML\Forms\INPUT;
use DigraphCMS\HTML\Forms\UploadSingle;
use DigraphCMS\HTTP\RedirectException;
use DigraphCMS\Media\ImageFile;
use DigraphCMS\SafeContent\SafeBBCode;
use DigraphCMS\SafeContent\SafeBBCodeField;
use DigraphCMS\UI\Pagination\PaginatedSection;
use DigraphCMS\URL\URL;
use DigraphCMS_Plugins\unmous\election_bios\ElectionBio;
use DigraphCMS_Plugins\unmous\election_bios\ElectionBios;
use DigraphCMS_Plugins\unmous\election_bios\ElectionBioSelect;
use DigraphCMS_Plugins\unmous\ous_digraph_module\Forms\EmailOrNetIDInput;
use DigraphCMS_Plugins\unmous\ous_digraph_module\PersonInfo;

/** @var ElectionBio */
$page = Context::page();

// Input form for basic info about person
$form = new FormWrapper();

$firstName = (new Field('First name'))
    ->setRequired(true)
    ->addForm($form);

$lastName = (new Field('Last name'))
    ->setRequired(true)
    ->addForm($form);

$title = (new Field('Title'))
    ->setRequired(true)
    ->addForm($form);

$bio = (new SafeBBCodeField('Biography'))
    ->addForm($form);

$statement = (new SafeBBCodeField('Statement of interest'))
    ->addForm($form);

// load form defaults
if ($page) {
    $firstName->setDefault($page['firstname']);
    $lastName->setDefault($page['lastname']);
    $title->setDefault($page['title']);
    $bio->setDefault($page['bio']);
    $statement->setDefault($page['statement']);
}

// Display for picking images
$media_uuid = 'election-bio__' . $page['for'];
$portraitInput = (new INPUT())->setAttribute('type', 'hidden')->setDefault('none');
$imageInterface = (new Field('Portrait', $portraitInput))
    ->setRequired(true)
    ->addClass('card')
    ->addClass('navigation-frame')
    ->setID('bio-portrait-interface')
    ->setData('target', '_frame');
$form->addChild($imageInterface);

// display currently-chosen portrait if selected, or previously-chosen portrait if possible
if (Context::arg('portrait')) {
    $portrait = Filestore::get(Context::arg('portrait'));
} elseif ($page['portrait']) {
    $portrait = Filestore::get($page['portrait']);
} else {
    $portrait = null;
}
if ($portrait && $portrait->image()) {
    $imageInterface->addChild('<div>Selected portrait</div>');
    $image = $portrait->image()->fit(200, 200);
    $imageInterface->addChild(sprintf('<div><img src="%s" /></div>', $image->url()));
    $imageInterface->addChild(sprintf('<div><a href="%s">Pick or upload a different picture</a></div>', new URL('&portrait=none')));
    $portraitInput->setDefault($portrait->uuid());
} else $portrait = null;

// otherwise display a list of portraits for this person
if (!$portrait) {
    $imageInterface->addChild('<div>Select a previously-uploaded portrait</div>');
    $imageInterface->addChild(
        new PaginatedSection(
            Filestore::select()->where('parent', $media_uuid),
            function (FilestoreFile $file) {
                return sprintf(
                    '<a href="%s" data-target="bio-portrait-interface"><img src="%s"/></a>',
                    new URL('&portrait=' . $file->uuid()),
                    $file->image()->height(100)->url()
                );
            }
        )
    );
}

// Form/display for picking/uploading images
if (!$portrait) {
    $imageForm = new FormWrapper();
    $imageForm->button()->setText('Upload new portrait');
    $imageInterface->addChild($imageForm);
    $imageUpload = (new UploadSingle())
        ->setRequired(true)
        ->addValidator(function (UploadSingle $upload) {
            if (exif_imagetype($upload->value()['tmp_name']) === false) return 'File is not a supported image type';
            else return null;
        });
    $imageForm->addChild($imageUpload);
    if ($imageForm->ready()) {
        $filestoreFile = $imageUpload->filestore($media_uuid);
        throw new RedirectException(new URL('&portrait=' . $filestoreFile->uuid()));
    }
}

// handle/display main form
if ($form->ready()) {
    $page['firstname'] = strip_tags($firstName->value());
    $page['lastname'] = strip_tags($lastName->value());
    $page['title'] = strip_tags($title->value());
    $page['bio'] = $bio->value();
    $page['statement'] = $statement->value();
    if ($portraitInput->value() != 'none') $page['portrait'] = $portraitInput->value();
    $page->name(implode(' ', [$page['firstname'], $page['lastname']]));
    $page->update();
    throw new RedirectException($page->url());
}

$form->button()->setText('Save bio');
echo $form;
