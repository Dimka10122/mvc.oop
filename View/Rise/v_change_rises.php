<?php
/** @var array $requests */
$rise = new \Controller\Rise\ChangeRises();
?>


<ul class="list-group">
    <form action="" method="POST">
        <div class="control-panel">
            <div class="control-panel-item">
                <select name="change_rise_controller" class="control-user-role-list">
                    <option name="controller_field" value="select_option" disabled selected>Select Option</option>
                    <option name="controller_field" value="access">Access</option>
                    <option name="controller_field" value="deny">Deny</option>
                </select>
            </div>
            <div class="control-panel-item">
                <button type="button" class="btn btn-primary select-action">Select All</button>
                <button type="button" class="btn btn-warning select-action">Unselect All</button>
                <button type="submit" class="btn btn-success" name="apply_select_action">Apply</button>
            </div>
        </div>
    </form>
    <?php foreach ($requests as $request): ?>
        <form action="" method="POST">
            <li class="list-group-item-roles list-group-item">
                <div class="list-group-item-user-info">
                    <label><strong><?= __('Username') ?>:</strong></label><em> <?= $request['login'] ?></em><br>
                    <label><strong><?= __('Request Role') ?>:</strong></label><em> <?= $rise->convertRoleAction($request['request_role']) ?></em><br>
                    <label><strong><?= __('Request State') ?>:</strong></label><em> <?= $rise->convertStatusAction($request['state']) ?></em><br>
                    <input type="hidden" name="request_user_id" value="<?=$request['id']?>">
                    <button type="submit" class="btn btn-success" name="request-action" value="access"><?= __('Access') ?></button>
                    <button type="submit" class="btn btn-danger" name="request-action" value="deny"><?= __('Deny') ?></button>
                </div>
                <div class="admin-roles-controller">
                    <input class="controller-select-field" type="checkbox" name="user-info-select[]" id="user_id_<?= $request['id'] ?>" value="user_<?= $request['id'] ?>">
                </div>
            </li>
        </form>
    <?php endforeach;?>
</ul>

<script src="../assets/js/scripts/modules/select.js"></script>
