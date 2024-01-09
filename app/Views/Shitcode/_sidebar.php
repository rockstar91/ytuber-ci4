<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <div class="nav-profile">
            <div class="avatar">
                <?php
                if(!empty($user_info->avatar)) {
                    echo '<img src="'.$user_info->avatar.'" alt="" />';
                }
                else {
                    echo '<i class="fa-user fa"></i>';
                }
                ?>
            </div>
            <div class="info">
                <style>
                    div.name > span {
                        display: block;
                        height: 24px;
                        width: 120px;
                        overflow: hidden;
                        float: left;
                    }
                    div.name > .actions {
                        float: right;
                        height: 24px;
                    }
                </style>
                <div class="name">
                    <span title="<?=$user_info->name;?>"><?=mb_substr($user_info->username, 0, 13);?></span>

                    <div class="actions">
                        <a href="<?=site_url('web/user/setting');?>" class="aLink fa fa-gear fa-fw" title="<?php echo lang('Global.tpl_settings'); ?>"></a>
                        <a href="<?=site_url('auth/logout');?>" class="fa fa-sign-out fa-fw" title="<?php echo lang('Global.tpl_exit'); ?>"></a>
                    </div>
                </div>
                <div class="balance">
                    <span id="user_balance"><?php printf("%.2f", $user_info->balance);?></span>
                    <a href="<?=site_url('payment/start');?>" id="ym_pay" class="aLink fa fa-plus-circle fa-fw" style="color: #449d44; font-size: 13px; " title="<?php echo lang('Global.tpl_purchase'); ?>"></a>
                </div>
            </div>
        </div>
        <ul class="nav" id="side-menu">
            <!--<li>
                <a href="index.html"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li> -->
            <li>
                <a href="<?=site_url('dashboard');?>" class="aLink"><i class="fa fa fa-dashboard fa-fw"></i> <?php echo lang('Global.tpl_dashboard'); ?></a>
            </li>
            <li>
                <a href="#" class="aLink"><i class="fa fa-video-camera fa-fw"></i> <?php echo lang('Global.tpl_my_tasks'); ?></a>
                <ul class="nav nav-second-level collapse">
                    <li>
                        <a href="<?=site_url('task/index');?>" class="aLink"><?php echo lang('Global.tpl_task_list'); ?></a>
                    </li>
                    <li>
                        <a href="<?=site_url('task/add');?>" class="aLink"><?php echo lang('Global.tpl_add_task'); ?></a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" class="aLink"><i class="fa fa-eye fa-fw"></i> <?php echo lang('Global.tpl_perform_tasks'); ?></a>
                <ul class="nav nav-second-level collapse">
                    <?php if(false): ?>
                        <li>
                            <a href="<?=site_url('work/view');?>" class="aLink"><?php echo lang('Global.tpl_view'); ?></a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <a href="<?=site_url('work/like');?>" class="aLink"><?php echo lang('Global.tpl_like'); ?></a>
                    </li>
                    <li>
                        <a href="<?=site_url('work/comment');?>" class="aLink"><?php echo lang('Global.tpl_comment'); ?></a>
                    </li>
                    <li>
                        <a href="<?=site_url('work/comment_like');?>" class="aLink"><?php echo lang('Global.tpl_comment_like'); ?> <sup style="color:red;">new</sup></a>
                    </li>
                    <li>
                        <a href="<?=site_url('work/reply');?>" class="aLink"><?php echo lang('Global.tpl_reply'); ?> <sup style="color:red;">new</sup></a>
                    </li>
                    <li>
                        <a href="<?=site_url('work/subscribe');?>" class="aLink"><?php echo lang('Global.tpl_subscribe'); ?></a>
                    </li>
                    <li>
                        <a href="<?=site_url('work/vkshare');?>" class="aLink"><?php echo lang('Global.tpl_vkshare'); ?></a>
                    </li>
                    <li>
                        <a href="<?=site_url('work/twittershare');?>" class="aLink"><?php echo lang('Global.tpl_twittershare'); ?></a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="<?=site_url('work/penalty');?>" class="aLink"><i class="fa fa-exclamation-circle fa-fw"></i> <?php echo lang('Global.tpl_penalty'); ?></a>
            </li>
            <li>
                <a href="<?=site_url('user/referrals');?>" class="aLink"><i class="fa fa-users fa-fw"></i> <?php echo lang('Global.tpl_referrals'); ?></a>
            </li>
            <li>
                <a href="<?=site_url('user/transaction');?>" class="aLink"><i class="glyphicon glyphicon-transfer fa-fw"></i> <?php echo lang('Global.tpl_transactions'); ?></a>
            </li>
            <li>
                <a href="#" class="aLink"><i class="fa fa-rouble fa-fw"></i> <?php echo lang('Global.tpl_payments'); ?></a>

                <ul class="nav nav-second-level collapse">
                    <li>
                        <a href="<?=site_url('payment/start');?>" class="aLink"><?php echo lang('Global.tpl_purchase'); ?><br/><small style="color: gray;">Yandex.Деньги, Visa, Mastercard, Webmoney WMR, Qiwi и д.р.</small></a>
                    </li>
                    <li>
                        <a href="<?=site_url('payment/history');?>" class="aLink"><?php echo lang('Global.tpl_payments_history'); ?></a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="<?=site_url('info/faq');?>" class="aLink"><i class="fa fa-support fa-fw"></i> <?php echo lang('Global.tpl_faq'); ?></a>
            </li>
            <li>
                <a href="<?=site_url('info/rules');?>" class="aLink"><i class="fa fa-book fa-fw"></i> <?php echo lang('Global.tpl_rules'); ?></a>
            </li>
            <?php if(isset($this->user->admin) && $this->user->admin) : ?>
                <li>
                    <a href="<?=site_url('stat');?>" class="aLink"><i class="fa fa-bar-chart-o fa-fw"></i> <?php echo lang('Global.tpl_stat'); ?></a>
                </li>
                <li>
                    <a href="<?=site_url('admin');?>" class="aLink"><i class="fa fa-wrench fa-fw"></i> <?php echo lang('Global.tpl_admin'); ?></a>
                </li>
            <?php endif; ?>

            <li>
                <a href="<?=site_url('promotion');?>"><i class="fa fa-bullhorn fa-fw"></i> <?php echo lang('Global.tpl_promotion'); ?></a>
            </li>

            <li>
                <a href="<?=site_url('payout');?>"><i class="fa fa-money fa-fw"></i> <?php echo lang('Global.tpl_payout'); ?></a>
            </li>
        </ul>

        <div class="nav-share">
            <h5><?php echo lang('Global.tpl_share'); ?></h5>


            <script src="https://yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
            <script src="https://yastatic.net/share2/share.js"></script>
            <div class="ya-share2" data-yasharelink="<?php echo site_url();?>" data-services="vkontakte,facebook,twitter,tumblr,viber,whatsapp,telegram"></div>

            <?php if(false) : ?>
                <script type="text/javascript" src="//yastatic.net/share/share.js" charset="utf-8"></script>
                <div class="yashare-auto-init" data-yasharelink="<?php echo site_url();?>" data-yasharetitle="<?php echo lang('Global.page_title'); ?>" data-yashareL10n="ru" data-yashareType="small" data-yasharetheme="counter" data-yashareQuickServices="vkontakte,facebook,moimir,odnoklassniki,gplus"></div>
            <?php endif; ?>

            <hr/>
            <h5><?php echo lang('Global.tpl_ref_link'); ?></h5>
            <input type="text" class="form-control" name="url" value="<?php echo site_url($user_info->id);?>" onclick="this.select();" />
        </div>

    </div>
    <!-- /.sidebar-collapse -->
