<?php
/**
 * @var array $allRoles
 * @var array $roleValidate
 */
?>

<form method="POST">
    <div class="row m-3 align-items-start">
        <div class="col-auto">
            <label class="col-form-label" for="userRole"><?= __('Role') ?></label>
        </div>
        <div class="col-auto">
            <select class="custom-select control-user-role-list" name="user-role-list" id="userId">
                <option class="controller_field" disabled selected name='user-role'><?=__('Change User Role')?></option>
                <?php foreach ($allRoles as $role) : ?>
                    <option class="controller_field" name='user-role' value="<?= $role["id"]?>"><?= $role["role_name"]?></option>
                <?php endforeach;?>
            </select>
        </div>
    </div>
    <input class="btn btn-success text-white ml-4" name="edit_user" value="<?= __('Save') ?>" type="submit">
    <a class="d-inline btn btn-danger text-decoration-none text-white" href="<?= BASE_URL ?>roles"><?= __('Cancel') ?></a>
</form>
<hr>
<div>
    <?php foreach ($roleValidate as $error): ?>
        <div class="alert alert-danger" role="alert">
            <?=__($error)?>
        </div>
    <?php endforeach; ?>
</div>
