
<form class="d-inline" method="POST">
    <div class="delete-message-block">
        <label><strong><?= __('Are you sure?') ?></strong></label>
    </div>
    <input class="btn btn-success" name="delete_role_action" value="<?= __('Delete') ?>" type="submit">
</form>
<a class="d-inline btn btn-danger text-decoration-none text-white" href="<?= BASE_URL ?>roles"><?= __('Cancel') ?></a>
