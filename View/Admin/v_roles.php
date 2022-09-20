<?php

/** @var string $usersJson */
/** @var boolean $successEditedRole */
/** @var array $fields */
/** @var array $validateErrors */
/** @var array $allRoles */
/** @var array $users */
/** @var int $startPage */
/** @var array $permsForRole */

if ($successEditedRole) : ?>
    <div class="alert alert-success" role="alert">
        <?= __('The role has been successfully edited!') ?>
    </div>
<?php endif;
$roleClass = new \Controller\Admin\Roles();
$userInfoClass = new Model\Includes\UserInfo();
?>

<div class="control-panel">
    <?php if ($userInfoClass->canUser('add_roles')) : ?>
        <form action="" method="POST">
            <?php foreach ($validateErrors as $error) : ?>
                <div class="alert alert-danger" role="alert">
                    <?=$error?>
                </div>
            <?php endforeach;?>
            <div class="control-panel-item">
                <label for="role_name">Role Name</label>
                <input class="form-control" type="text" id="role_name" name="role_name" placeholder="Admin" value="<?= $fields["role_name"];?>">
                <br>
                <select class="custom-select mb-2 mt-2" name="add_new_role_perms[]" multiple="multiple">
                    <option name="controller_field" value="select_option" disabled selected>Select Option</option>
                    <?php foreach ($permsForRole as $role => $roleName) : ?>
                        <option name="controller_field" value="<?= $role;?>"><?= $roleName?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="control-panel-item">
                <button type="submit" class="btn btn-success" name="add_role_action">Add Role</button>
            </div>
        </form>
    <?php endif;?>
</div>
<div class="roles-block">
    <table class="roles-table">
        <tr class="table-head-row">
            <th class="roles-table-row-head">Id</th>
            <th class="roles-table-row-head">Name</th>
            <th class="roles-table-row-head">Permissions</th>
            <?php if ($userInfoClass->canUser('modify_roles')) : ?>
                <th class="roles-table-row-head">Action</th>
            <?php endif;?>
        </tr>
        <?php foreach ($allRoles as $role) : ?>
            <tr class="roles-table-row ">
                <td class="roles-table-row-data"><?= $role["id"]?></td>
                <td class="roles-table-row-data"><?= $role["role_name"]?></td>
                <td class="roles-table-row-data">
                    <?php foreach((array)json_decode($role["permissions"]) as $perm ) : ?>
                        <span><?=$perm?>, </span>
                    <?php endforeach;?>
                </td>

                <?php if ($userInfoClass->canUser('modify_roles')) : ?>
                    <td class="roles-table-row-data">
                        <a class="btn btn-danger" href="<?=BASE_URL?>roles/<?= $role["id"]?>/delete" >Delete</a>
                        <form action="<?=BASE_URL?>roles/<?= $role["id"]?>/modify" method="POST">
                            <input type="hidden" name="edit_role_name" value="<?= $role["role_name"];?>">
                            <input type="hidden" name="edit_role_id" value="<?= $role["id"];?>">
                            <input type="hidden" name="edit_role_perms" value="<?= $roleClass->correctPerm($role["permissions"]);?>">
                            <button class="btn btn-primary" name="edit_role_action" type="submit">Edit</button>
                        </form>
                    </td>
                <?php endif;?>
            </tr>
        <?php endforeach;?>
    </table>
</div>

<script>
    require(['assets/js/scripts/modules/pagination'], function (pagination) {
        pagination(<?= $usersJson?>)
    })
</script>

<form action="" method="POST">
    <hr>
    <?php include 'template/selectMenu.html'?>
    <ul class="list-group" data-bind="foreach: currentItems">
        <li class="list-group-item">
            <div class="list-group-item-user-info">
                <label><strong><?= __('User email') ?>:</strong></label> <em data-bind="text: email"></em><br>
                <label><strong><?= __('Login') ?>:</strong></label> <em data-bind="text: login"></em><br>
                <label><strong><?= __('Role') ?>:</strong></label> <em data-bind="text: role_name"></em><br>
                <button class="btn btn-primary text-decoration-none text-white">Edit</button>
            </div>
            <div class="admin-roles-controller">
            <!---- @TODO: нарішати з цим інпутом і всім де була пагінація і
                передавались дані з foreach. подивитись як міняти атрибути через ko
             ---->
                <input class="controller-select-field" type="checkbox" name="user-info-select[]" id="user_id_<?= $user['id'] ?>" value="user_<?= $user['id'] ?>">
            </div>
        </li>
    </ul>
</form>

<?php include 'template/paginationMenu.html';?>

<script src="assets/js/scripts/modules/select.js"></script>


