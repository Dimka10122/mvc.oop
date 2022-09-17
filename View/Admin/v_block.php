<?php if ( $isUserBlocked ) : ?>
    <div class="alert alert-success" role="alert">
        <?= __('You have successfully blocked user!') ?>
    </div>
<?php endif; ?>
<form method="POST">
    <div class="row m-3 align-items-start">
        <div class="col-auto">
            <label class="col-form-label" for="userEmail"><?= __('Email') ?></label>
        </div>
        <div class="col-auto">
            <input class="form-control" type="email" name="email" id="userEmail" value="<?= $fields['email'] ?>">
        </div>
    </div>
    <div class="row m-3 align-items-start">
        <div class="col-auto">
            <label class="col-form-label" for="blockDate"><?= __('Date') ?></label>
        </div>
        <div class="col-auto">
            <input class="form-control" type="datetime-local" name="block_date" id="blockDate" value="<?= $fields['block_date'] ?>">
        </div>
    </div>
    <input class="btn btn-primary text-white ml-4" name="block_user" value="<?= __('Block') ?>" type="submit">
    <a class="d-inline btn btn-danger text-decoration-none text-white" href="<?= BASE_URL ?>roles">
        <?= __('Cancel') ?>
    </a>
</form>
<hr>
<div>
    <? foreach( $validateErrors as $error ): ?>
        <div class="alert alert-danger" role="alert">
            <?=$error?>
        </div>
    <? endforeach; ?>
</div>