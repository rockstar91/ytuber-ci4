<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html> <!--<![endif]-->
<head>
	<meta charset="utf-8"/>
	<title><?= lang('Main.page_title'); ?></title>
	<meta name="verification" content="2a41995647dd010a9c02e976505083" />
	<meta name="description" content="<?= lang('Main.meta_description'); ?>"/>
	<meta name="keywords" content="<?= lang('Main.meta_keywords'); ?>" />
	<meta name="author" content="Ytuber"/>
	<meta name="resourse-type" content ="Document"/>
	<meta http-equiv="expires" content=""/>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta http-equiv="content-language" content="<?= lang('Main.meta_lang'); ?>"/>
	<meta name="robots" content="index,follow"/>
	<meta name="revisit-after" content="1 days"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta property="og:image" content="<?=site_url('/static/index/ytuber.png');?>"/>

    <?php $json = json_decode(file_get_contents($config->googleConfigPath)); ?>
    <meta name="google-signin-client_id" content="<?= $json->web->client_id; ?>">

	<link rel="shortcut icon" href="/favicon.ico" />
    <?php /*
	<link rel="shortcut icon" href="img/favicon.ico">
	<link rel="apple-touch-icon" href="img/apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="144x144" href="img/apple-touch-icon-144x144.png">
	<!--
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Raleway:400,100,200,300,500,600,700,800,900' rel='stylesheet' type='text/css'>
	-->*/ ?>

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Raleway:400,100,200,300,500,600,700,800,900' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="/static/index/bootstrap.min.css">
	<link rel="stylesheet" href="/static/index/main.min.css?v1">

	<?php if($_SERVER['HTTP_HOST'] == 'ytuber.ru') { ?>
	  <link rel="stylesheet" type="text/css" href="/static/index/slick/slick.css">
	  <link rel="stylesheet" type="text/css" href="/static/index/slick/slick-theme.css">
	<?php } ?>
	<!--[if lt IE 9]>
      	<script src="./js/html5shiv.js"></script>
	    <script src="./js/respond.js"></script>
	<![endif]-->
	<script src="/static/index/modernizr.custom.js" async></script>
	
	<?php require_once('_head.php'); ?>

	<style>
	.grecaptcha-badge {display: none;}
	</style>
<script src="//code-ya.jivosite.com/widget/ByNz0yKIb7" async></script>
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top header" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand logo" id="logo" href="<?php echo route_to('index'); ?>" title="<?= lang('Main.logo_title'); ?>"><?= lang('Main.logo_text'); ?></a>
			
		</div>
		<div class="collapse navbar-collapse navbar-right navbar-ex1-collapse">
			<ul class="nav navbar-nav">
				<li><a href="#login" class="active"><span><?php if($user) {echo lang('Main.account');} else {echo lang('Main.login');} ?></span></a></li>
				<li><a href="#about"><span><?= lang('Main.about_us'); ?></span></a></li>
			</ul>
		</div>
	</div>
</nav>

<script>
function submitLoginForm() {
    document.getElementById("loginForm").submit();
}
</script>

<style>
    .login-form p a {
        text-transform: uppercase;
        font-weight: bold;
        text-shadow: 1px 1px 0px #000;
    }
</style>

<a id="login" class="anchor"></a>
<div class="top-header">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<div class="top-message">
					<?= lang('Main.header_h1'); ?>
					<hr class="top-divider"><br />
					<?= lang('Main.header_description'); ?>
				</div>
			</div>
			<div class="col-sm-6">
					<?php if($user) : ?>
						<div class="login-form">
							<h3><?=$user->email?> <small><?=anchor('auth/logout', lang('Main.logout'));?></small></h3>
							<h4><?= lang('Main.your_balance'); ?> <?=$user->balance;?></h4>
							<p><?=anchor('dashboard', lang('Main.go_to_dashboard'), 'class="btn1 btn-7 btn-7a"'); ?><p>
						</div>
					<?php else: ?>
					<?php echo form_open('auth/signin', 'class="login-form" id="loginForm"'); ?>
							<div class="row">
								<input id="email" name="login" class="form-control" type="email" placeholder="<?= lang('Main.email'); ?>"/>
							</div>

							<div class="row">
								<input id="password" name="password" class="form-control" type="password" placeholder="<?= lang('Main.password'); ?>"/>
							</div>
							<p><?=anchor('auth/signup', lang('Main.singup')); ?><p>
							<p><?=anchor('auth/forgot', lang('Main.forgot')); ?><p>
							
							<div class="row">							
								<div class="col-sm-4 legend">
									<button type="submit" data-sitekey="" data-callback="submitLoginForm" class="g-recaptcha btn1 btn-7 btn-7a" style="padding: 11px 25px; margin: 0;"><?= lang('Main.login_btn'); ?></button>
								</div>

								<div class="col-sm-8 legend">

									  <div id="my-signin2"></div>
									  <script>
									    function onSuccess(googleUser) {
									      console.log('Logged in as: ' + googleUser.getBasicProfile().getName());
									    }
									    function onFailure(error) {
									      console.log(error);
									    }
									    function renderButton() {
									      gapi.signin2.render('my-signin2', {
									        'scope': 'profile email',
									        'width': 240,
									        'height': 50,
									        'longtitle': true,
									        'theme': 'dark',
									        'onsuccess': onSuccess,
									        'onfailure': onFailure,
									        'ux_mode': 'redirect',
									        'redirect_uri': '<?=site_url('auth/googleLogin');?>'
									      });
        								
									    }
									  </script>

									  <script src="https://apis.google.com/js/platform.js?hl=ru&onload=renderButton" async defer></script>
								</div>
							</div>
					</form>
					<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<a id="about" class="anchor"></a>

