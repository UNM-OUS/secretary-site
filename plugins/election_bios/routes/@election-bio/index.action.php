<?php

use DigraphCMS\Context;
use DigraphCMS\HTML\ResponsivePicture;
use DigraphCMS\UI\Notifications;
use DigraphCMS_Plugins\unmous\election_bios\ElectionBio;

/** @var ElectionBio */
$bio = Context::page();

printf('<div></div><h1>%s</h1>', $bio->name());
printf('<div><strong>%s</strong></div>', $bio->jobTitle());

if ($portrait = $bio->portrait()) {
    $picture = new ResponsivePicture($portrait, $bio->name());
    $picture->setExpectedWidth(50);
    printf(
        '<figure class="figure--floated">%s</figure>',
        $picture
    );
}

if ($bio->bio()) {
    echo '<h2>Biography</h2>';
    echo $bio->bio();
}

if ($bio->statement()) {
    echo '<h2>Statement of interest</h2>';
    echo $bio->statement();
}

if (!$bio->bio()) {
    Notifications::printNotice('No biography entered');
}
if (!$bio->statement()) {
    Notifications::printNotice('No statement of interest entered');
}
