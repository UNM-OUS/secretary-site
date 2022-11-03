<?php

use DigraphCMS\Context;
use DigraphCMS\Cron\Cron;
use DigraphCMS\HTTP\Request;
use DigraphCMS\HTTP\RequestHeaders;
use DigraphCMS\URL\URL;
use DigraphCMS\URL\URLs;
use DigraphCMS\URL\WaybackMachine;

if (file_exists(__DIR__.'/../.maintenance')) exit();

// get site name
$siteName = basename(realpath(__DIR__ . '/../..'));
$backupDir = '/home/univsec/public_html/_backup';

try {
    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../initialize.php';
    WaybackMachine::deactivate();
    URLs::beginContext(new URL('/'));
    Context::begin();
    Context::url(new URL('/'));
    Context::request(new Request(new URL('/~cron/'), 'get', new RequestHeaders(), []));
    set_time_limit(300);
    Cron::runJobs(time() + 120);
    Context::end();
} catch (\Throwable $th) {
    echo "$siteName: cron: " . $th->getMessage();
}