<style>
 .capability {padding: 40px 0;}
 .capability .col-sm-6 {margin-bottom: 15px;}
 .capability img {float: left; margin-right: 15px; margin-top: 5px; opacity: 0.9;}
 .capability h4, .capability p.lead {margin-left: 75px;}
</style>

<div class="wrap-content wrap-content1 capability">
	<div class="container">
				<div class="clearfix"></div>
				<h2><?= lang('Main.features'); ?></h2>
		<div class="row">
			<div class="col-sm-6">
				<img src="/static/index/icon_view.png" width="60" alt="<?= lang('Main.view_alt'); ?>" />
				<h4><?= lang('Main.view_title'); ?></h4>
				<p class="lead"><?= lang('Main.view_desc'); ?></p>
				<div class="clearfix"></div>
			</div>
			<div class="col-sm-6">
				<img src="/static/index/icon_like.png" width="60" alt="<?= lang('Main.like_alt'); ?>" />
				<h4><?= lang('Main.like_title'); ?></h4>
				<p class="lead"><?= lang('Main.like_desc'); ?></p>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<img src="/static/index/icon_comment.png" width="60" alt="<?= lang('Main.comment_alt'); ?>" />
				<h4><?= lang('Main.comment_title'); ?></h4>
				<p class="lead"><?= lang('Main.comment_desc'); ?></p>
				<div class="clearfix"></div>
			</div>
			<div class="col-sm-6">
				<img src="/static/index/icon_subscribe.png" width="60" alt="<?= lang('Main.subscribe_alt'); ?>" />
				<h4><?= lang('Main.subscribe_title'); ?></h4>
				<p class="lead"><?= lang('Main.subscribe_desc'); ?></p>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<img src="/static/index/icon_replies.png" width="60" alt="<?= lang('Main.replies_alt'); ?>" />
				<h4><?= lang('Main.replies_title'); ?></h4>
				<p class="lead"><?= lang('Main.replies_desc'); ?></p>
				<div class="clearfix"></div>
			</div>
			<div class="col-sm-6">
				<img src="/static/index/icon_comment_like.png" width="60" alt="<?= lang('Main.comment_like_alt'); ?>" />
				<h4><?= lang('Main.comment_like_title'); ?></h4>
				<p class="lead"><?= lang('Main.comment_like_desc'); ?></p>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>

<div class="wrap-content" style="background: #e42b28; padding: 20px 0;">
	<div class="container">
		<div class="row">
			<div class="col-sm-5">
				<img class="img-responsive" src="<?= lang('Main.bonus_img_src'); ?>" alt="<?= lang('Main.bonus_img_alt'); ?>" style="width: 80%; margin: 0 auto;" />
			</div>
			<div class="col-sm-7">
				<hr class="heading-spacer">
				<div class="clearfix"></div>
				<h2><?= lang('Main.bonus_title'); ?></h2>
				<p class="lead"><?= lang('Main.bonus_desc_1'); ?></p>
				<p class="lead"><?= lang('Main.bonus_desc_2'); ?></p>
				<p class="lead"><?= lang('Main.bonus_desc_3'); ?></p>
			</div>
		</div>
	</div>
</div>

<div class="wrap-content wrap-content1">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<hr class="heading-spacer">
				<div class="clearfix"></div>
				<h2><?= lang('Main.ref_title'); ?></h2>
				<p class="lead"><?= lang('Main.ref_desc_1'); ?></p>
				<p class="lead"><?= lang('Main.ref_desc_2'); ?></p>
			</div>
			<div class="col-sm-6">
				<img class="img-responsive" src="/static/index/referaly.jpg" alt="">
			</div>
		</div>
	</div>
</div>


<footer>
	<div class="container">
		<div class="row">
			<div class="col-lg-12">

                <div class="yashare" style="text-align: center; margin-bottom: 15px;">
                    <script src="https://yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                    <script src="https://yastatic.net/share2/share.js"></script>
                    <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,twitter,tumblr,viber,whatsapp,telegram"></div>
                </div>

				<ul class="list-inline">
					<li><a href="#login"><?= lang('Main.login'); ?></a></li>
					<li>&sdot;</li>
					<li><a href="#about"><?= lang('Main.about_us'); ?></a></li>
					<li>&sdot;</li>
					<li><a href="/policy.html"><?= lang('Main.policy'); ?></a></li>
				</ul>
				<p class="copyright text-center medium">Copyright &copy; <?=anchor('https://ytuber.ru/', 'YTuber.ru');?> 2013-<?=date('Y');?>. All Rights Reserved</p>
			</div>
		</div>
	</div>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="/static/index/jquery.form.min.js"></script>
<script src="/static/bower/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/static/index/main.js?v8"></script>
</body>
</html>