<?= $this->extend($config->viewLayout) ?>

<?php
$this->setData([
    'pageTitle'             => lang('Auth.register'),
    'headerWelcomeTitle'    => 'Ого... Какие люди?!',
    'headerWelcomeSub'      => 'Мы рады, что вы выбрали нас. Добро пожаловать на борт!'

]);
?>

<?= $this->section('main') ?>

<!-- Sign Up Form -->
<!-- jQuery Validation functionality is initialized with .js-validation-signup class in js/pages/op_auth_signup.min.js which was auto compiled from _es6/pages/op_auth_signup.js -->
<!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
<form class="js-validation-signup" action="<?= route_to('register') ?>" method="post">

    <?= csrf_field() ?>

    <div class="block block-themed block-rounded block-shadow">
        <div class="block-header bg-gd-emerald">
            <h3 class="block-title"><?=lang('Auth.register')?></h3>
            <div class="block-options">
                <button type="button" class="btn-block-option">
                    <i class="si si-wrench"></i>
                </button>
            </div>
        </div>

        <?= view('App\Views\Auth\_message_block'); ?>

        <div class="block-content">
            <div class="form-group row">
                <div class="col-12">
                    <label for="signup-username"><?=lang('Auth.username')?></label>
                    <input type="text" class="form-control <?php if(session('errors.username')) : ?>is-invalid<?php endif ?>" id="signup-username" name="username" placeholder="eg: john_smith" value="<?= old('username') ?>">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12">
                    <label for="signup-email"><?=lang('Auth.email')?></label>
                    <input type="email" class="form-control <?php if(session('errors.email')) : ?>is-invalid<?php endif ?>" id="signup-email" name="email" placeholder="eg: john@example.com" value="<?= old('email') ?>">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12">
                    <label for="signup-password"><?=lang('Auth.password')?></label>
                    <input type="password" class="form-control <?php if(session('errors.password')) : ?>is-invalid<?php endif ?>" id="signup-password" name="password" placeholder="********">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12">
                    <label for="signup-password-confirm"><?=lang('Auth.repeatPassword')?></label>
                    <input type="password" class="form-control <?php if(session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" id="signup-password-confirm" name="pass_confirm" placeholder="********">
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-sm-12 push">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="signup-terms" name="signup-terms">
                        <label class="custom-control-label" for="signup-terms"><?=lang('Auth.termsConfirm')?></label>
                    </div>
                </div>
                <div class="col-sm-12 text-sm-center push">
                    <button type="submit" class="btn btn-alt-success">
                        <i class="fa fa-plus mr-10"></i> <?=lang('Auth.register')?>
                    </button>
                </div>
            </div>
        </div>
        <div class="block-content bg-body-light">
            <div class="form-group text-center">
                <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="#" data-toggle="modal" data-target="#modal-terms">
                    <i class="fa fa-book text-muted mr-5"></i> <?=lang('Auth.terms')?>
                </a>
                <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="<?= route_to('login') ?>">
                    <i class="fa fa-user text-muted mr-5"></i> <?=lang('Auth.signIn')?>
                </a>
            </div>
        </div>
    </div>
</form>
<!-- END Sign Up Form -->
<?php $this->endSection(); ?>

<?php $this->section('beforeScripts'); ?>
<?= view($config->views['termsModal']); ?>
<?php $this->endSection(); ?>

<?php $this->section('pageScripts'); ?>
<script src="/dist/assets/js/pages/op_auth_signup.min.js"></script>
<?php $this->endSection(); ?>
