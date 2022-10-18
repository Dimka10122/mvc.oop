<?php
/**
 * @var string $messagesJson
 * @var array $messages
 * @var array $messages
 * @var boolean $successEdited
 * @var boolean $successDeleted
 * @var boolean $successText
 * @var stdClass $userInfo
 */

if ($successText): ?>
    <div class="alert alert-success" role="alert">
        <?= __('The message has been successfully added!') ?>
    </div>
<?php endif;

if ($successDeleted === true): ?>
    <div class="alert alert-success" role="alert">
        <?= __('The message has been successfully deleted!') ?>
    </div>
<?php elseif ($successDeleted === false) : ?>
    <div class="alert alert-danger" role="alert">
        <?= __('Message with this id is not exist!') ?>
    </div>
<?php endif;

if ($successEdited): ?>
    <div class="alert alert-success" role="alert">
        <?= __('The message has been successfully edited!') ?>
    </div>
<?php endif; ?>

<form method="POST">
    <div data-bind="if: paginationViewModel.currentItems().length > 0">
        <?php if ($userInfo->canUser('edit_messages', 'delete_messages')) {
            $events = [
                'edit' => 'Edit',
                'delete' => 'Delete'
            ];
            include 'template/selectMenu.php';
        }?>
    </div>
    <ul class="list-group" data-bind="foreach: paginationViewModel.allItems">
        <li class="list-group-item" data-bind="visible: $parent.paginationViewModel.isVisibleItem($data)">
            <div class="wrapper-item">
                <div class="list-group-item-info-messages">
                    <label><strong><?= __('Message id') ?>:</strong></label> <em data-bind="text: id"></em><br>
                    <label><strong><?= __('User Name') ?>:</strong></label> <em data-bind="text: name"></em><br>
                    <label><strong><?= __('Title') ?>:</strong></label> <em data-bind="text: title"></em><br>
                    <label><strong><?= __('Message') ?>:</strong></label> <em data-bind="text: message"></em><br>
                    <label><strong><?= __('Created At') ?>:</strong></label> <em data-bind="text: created_at"></em><br>
                </div>
                <?php if ($userInfo->canUser('edit_messages')) : ?>
                    <div class="control-actions-block mt-2">
                        <a class="btn btn-danger mr-2"
                           data-bind="attr: {'href' : '<?=BASE_URL?>messages<?=BASE_URL?>'+id+'<?=BASE_URL?>delete'}">
                            <?=__('Delete')?>
                        </a>
                        <a class="btn btn-primary"
                           data-bind="attr: {'href' : '<?=BASE_URL?>messages<?=BASE_URL?>'+id+'<?=BASE_URL?>edit'}">
                            <?=__('Edit')?>
                        </a>
                    </div>
                <?php endif;?>
            </div>
            <?php if ($userInfo->canUser('edit_messages', 'delete_messages')) :?>
                <div class="list-group-item-select-menu">
                    <input class="controller-select-field"
                           type="checkbox"
                           name="message-info-select[]"
                           data-bind="
                               attr: {'value': id},
                               click: $root.dropdownViewModel.selectItem,
                               checked: $root.dropdownViewModel.isSelectedItem(id),
                               html: console.log($root.dropdownViewModel.isSelectedItem(id))
">
                </div>
            <?php endif;?>
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
    require(['assets/js/scripts/koInit'], function (koInit) {
        koInit(<?=$messagesJson?>);
    });
</script>