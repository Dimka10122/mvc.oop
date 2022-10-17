<?php
/**
 * @var string $requestsJson
 */

use Controller\Rise\ChangeRises;

$rise = new ChangeRises();

$events = [
    'reject' => 'Reject',
    'accept' => 'Accept'
];

include 'template/selectMenu.php';
?>

<form action="" method="POST">
    <ul class="list-group" data-bind="foreach: paginationViewModel.currentItems">
        <li class="list-group-item-roles list-group-item" data-bind="visible: $parent.paginationViewModel.isVisibleItem($data)">
            <div class="list-group-item-user-info">
                <label><strong><?= __('Username') ?>:</strong></label><em data-bind="text: login"></em><br>
                <label><strong><?= __('Request Role') ?>:</strong></label><em data-bind="text: request_role"></em><br>
                <label><strong><?= __('Request State') ?>:</strong></label><em data-bind="text: state"></em><br>
                <button type="submit" class="btn btn-success" name="request-action" value="access"><?= __('Access') ?></button>
                <button type="submit" class="btn btn-danger" name="request-action" value="deny"><?= __('Deny') ?></button>
            </div>
            <div class="admin-roles-controller">
                <input class="controller-select-field"
                       type="checkbox"
                       name="user-info-select[]"
                       data-bind="attr: {'value': id}, checked: $root.dropdownViewModel.isSelectedItem(id), click: $root.dropdownViewModel.selectItem(id)">
            </div>
        </li>
    </ul>
    <?php include 'template/paginationMenu.php';?>
    <div data-bind="if: paginationViewModel.currentItems().length == 0">
        <div class="alert alert-info" role="alert">
            <?= __('There is no messages!') ?>
        </div>
    </div>
</form>


<script>
    require(['../../assets/js/scripts/modules/pagination'], function (pagination) {
        pagination(<?= $requestsJson?>)
    });
</script>
