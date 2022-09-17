<form class="d-inline" method="POST">
    <div class="row m-3 align-items-start">
        <p class="forgot-password-headline"><?= __('We have send you a reboot code to the specified email. Enter it above')?></p>
    </div>
    <div class="row m-3 align-items-start">
        <div class="col-auto">
            <label class="col-form-label" for="rebootCode"><?= __('Reboot Code') ?></label>
        </div>
        <div class="col-auto">
            <input class="form-control" type="number" class="form-control" id="rebootCode" name="reboot_code" value="<?= $fields['reboot_code'] ?>">
        </div> 
    </div>
    <input class="btn btn-success" name="confirm" value="<?= __('Confirm') ?>" type="submit">
    <a class="d-inline btn btn-danger text-decoration-none text-white" href="<?= BASE_URL ?>"><?= __('Go to main page') ?></a>
</form>
<hr>
<div>
    <? foreach($validateErrors as $error): ?>
        <div class="alert alert-danger" role="alert">
            <?=$error?>
        </div>
    <? endforeach; ?>
</div>