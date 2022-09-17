<?php

/** @var int $currentPage */
/** @var int $pagesNum */
/** @var int $currentPage */
/** @var boolean $successEditedRole */
/** @var array $fields */
/** @var array $validateErrors */
/** @var array $allRoles */
/** @var array $users */
/** @var int $startPage */
/** @var array $permsForRole */

$prevRef = $currentPage > $pagesNum ? 1 : $currentPage - 1;
if ($successEditedRole) : ?>
    <div class="alert alert-success" role="alert">
        <?= __('The role has been successfully edited!') ?>
    </div>
<?php endif;
    $roleClass = new \Controller\Admin\Roles();
    $userInfoClass = new Model\Includes\UserInfo();
?>

<ul class="list-group">
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
                    <input type="text" id="role_name" name="role_name" placeholder="Admin" value="<?= $fields["role_name"];?>">
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

    <form action="" method="POST">
        <hr>
        <div class="control-panel">
            <div class="control-panel-item">
                <select class="custom-select" name="change_user_controller">
                    <option name="controller_field" value="select_option" disabled selected>Select Option</option>
                    <option name="controller_field" value="delete">Delete</option>
                    <option name="controller_field" value="assign_role">Assign Role</option>
                </select>
            </div>
            <div class="control-panel-item">
                <button type="button" class="btn btn-primary select-action">Select All</button>
                <button type="button" class="btn btn-warning select-action">Unselect All</button>
                <button type="submit" class="btn btn-success">Apply</button>
            </div>
        </div>
        <?php if (
                count($users) > 0 &&
                $userInfoClass->canUser('edit_roles')
            ) :
            foreach ($users as $user): ?>
                <li class="list-group-item-roles list-group-item">
                    <div class="list-group-item-user-info">
                        <label><strong><?= __('User email') ?>:</strong></label><em> <?= $user['email'] ?></em><br>
                        <label><strong><?= __('Login') ?>:</strong></label><em> <?= $user['login'] ?></em><br>
                        <label><strong><?= __('Role') ?>:</strong></label><em> <?= $user['role_name'] ?></em><br>
                        <a class="btn btn-primary text-decoration-none text-white" href="<?= BASE_URL ?>roles/<?= $user['id'] ?>/edit"><?= __('Edit') ?></a>
                    </div>
                    <div class="admin-roles-controller">
                        <input class="controller-select-field" type="checkbox" name="user-info-select[]" id="user_id_<?= $user['id'] ?>" value="user_<?= $user['id'] ?>">
                    </div>
                </li>
            <?php endforeach;
        else :?>
            <p class="pages-error-message"><?= __("Please back to exist page for observe users...")?></p>
        <?php endif;?>
    </form>
</ul>

<div class="navigation-block">
    <form action="" method="GET" class="form-paginator">
        <?php if( $currentPage > 1 ) :?>
            <a href="<?= BASE_URL ?>roles?page=<?= $prevRef ?>" class="nav-btn-link"><</a>
        <?php endif;
            while ($startPage <= $pagesNum) :?>
            <button type="submit"
                    name="page"
                    value="<?= $startPage?>"
                    class="btn btn-primary nav-btn<?= $currentPage == $startPage ? '-selected' : ''?>">
                <?= $startPage?>
            </button>
            <?php $startPage++;
                endwhile;
                if( $currentPage < $pagesNum ) :?>
            <a href="<?= BASE_URL ?>roles?page=<?= $currentPage + 1?>" class="nav-btn-link">></a>
        <?php endif?>
    </form>
</div>

<script src="assets/js/scripts/modules/select.js"></script>
