<?php
    /** @var boolean $successText */
    /** @var boolean $successDeleted */
    /** @var boolean $successEdited */
    /** @var array $messages */
    /** @var string $messagesJson */
    $userInfoClass = new Model\Includes\UserInfo();
?>

<?php if ( $successText ): ?>
    <div class="alert alert-success" role="alert">
        <?= __('The message has been successfully added!') ?>
    </div>
<?php endif; ?>
<?php if ( $successDeleted ): ?>
    <div class="alert alert-success" role="alert">
        <?= __('The message has been successfully deleted!') ?>
    </div>
<?php endif; ?>
<?php if ( $successEdited ): ?>
    <div class="alert alert-success" role="alert">
        <?= __('The message has been successfully edited!') ?>
    </div>
<?php endif; ?>

<script>
    require([
        'assets/js/scripts/modules/pagination'
    ], function (pagination) {
        pagination(<?= $messagesJson?>)
    });
</script>

<ul class="list-group" data-bind="foreach: currentMessages">
    <li class="list-group-item">
        <label><strong><?= __('Message id') ?>:</strong></label> <em data-bind="text: id"></em><br>
        <label><strong><?= __('User Name') ?>:</strong></label> <em data-bind="text: name"></em><br>
        <label><strong><?= __('Title') ?>:</strong></label> <em data-bind="text: title"></em><br>
        <label><strong><?= __('Message') ?>:</strong></label> <em data-bind="text: message"></em><br>
        <label><strong><?= __('Created At') ?>:</strong></label> <em data-bind="text: created_at"></em><br>
    </li>
</ul>

<div class="navigation-block">
    <div class="form-paginator">
        <a class="nav-btn-link" data-bind="visible: showPrevLink, click: prevPage"><</a>
        <ul class="pagination-pages-list" data-bind="foreach: pagesCountArray">
            <li class="btn btn-primary nav-btn" data-bind="text: $data, click: $parent.switchPage.bind($parent)"></li>
        </ul>
        <a class="nav-btn-link" data-bind="visible: showNextLink, click: nextPage">></a>
    </div>
</div>