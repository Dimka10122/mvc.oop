<?php
/**
 * @var string $roleName
 * @var numeric $roleId
 * @var array $permsForRoleArr
 * @var array $rolePerms
 * @var array $validateErrors
 * @var array $roleData
 */
?>
<div>
    <?php foreach($validateErrors as $error ): ?>
        <div class="alert alert-danger" role="alert">
            <?=__($error)?>
        </div>
    <?php endforeach; ?>
</div>
<form method="POST">
    <div class="row m-3 align-items-start">
        <div class="col-auto">
            <div class="control-panel-item">
                <label for="role_name"><?=__('Role Name')?></label>
                <input class="form-control" type="text" id="role_name" name="role_name" value="<?=$roleData['role_name']?>" placeholder="Admin">
                <br>
                <select name="permissions[]" multiple="multiple" class="role-permissions-list custom-select">
                        <option name="controller_field" value="select_option" disabled selected><?=__('Select Option')?></option>
                        <?php foreach ($permsForRoleArr as $permForRole => $permValue):?>
                            <option class="role-permission-item"
                                    name="controller_field"
                                    value="<?=$permForRole?>"
                                    <?php if (in_array($permForRole, json_decode($roleData['permissions']))) {
                                        echo 'selected';
                                    }?>>
                                <?=__($permValue)?>
                            </option>
                        <?php endforeach;?>
                </select>
            </div>
        </div>
    </div>
    <input class="btn btn-success text-white ml-4" name="save_modify_role" value="<?= __('Save') ?>" type="submit">
    <a class="d-inline btn btn-danger text-decoration-none text-white" href="<?= BASE_URL ?>roles"><?= __('Cancel') ?></a>
</form>