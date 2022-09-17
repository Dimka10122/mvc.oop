<form method="POST">
    <div class="row m-3 align-items-start">
        <div class="col-auto">
            <div class="control-panel-item">
                <label for="role_name">Role Name</label>
                <input type="text" id="role_name" name="edit_role_name" value="<?=$roleName?>" placeholder="Admin">
                <input type="hidden" name="edit_role_id" value="<?=$roleId?>">
                <br>
                <select name="edit_role_perms[]" multiple="multiple" class="role-permissions-list">
                        <option name="controller_field" value="select_option" disabled selected>Select Option</option>
                    <?php foreach ($permsForRoleArr as $permForRole => $permValue):?>
                        <option class="role-permission-item"
                                name="controller_field"
                                value="<?=$permForRole?>"
                                <?php
                                if (in_array($permForRole, $rolePerms)) {
                                    echo 'selected';
                                }?>
                        >
                            <?= $permValue?>
                        </option>
                    <?php endforeach;?>
<!--                        <option name="controller_field" value="delete_message">Delete Messages</option>-->
<!--                        <option name="controller_field" value="edit_message">Edit Messages</option>-->
<!--                        <option name="controller_field" value="add_message">Add Messages</option>-->
<!--                        <option name="controller_field" value="block_user">Block Users</option>-->
<!--                        <option name="controller_field" value="add_roles">Add Roles</option>-->
<!--                        <option name="controller_field" value="edit_roles">Edit Roles</option>-->
                </select>
            </div>
        </div>
    </div>
    <input class="btn btn-success text-white ml-4" name="save_edit_role" value="<?= __('Save') ?>" type="submit">
    <a class="d-inline btn btn-danger text-decoration-none text-white" href="<?= BASE_URL ?>roles"><?= __('Cancel') ?></a>
</form>
<hr>
<div>
    <? foreach( $validateErrors as $error ): ?>
        <div class="alert alert-danger" role="alert">
            <?=$error?>
        </div>
    <? endforeach; ?>
</div>