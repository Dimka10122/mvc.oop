<?php
/** @var string $title */
use Model\Includes;
$userInfoClass = new Model\Includes\UserInfo();
?>

<nav class="site-nav">
    <div class="container header-nav">
        <ul class="nav right-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?=BASE_URL?>"><?= __('Home')?></a>
            </li>
            <?php if ($userInfoClass->canUser('add_messages')) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?=BASE_URL?>messages/add"><?= __('Add')?></a>
                </li>
            <?php endif;?>
            <li class="nav-item">
                <a class="nav-link" href="<?=BASE_URL?>contacts"><?= __('Contacts')?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?=BASE_URL?>pages"><?= __('Pages')?></a>
            </li>
            <?php if ($userInfoClass->canUser('statistics')) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?=BASE_URL?>statistics"><?= __('Stats')?></a>
                </li>
            <?php endif;?>
        </ul>
        <ul class="nav left-nav">
            <li class="nav-item">
                <form method="GET">
                    <input type="hidden" value="en" name="ln">
                    <button class="btn nav-link<?= $_GET["ln"] == 'en' || $_GET["ln"] == '' ? ' selected' : '' ?>">EN</button>
                </form>
            </li>
            <li class="nav-item">
                <form method="GET">
                    <input type="hidden" value="ua" name="ln">
                    <button class="btn nav-link<?= $_GET["ln"] == 'ua' ? ' selected' : '' ?>">UA</button>
                </form>
            </li>
            <li class="nav-item">
                <form method="GET">
                    <input type="hidden" value="pl" name="ln">
                    <button class="btn nav-link<?= $_GET["ln"] == 'pl' ? ' selected' : '' ?>">PL</button>
                </form>
            </li>
            <?php if ($userInfoClass->canUser('add_roles', 'edit_roles')): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?=BASE_URL?>roles"><?= __('Role')?></a>
                </li>
            <?php endif;
            if ($userInfoClass->canUser('block_users')): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?=BASE_URL?>block_users"><?= __('Block')?></a>
                </li>
            <?php endif;
            if ($userInfoClass->canUser('rise_users')): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?=BASE_URL?>rise/change_rises"><?= __('Rise up requests')?></a>
                </li>
                <?php if ($userInfoClass->canUser('create_page', 'control_pages')) : ?>
                    <li class="nav-item dropdown show-nav-li">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button">
                            Dropdown
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php if ($userInfoClass->canUser('create_page')) : ?>
                            <a class="nav-link dropdown-item" href="<?=BASE_URL?>pages<?=BASE_URL?>create_page">
                                <?= __('Create')?>
                            </a>
                        <?php endif;
                            if ($userInfoClass->canUser('control_pages')) : ?>
                                <a class="nav-link dropdown-item" href="<?=BASE_URL?>pages<?=BASE_URL?>">
                                    <?= __('Control')?>
                                </a>
                        <?php endif;?>
                        </div>
                    </li>
                <?php endif;?>
            <?php endif;
            if (
                $userInfoClass->canUser('send_rise_request') &&
                $userInfoClass->userInfoData
            ) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?=BASE_URL?>rise/request"><?= __('Ask for a rise')?></a>
                </li>
            <?php endif;
            if ($userInfoClass->userInfoData) :?>
                <li class="nav-item">
                    <a class="nav-link" href="<?=BASE_URL?>logout"><?= __('Log Out')?></a>
                </li>
            <?php endif;
            if (!$userInfoClass->userInfoData) :?>
                <li class="nav-item">
                    <a class="nav-link" href="<?=BASE_URL?>login"><?= __('Login')?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=BASE_URL?>register"><?= __('Register')?></a>
                </li>
            <?php endif;?>
        </ul>
    </div>
</nav>

<script src="assets/js/scripts/modules/dropdown.js"></script>

<div class="site-content">
    <div class="container">
        <main class="main">
            <h1 class="main-headline"><?= $title?></h1>
            <hr>
