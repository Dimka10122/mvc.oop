<?php
/**
 * @var string $title
 * @var stdClass $userInfo
 */
use Model\Includes\UserInfo;
$userInfo = new UserInfo();
$userInfo->setUserView();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$title?></title>
    <link rel="stylesheet" href="<?=BASE_URL?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=BASE_URL?>assets/css/main.css">
    <script src="https://requirejs.org/docs/release/2.3.6/minified/require.js"></script>
</head>
<body>
    <header class="site-header">
        <div class="container">
            <div class="logo">
                <div class="left-menu-header">
                    <div class="logo__title h3">Lesson site</div>
                    <div class="logo__subtitle h6"><?=__('About MVC')?></div>
                </div>
                <div class="right-menu-header">
                    <div class="username-block h4"><?=$userInfo->userInfoData['username']?></div>
                </div>
            </div>
        </div>
    </header>