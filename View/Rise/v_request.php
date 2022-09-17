<form method="POST">
    <div class="row m-3 align-items-start">
        <div class="col-auto">
            <label class="col-form-label" for="userRole"><?= __('Send Request for a Rise') ?></label>
        </div>
        <div class="col-auto">
            <select class="control-user-role-list" name="user-role-list" id="userId">
                <option disabled selected name='user-role-item'>Choose role</option>
                <?php foreach ($allRoles as $role) :?>
                    <option name="user-role-item" value="<?=$role["id"]?>"><?=$role["role_name"]?></option>
                <? endforeach;?>
            </select>
        </div>
    </div>
    <input class="btn btn-success text-white ml-4" name="send_request_rise" value="<?= __('Send') ?>" type="submit">
    <a class="d-inline btn btn-danger text-decoration-none text-white" href="<?= BASE_URL ?>"><?= __('Cancel') ?></a>
</form>
<hr>
<div>
    <? foreach($validateErrors as $error): ?>
        <div class="alert alert-danger" role="alert">
            <?=$error?>
        </div>
    <? endforeach; ?>
</div>