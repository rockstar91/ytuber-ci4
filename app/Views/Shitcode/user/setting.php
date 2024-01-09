<?= $this->extend('Shitcode/layout'); ?>

<?php $this->section('main'); ?>
<?= \Config\Services::validation()->listErrors('list'); ?>

<?php if(isset($success)) : ?>
<div class="alert alert-success">
    <?=implode('<br/>', $success);?>
</div>
<?php endif; ?>

<?=form_open('web/user/setting'); ?>
    <div class="form-group">
        <label for="name"><?=lang('User.name');?></label>
        <input type="text" class="form-control" name="name" value="<?=set_value('name', $user->username);?>" placeholder="" />
    </div>
    <!--
    <div class="form-group">
        <label for="channel">YouTube-канал</label>
        <input type="text" class="form-control" name="channel" value="<?=set_value('channel', $user->channel);?>" placeholder="" />
    </div> 
    -->
    <div class="form-group">
        <label for="password"><?=lang('User.password');?></label>
        <input type="password" class="form-control" name="password" value="" placeholder="" />
        <p><?=lang('User.password_tip');?></p>
    </div>
    <div class="form-group">
        <label for="password_confirm"><?=lang('User.password_confirm');?></label>
        <input type="password" class="form-control" name="password_confirm" value="" placeholder="" />
    </div>
    <div class="form-group">
        <label for="password_confirm"><?=lang('User.api_key');?></label>
        <input type="text" class="form-control" name="api_key" style="cursor: text; background: #F3F3F3;" value="<?=htmlspecialchars($user->api_key);?>" placeholder="" onclick="this.select();" />
        <div>
            <input type="checkbox" name="api_key_generate" value="1" placeholder="" />
            <span><?=lang('User.api_key_tip');?></span>
        </div>
    </div>
    <div class="form-group">
        <label><?=lang('User.sub_title');?></label>
        <div>
            <input type="checkbox" name="sub_news" <?=set_checkbox('sub_news', 1, (bool)$user->sub_news);?> value="1" placeholder="" />
            <span><?=lang('User.sub_news');?></span>
        </div>
        <div>
            <input type="checkbox" name="sub_transaction" <?=set_checkbox('sub_transaction', 1, (bool)$user->sub_transaction);?> value="1" placeholder="" />
            <span><?=lang('User.sub_transaction');?></span>
        </div>
        <div>
            <input type="checkbox" name="sub_statistic" <?=set_checkbox('sub_statistic', 1, (bool)$user->sub_statistic);?> value="1" placeholder="" />
            <span><?=lang('User.sub_statistic');?></span>
        </div>
        <div>
            <input type="checkbox" name="sub_notification" <?=set_checkbox('sub_notification', 1, (bool)$user->sub_notification);?> value="1" placeholder="" />
            <span><?=lang('User.sub_other');?></span>
        </div>
    </div>

    <?php if($user->confirm != '') : ?>
    <div class="form-group">
        <input type="checkbox" name="resend_confirm" value="1" placeholder="" />
        <span><?=lang('User.resend_confirm');?></span>
    </div>
    <?php endif; ?>

    <div class="form-group">
        <label for="soc_youtube">YouTube</label>
        <?php if(isset($channel)) : ?>
        <input type="text" class="form-control" name="soc_youtube" value="<?=set_value('soc_youtube', $channel);?>" placeholder="" disabled="disabled" />
        <?php else : ?>
        <p>YouTube-аккаунт не привязан. <?php echo anchor('auth/google', 'Привязать аккаунт') ?></p>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <label for="soc_vk">VK</label>
        <input type="text" class="form-control" name="soc_vk" value="<?=set_value('soc_vk', $user->soc_vk);?>" placeholder="https://vk.com/id123" />
    </div>
    <div class="form-group">
        <label for="soc_twitter">Twitter</label>
        <input type="text" class="form-control" name="soc_twitter" value="<?=set_value('soc_twitter', $user->soc_twitter);?>" placeholder="https://twitter.com/username" />
    </div>

    <?php if(false) : ?>
    <div class="form-group">
        <label for="soc_fb">Facebook</label>
        <input type="text" class="form-control" name="soc_fb" value="<?=set_value('soc_fb', $user->soc_fb);?>" placeholder="https://www.facebook.com/username" />
    </div>
    <?php endif; ?>

    <div class="form-group">
        <input type="submit" class="btn btn-default" value="<?=lang('User.save');?>" />
    </div>
</form>
<?php $this->endSection(); ?>