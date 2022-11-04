<?php

use DigraphCMS\Users\Permissions;

Permissions::requireMetaGroup('ousadmin__edit');

?>
<h1>OUS admin links</h1>

<p>
    Note: These links are only going to sites that are on the last generation framework.
    Any sites not listed here should have a log in link in the footer that you can use to sign in.
</p>

<ul>
    <li><a href="https://facgov.unm.edu/_user/signin" target="_blank">Faculty Governance</a></li>
    <li><a href="https://rac.unm.edu/_rac/" target="_blank">RAC admin dashboard</a></li>
    <li><a href="https://graduation.unm.edu/_user/signin" target="_blank">Commencement</a></li>
    <li><a href="https://freshmanconvocation.unm.edu/_user/signin" target="_blank">Freshman Convocation</a></li>
</ul>
