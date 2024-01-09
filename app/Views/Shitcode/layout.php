<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php if(isset($pageTitle))  echo $pageTitle; ?></title>

    <link rel="icon" type="image/png" href="/y.png" />

    <!-- Bootstrap Core CSS -->
    <link href="/static/bower/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="/static/bower/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="/static/bower/morrisjs/morris.css" rel="stylesheet">

    <!-- DataTables CSS 
    <link href="/static/bower/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">-->

    <!-- DataTables Responsive CSS 
    <link href="/static/bower/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">-->

    <!-- Custom CSS -->
    <link href="/static/css/sb-admin-2.css?v2" rel="stylesheet">
    <link href="/static/css/custom.css?v7" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/static/bower/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script src="/static/bower/jquery/dist/jquery.min.js"></script>
    
    <?php require_once(APPPATH.'views/_head.php'); ?>


    <script type="text/javascript">
        var LANG_REMOVE_CONFIRM                     = '<?php echo lang('Global.js_remove_confirm'); ?>';
        var LANG_COMPLETE_TASK_AND_CLOSE_WINDOW     = '<?php echo lang('Global.js_complete_task_and_close_window'); ?>';
        var LANG_BROWSER_NOT_ACCEPTED               = '<?php echo lang('Global.js_browser_not_accepted'); ?>';
        var LANG_ALLOW_POPUP                        = '<?php echo lang('Global.js_allow_popup'); ?>';
    </script>
</head>
           
<?php $user_info = user(); ?>
<body>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?=site_url('dashboard');?>"><?php echo lang('Global.logo_text'); ?></a>
                <p class="navbar-desc"></p>
            </div>
            <!-- /.navbar-header -->


            <div class="navbar-header-right">
                <script type="text/javascript">
                function openClient() {
                    window.open("<?=site_url('client');?>", "ytuber_client", "toolbar=no, scrollbars=no, resizable=no, top=50, left=50, width=450, height=615");
                }
                </script>
                <div class="btn btn-success btn-sm" style="margin-right: 10px;" onclick="openClient();">
                    <?php echo lang('Global.tpl_open_client'); ?>
                    <i class="glyphicon glyphicon-new-window" style="margin-left: 3px;"></i>
                </div>
                <?php echo lang('Global.tpl_your_id'); ?> <b><?=$user_info->id;?></b>
            </div>

            <?php require dirname(__FILE__) . '/_sidebar.php'; ?>
            <?php /*
            <ul class="nav navbar-top-links navbar-right">

                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Настройки</a>
                        </li>
                        <li><a href="<?=site_url('user/logout');?>"><i class="fa fa-sign-out fa-fw"></i> Выйти</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
			*/ ?>

    </div>
    <!-- /.navbar-static-side -->
         </nav>

        <!-- Page Content -->
        <div id="page-wrapper"> 
            <div class="content"><!-- container-fluid -->
                <div class="row">
                    <div class="col-lg-12">
                        <?php if(isset($pageTitle)) : ?>
                    	<h1 class="page-header"><?php echo $pageTitle; ?></h1>
                        <?php endif; ?>
						<?php if($success = session()->get('success')) : ?>
							<div class="alert alert-success"><?php echo $success; ?></div>
						<?php endif;?>
						<?php if($error = session()->get('error')) : ?>
							<div class="alert alert-danger"><?php echo $error; ?></div>
						<?php endif;?>

                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->

                <?= $this->renderSection('main') ?>
                
                <?php /*echo $content; */ ?>
                
                <div class="row">
                    <div class="col-lg-12">
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="/static/js/jquery.confirm.min.js"></script>
    <script src="/static/js/history.min.js"></script>

    <!--<link rel="stylesheet" type="text/css" href="/static/js/noty-2.3.8/demo/animate.css"/>-->
    <script src="/static/js/noty-2.3.8/js/noty/packaged/jquery.noty.packaged.js"></script>
    <script src="/static/js/clipboard.min.js"></script>
    <script src="/static/js/custom_new.js?<?=time();?>"></script>
	
    <!-- Bootstrap Core JavaScript -->
    <script src="/static/bower/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="/static/bower/metisMenu/dist/metisMenu.min.js"></script>


    <!-- Morris Charts JavaScript -->
    <script src="/static/bower/raphael/raphael-min.js"></script>
    <script src="/static/bower/morrisjs/morris.min.js"></script>

    <!-- DataTables JavaScript 
    <script src="/static/bower/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="/static/bower/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>-->

    <!-- Custom Theme JavaScript -->
    <script src="/static/js/sb-admin-2.js?1"></script>    

    <!-- Page-Level Demo Scripts - Tables - Use for reference 
    <script>
    $(document).ready(function() {
        $('.dataTable').DataTable({
                responsive: true
        });
    });
    </script>-->

    <!-- Page-Level Demo Scripts - Notifications - Use for reference -->
    <script>
    // tooltip demo
    $('#page-wrapper').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    })

    // popover demo
    //$("[data-toggle=popover]").popover()
    </script>
</body>
</html>