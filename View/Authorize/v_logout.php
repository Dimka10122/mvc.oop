<?php
/**
 * @var stdClass $userInfo
 */
?>
<form class="d-inline" method="POST">
    <div class="delete-message-block">
        <p class="log-out-text"><?=__('You want to sign out,')?> <b><?= $userInfo->userInfoData['username']?></b>?</p>
    </div>
    <input class="btn btn-success" name="logout" value="<?= __('Log Out')?>" type="submit">
</form>
<a class="d-inline btn btn-danger text-decoration-none text-white" href="<?= BASE_URL ?>"><?= __('Cancel') ?></a>