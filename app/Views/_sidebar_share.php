<div class="nav-share" style="padding: 18px;">

    <h6>Share</h6>

    <script src="https://yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
    <script src="https://yastatic.net/share2/share.js"></script>
    <div class="ya-share2" data-yasharelink="<?php echo site_url();?>" data-services="vkontakte,facebook,twitter,tumblr,viber,whatsapp,telegram"></div>

    <div style="margin-top: 10px;">
        <input type="text" class="form-control" name="url" value="<?php echo site_url($user->id);?>" onclick="this.select();" />
    </div>
</div>
