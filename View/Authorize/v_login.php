<?php if ($isExistsUser): ?>
    <div class="alert alert-success" role="alert">
        <?= __("You have successfully registered! Let's Log In") ?>
    </div>
<?php endif; ?>
<?php if ($successChangePass): ?>
    <div class="alert alert-success" role="alert">
        <?= __("You have successfully changed password! Let's Log In") ?>
    </div>
<?php endif; ?>
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
            <label class="col-form-label" for="password"><?= __('Password') ?></label>
        </div>
        <div class="col-auto">
            <input class="form-control" type="password" name="password" id="password" value="<?= $fields['password'] ?>">
        </div>
    </div>
    <div class="row m-3 align-items-center">
        <div class="col-auto">
            <label class="col-form-label" for="remember_user"><?= __('Remember Me') ?></label>
        </div>
        <div class="col-auto">
            <input type="checkbox" name="remember_user" id="remember_user">
        </div>
    </div>
    <input class="btn btn-success" name="login" value="<?= __('Login') ?>" type="submit">
    <a class="d-inline btn btn-danger text-decoration-none text-white" href="<?= BASE_URL ?>"><?= __('Go to main page') ?></a>
</form>
<div class="forgot-password-block">
    <a class="d-inline btn btn-primary text-decoration-none text-white" href="<?= BASE_URL ?>forgot_pass"><?= __('Forgot Password?') ?></a>
</div>
<hr>
<div>
    <? foreach($loggedErrors as $error): ?>
        <div class="alert alert-danger" role="alert">
            <?=$error?>
        </div>
    <? endforeach; ?>
</div>