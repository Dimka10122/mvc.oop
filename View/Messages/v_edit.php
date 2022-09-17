<form method="POST">
    <div class="row m-3 align-items-start">
        <div class="col-auto">
            <label class="col-form-label" for="messageName"><?= __('Title') ?></label>
        </div>
        <div class="col-auto">
            <input class="form-control" id="messageName" name="title" value="<?= $fields['title'] ?>">
        </div> 
    </div>
    <div class="row m-3 align-items-start">
        <div class="col-auto">
            <label class="col-form-label" for="messageId"><?= __('Message') ?></label>
        </div>
        <div class="col-auto">
            <textarea class="form-control" type="text" name="message" id="messageId"><?= $fields['message'] ?></textarea>
        </div>
    </div>
    <input class="btn btn-success ml-4" name="edit_message" value="<?= __('Save') ?>" type="submit">
    <a class="d-inline btn btn-danger text-decoration-none text-white" href="<?= BASE_URL ?>"><?= __('Cancel') ?></a>
</form>