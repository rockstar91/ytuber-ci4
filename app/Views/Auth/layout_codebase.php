<?= $this->extend('App\Views\layout_codebase'); ?>

<?= $this->section('main'); ?>
<!-- Page Content -->
<div class="bg-body-dark bg-pattern" style="background-image: url('/dist/assets/media/various/bg-pattern-inverse.png');">
    <div class="row mx-0 justify-content-center">
        <div class="hero-static col-lg-6 col-xl-4">
            <div class="content content-full overflow-hidden">

                <!-- Header -->
                <div class="py-30 text-center">
                    <a class="link-effect font-w700" href="<?=route_to('index');?>">
                        <?= view('App\Views\_logo'); ?>
                        <?php if(false) : ?>
                            <span class="font-size-xl text-dual-primary-dark">YT</span><span class="font-size-xl text-primary">UBER</span>
                        <?php endif; ?>
                    </a>
                    <h1 class="h3 font-w500 mt-30 mb-10">
                        <?= isset($headerWelcomeTitle) ? $headerWelcomeTitle : lang('Auth.headerWelcomeTitle'); ?>
                    </h1>
                    <h2 class="h6 font-w300 text-muted mb-0">
                        <?= isset($headerWelcomeSub) ? $headerWelcomeSub : lang('Auth.headerWelcomeSub'); ?>
                    </h2>
                </div>
                <!-- END Header -->

                <?= $this->renderSection('main'); ?>

            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->
<?php $this->endSection(); ?>

<?php $this->section('pageScripts'); ?>
<!-- Page JS Plugins -->
<script src="/dist/assets/js/plugins/jquery-validation/jquery.validate.min.js"></script>

<!-- Page JS Code -->
<?= $this->renderSection('pageScripts'); ?>

<?php $this->endSection(); ?>

