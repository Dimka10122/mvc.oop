<?php

declare(strict_types=1);

/**
 * @by ProfStep, inc. 28.12.2020
 * @website: https://profstep.com
 **/

/** Version check */
if (!defined('PHP_VERSION_ID') || PHP_VERSION_ID < 70300) {
    die("Not supported version of PHP");
}

/** Executor check */
if (PHP_SAPI == 'cli') {
    die("You cant run this in CLI!");
}

/** Set default timezone */
date_default_timezone_set('UTC');

/** Set global precision configuration */
ini_set('precision', '14');
ini_set('serialize_precision', '14');

const HOST = 'http://mvc.oop';
const BASE_URL = '/';

include_once('autoload.php');
include_once('Core/changeLang.php');
include_once('Core/arr.php');
include_once('Core/DB.php');
include_once('Core/system.php');
include_once('Core/getController.php');
include_once('Api/index.php');