<?php

/**
 * @var boolean $successEditedRole
 * @var int $startPage
 * @var string $deleteRoleError
 * @var string $usersJson
 * @var array $fields
 * @var array $validateErrors
 * @var array $allRoles
 * @var array $users
 * @var array $permsForRole
 * @var stdClass $userInfo
 */

if ($successEditedRole) : ?>
    <div class="alert alert-success" role="alert">
        <?=__('The role has been successfully edited!')?>
    </div>
<?php elseif ($successEditedRole === false) : ?>
    <div class="alert alert-danger" role="alert">
        <?=__('Error. User or role with this id does not exist!')?>
    </div>
<?php endif;
if ($deleteRoleError) : ?>
    <div class="alert alert-danger" role="alert">
        <?=__($deleteRoleError)?>
    </div>
<?php endif;

foreach ($validateErrors as $error) : ?>
    <div class="alert alert-danger" role="alert">
        <?=__($error)?>
    </div>
<?php endforeach;

if ($userInfo->canUser('add_roles')) :?>
    <div class="control-panel">
        <div class="control-panel-content">
            <form action="" method="POST">
                <div class="control-panel-item">
                    <label for="role_name"><?=__('Role Name')?></label>
                    <input class="form-control" type="text" id="role_name" name="role_name" placeholder="Admin" value="<?= __($fields["role_name"]);?>">
                    <br>
                    <select class="custom-select mb-2 mt-2" name="add_new_role_perms[]" multiple="multiple">
                        <option name="controller_field" value="select_option" disabled selected><?=__('Select Option')?></option>
                        <?php foreach ($permsForRole as $role => $roleName) : ?>
                            <option name="controller_field" value="<?= $role;?>"><?= __($roleName)?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="control-panel-item">
                    <button type="submit" class="btn btn-success" name="add_role_action"><?=__('Add Role')?></button>
                </div>
            </form>
        </div>
    </div>
<?php endif;?>
<div class="roles-block">
    <table class="roles-table">
        <tr class="table-head-row">
            <th class="roles-table-row-head"><?=__('Id')?></th>
            <th class="roles-table-row-head"><?=__('Name')?></th>
            <th class="roles-table-row-head"><?=__('Permissions')?></th>
            <?php if ($userInfo->canUser('modify_roles')) : ?>
                <th class="roles-table-row-head"><?=__('Action')?></th>
            <?php endif;?>
        </tr>
        <?php foreach ($allRoles as $role) : ?>
            <tr class="roles-table-row ">
                <td class="roles-table-row-data"><?= $role["id"]?></td>
                <td class="roles-table-row-data"><?= $role["role_name"]?></td>
                <td class="roles-table-row-data">
                    <?php $permsArray = (array)json_decode($role["permissions"]);
                    foreach($permsArray as $index => $perm) : ?>
                        <span><?=__($permsForRole[$perm]); echo $index == count($permsArray)-1 ? '' : ',';?></span>
                    <?php endforeach;?>
                </td>

                <?php if ($userInfo->canUser('modify_roles')) : ?>
                    <td class="roles-table-row-data">
                        <a class="btn btn-danger" href="<?=BASE_URL?>roles/<?= $role["id"]?>/delete" ><?=__('Delete')?></a>
                        <a class="btn btn-primary mt-2" href="<?=BASE_URL?>roles/<?= $role["id"]?>/modify" ><?=__('Edit')?></a>
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
    <?php
    $events = [
        'edit' => 'Edit',
        'delete' => 'Delete',
        'assign' => 'Assign Roles'
    ];
    include 'template/selectMenu.php';
    ?>
    <select class="custom-select" name="select-role-for-users">
        <option name="controller_field" value="select_option" disabled selected><?=__('Select Role')?></option>
        <?php foreach ($allRoles as $role) : ?>
            <option name="controller_field" value="<?=$role['id']?>"><?=__($role['role_name'])?></option>
        <?php endforeach;?>
    </select>
    <ul class="list-group" data-bind="foreach: currentItems">
        <li class="list-group-item">
            <div class="list-group-item-user-info">
                <label><strong><?= __('User email') ?>:</strong></label> <em data-bind="text: email"></em><br>
                <label><strong><?= __('Login') ?>:</strong></label> <em data-bind="text: login"></em><br>
                <label><strong><?= __('Role') ?>:</strong></label> <em data-bind="text: role_name"></em><br>
                <a class="btn btn-primary text-decoration-none text-white"
                        data-bind="attr: {'href' : '<?=BASE_URL?>roles<?=BASE_URL?>user<?=BASE_URL?>'+id+'<?=BASE_URL?>edit'}">
                    <?=__('Edit')?>
                </a>
            </div>
            <div class="admin-roles-controller">
                <input class="controller-select-field"
                       type="checkbox"
                       name="user-info-select[]"
                       data-bind="attr: {'value': id + '_' + role}">
            </div>
        </li>
    </ul>
</form>

<?php include 'template/paginationMenu.php';?>

<!--<script src="assets/js/scripts/modules/select.js"></script>-->


