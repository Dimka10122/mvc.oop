<?php
/** @var array $contentValidate */
/** @var array $pageData */
?>

<div class="errors-block">
    <?php foreach($contentValidate as $error ): ?>
        <div class="alert alert-danger" role="alert">
            <?=$error?>
        </div>
    <?php endforeach; ?>
</div>
<form method="POST">
    <div class="row m-3 align-items-start">
        <div class="col-auto">
            <p>You are not allowed to use these HTML tags: script, link, input, button, form</p>
        </div>
    </div>
    <hr>
    <div class="row m-3 align-items-start">
        <div class="col-auto d-flex flex-column input-group">
            <label>
                <h5>Title</h5>
                <input value="<?= $pageData["page_title_data"]?>"
                       name="page_title_data"
                       class="form-control"
                       placeholder="Enter Title"/>
            </label>
            <label>
                <h5>Url Key</h5>
                <input value="<?= $pageData["page_url_key_data"]?>"
                       name="page_url_key_data"
                       class="form-control"
                       placeholder="Enter Url Key"/>
            </label>
            <label>
                <h5>Content</h5>
                <textarea name="page_content_data"
                          class="form-control"
                          rows="15"
                          placeholder="Enter Content"><?= $pageData['page_content_data']?></textarea>
            </label>

        </div>
    </div>
    <input class="btn btn-success text-white ml-4" name="page_action" value="<?= __('Save') ?>" type="submit">
    <a class="d-inline btn btn-danger text-decoration-none text-white"
       href="<?= BASE_URL ?>pages">
        <?= __('Cancel') ?>
    </a>
</form>
<hr>