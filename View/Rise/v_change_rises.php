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
    <ul class="list-group" data-bind="foreach: currentItems">
        <li class="list-group-item-roles list-group-item">
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
                       data-bind="attr: {'value': id}">
            </div>
        </li>
    </ul>
    <?php include 'template/paginationMenu.php';?>
</form>


<script>
    require(['../../assets/js/scripts/modules/pagination'], function (pagination) {
        pagination(<?= $requestsJson?>)
    });
</script>
