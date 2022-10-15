<?php

/**
 * @var array $registeredUserErrors
 * @var array $validateErrors
 */

?>

<form class="d-inline" method="POST">
    <div class="row m-3 align-items-start">
        <div class="col-auto">
            <label class="col-form-label" for="username"><?= __('Username') ?></label>
        </div>
        <div class="col-auto">
            <input class="form-control" id="username" name="username" value="<?= $fields['username'] ?>">
        </div> 
    </div>
    <div class="row m-3 align-items-start">
        <div class="col-auto">
            <label class="col-form-label" for="email"><?= __('Email') ?></label>
        </div>
        <div class="col-auto">
            <input class="form-control" type="email" name="email" id="email" value="<?= $fields['email'] ?>">
        </div>
    </div>
    <div class="row m-3 align-items-start">
        <div class="col-auto">
            <label class="col-form-label" for="password"><?= __('Password') ?></label>
        </div>
        <div class="col-auto">
            <input class="form-control" type="password" name="password" id="password" value="<?= $fields['password'] ?>">
        </div>
    </div>
    <div class="row m-3 align-items-start">
        <div class="col-auto">
            <label class="col-form-label" for="repeat_pass"><?= __('Repeat password') ?></label>
        </div>
        <div class="col-auto">
            <input class="form-control" type="password" name="repeat_pass" id="repeat_pass" value="<?= $fields['repeat_pass'] ?>">
        </div>
    </div>
    <input class="btn btn-primary" name="register" value="<?= __('Register') ?>" type="submit">
    <a class="d-inline btn btn-danger text-decoration-none text-white" href="<?= BASE_URL ?>"><?= __('Go to main page') ?></a>
</form>
<hr>
<div>
    <?php foreach($validateErrors as $error): ?>
        <div class="alert alert-danger" role="alert">
            <?=__($error)?>
        </div>
    <?php endforeach; ?>
</div>