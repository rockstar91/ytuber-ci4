<?= $this->extend($config->viewLayout); ?>


<?php

$this->setData([
    'pageTitle'             => lang('Auth.forgotPassword'),
    'headerWelcomeTitle'    => 'Не волнуйся, мы тебя вернем',
    'headerWelcomeSub'      => 'Пожалуйста, введите свой адрес электронной почты'

]);
$this->setVar('pageTitle', lang('Auth.forgotPassword')); ?>

<?= $this->section('main'); ?>

<!-- Reminder Form -->
<!-- jQuery Validation functionality is initialized with .js-validation-reminder class in js/pages/op_auth_reminder.min.js which was auto compiled from _es6/pages/op_auth_reminder.js -->
<!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
<form class="js-validation-reminder" action="<?= route_to('forgot') ?>" method="post">
    <?= csrf_field() ?>
    <div class="block block-themed block-rounded block-shadow">
        <div class="block-header bg-gd-primary">
            <h3 class="block-title"><?=lang('Auth.forgotPassword')?></h3>
            <div class="block-options">
                <button type="button" class="btn-block-option">
                    <i class="si si-wrench"></i>
                </button>
            </div>
        </div>

        <div class=" alert alert-success mb-0">
            <?=lang('Auth.enterEmailForInstructions')?>
        </div>
        <?= view('App\Views\Auth\_message_block') ?>

        <div class="block-content">

            <div class="row">
                <div class="col-12">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-12">
                    <label for="reminder-credential"><?=lang('Auth.emailAddress')?></label>
                    <input type="email" class="form-control <?php if(session('errors.email')) : ?>is-invalid<?php endif ?>"
                           id="reminder-credential" name="email" placeholder="<?=lang('Auth.email')?>">
                    <div class="invalid-feedback">
                        <?= session('errors.email') ?>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-alt-primary">
                    <i class="fa fa-asterisk mr-10"></i> <?=lang('Auth.sendInstructions')?>
                </button>
            </div>
        </div>
        <div class="block-content bg-body-light">
            <div class="form-group text-center">
                <?php if ($config->allowRegistration) : ?>
                    <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="<?= route_to('register') ?>">
                        <i class="fa fa-plus mr-5"></i> <?=lang('Auth.needAnAccount')?>
                    </a>
                <?php endif; ?>
                <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="<?= route_to('login'); ?>">
                    <i class="fa fa-user text-muted mr-5"></i> <?=lang('Auth.signIn')?>
                </a>
            </div>
        </div>
    </div>
</form>
<!-- END Reminder Form -->
<?php $this->endSection(); ?>

<?php $this->section('pageScripts'); ?>
<script src="/dist/assets/js/pages/op_auth_reminder.min.js"></script>
<?php $this->endSection(); ?>

