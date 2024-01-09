<?= $this->extend($config->viewLayout) ?>

<?php $this->setVar('pageTitle', lang('Auth.loginTitle')); ?>

<?= $this->section('main') ?>

<!-- Sign In Form -->
<!-- jQuery Validation functionality is initialized with .js-validation-signin class in js/pages/op_auth_signin.min.js which was auto compiled from _es6/pages/op_auth_signin.js -->
<!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
<form class="js-validation-signin" action="<?= route_to('login') ?>" method="post">
    <?= csrf_field() ?>
    <div class="block block-themed block-rounded block-shadow">
        <div class="block-header bg-gd-dusk">
            <h3 class="block-title"><?=lang('Auth.loginTitle')?></h3>
            <div class="block-options">
                <button type="button" class="btn-block-option">
                    <i class="si si-wrench"></i>
                </button>
            </div>
        </div>

        <?= view('App\Views\Auth\_message_block') ?>

        <div class="block-content">
            <?php if ($config->validFields === ['email']): ?>
            <div class="form-group row">
                <div class="col-12">
                    <label for="login-username"><?=lang('Auth.email')?></label>
                    <input type="text" class="form-control" id="login-username" name="login" placeholder="<?=lang('Auth.email')?>">
                </div>
                <div class="invalid-feedback">
                    <?= session('errors.login') ?>
                </div>
            </div>
            <?php else : ?>
            <div class="form-group row">
                <div class="col-12">
                    <label for="login-username"><?=lang('Auth.emailOrUsername')?></label>
                    <input type="text" class="form-control" id="login-username" name="login" placeholder="<?=lang('Auth.emailOrUsername')?>">
                </div>
                <div class="invalid-feedback">
                    <?= session('errors.login') ?>
                </div>
            </div>
            <?php endif; ?>
            <div class="form-group row">
                <div class="col-12">
                    <label for="login-password"><?=lang('Auth.password')?></label>
                    <input type="password" class="form-control" id="login-password" name="password" placeholder="<?=lang('Auth.password')?>">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12">
                    <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="<?= route_to('redirectGoogleAuthUrl') ?>">
                        <i class="fa fa-google mr-5"></i> <?=lang('Auth.signinByGoogle')?>
                    </a>
                </div>
            </div>
            <div id="vk_auth"></div>
            <div class="form-group row mb-0">
                <?php if ($config->allowRemembering): ?>
                <div class="col-sm-7 d-sm-flex align-items-center push">
                    <div class="custom-control custom-checkbox mr-auto ml-0 mb-0">
                        <input type="checkbox" class="custom-control-input" id="login-remember-me" name="remember">
                        <label class="custom-control-label" for="login-remember-me"<?php if(old('remember')) : ?> checked <?php endif ?>><?=lang('Auth.rememberMe')?>
                        </label>
                    </div>
                </div>
                <?php endif; ?>
                <div class="col-sm-5 text-sm-right push">
                    <button type="submit" class="btn btn-alt-primary">
                        <i class="si si-login mr-10"></i> <?=lang('Auth.loginAction')?>
                    </button>
                </div>
            </div>
        </div>
        <div class="block-content bg-body-light">
            <div class="form-group text-center">
                <?php if ($config->allowRegistration) : ?>
                <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="<?= route_to('register') ?>">
                    <i class="fa fa-plus mr-5"></i> <?=lang('Auth.needAnAccount')?>
                </a>
                <?php endif; ?>
                <?php if ($config->activeResetter): ?>
                <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="<?= route_to('forgot') ?>">
                    <i class="fa fa-warning mr-5"></i> <?=lang('Auth.forgotYourPassword')?>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</form>
<!-- END Sign In Form -->
<?php $this->endSection(); ?>

<?php $this->section('pageScripts'); ?>
<script src="/dist/assets/js/pages/op_auth_signin.min.js"></script>
<script type="text/javascript" src="https://vk.com/js/api/openapi.js?168"></script>
<script type="text/javascript">
    VK.init({apiId: '<?=$config->vkClientId;?>'});
</script>

<!-- VK Widget -->
<script type="text/javascript">
    VK.Widgets.Auth("vk_auth", {"authUrl":'<?=$config->vkRedirectURL;?>'});
</script>
<?php $this->endSection(); ?>
