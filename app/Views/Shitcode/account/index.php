<?php if(validation_errors()) : ?>
<div class="alert alert-danger">
    <?=validation_errors(); ?>
</div>
<?php endif; ?>
<?php if(isset($success)) : ?>
<div class="alert alert-success">
    <?=$success;?>
</div>
<?php endif; ?>

<div class="table-responsive">
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>Link</th>
            <th>Social system</th>
            <th>Status</th>
            <th>Manage</th>
        </tr>
    </thead>
    <tbody>
    <?php if($accounts) : ?> 
    <?php foreach($accounts as $item) : ?>
        <tr>
            <td><a href="<?php echo $item->url; ?>" target="_blank"><?php echo $item->url; ?></a></td>
            <td><?php echo $item->type; ?></td>
            <td>
            <?php 
            if($item->status == $this->Account::USER_ACCOUNT_WAITING) {
                echo 'Ожидает модерации';
            }
            elseif($item->status == $this->Account::USER_ACCOUNT_FAILED) {
                echo 'Не прошла модерацию';
            }
            elseif($item->status == $this->Account::USER_ACCOUNT_ACTIVE) {
                echo 'Активна';
            }
            ?>
            </td>
            <td>
                <a href="<?=site_url('account/remove/'.$item->id);?>" class="btn btn-danger btn-circle" title="Удалить аккаунт"><i class="glyphicon glyphicon-remove"></i></a>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php else : ?>
        <tr><td colspan="4" style="text-align: center;">Нет привязанных соц. сетей.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
</div>


<h4>Добавить соц. сеть</h4>

<?=form_open('account'); ?>
    <div class="row">
        <div class="form-group col-sm-3">
            <input type="text" class="form-control" name="url" value="" placeholder="Ссылка на страницу" />
        </div>
        <?php if($types) : ?>
        <div class="form-group col-sm-2">
            <select class="form-control" name="account_type_id" id="account_type_id">
                <option value="0">- Select account type -</option>
                <?php foreach ($types as $type) : ?>
                <?php if($this->Account->countAccounts($this->user->id, $type->id) > 0) continue; ?>
                <option value="<?=$type->id;?>" <?=set_select('account_type_id', $type->id);?>><?php echo $type->name;?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php endif; ?>
    </div>

    <div class="row">
        <div class="form-group col-sm-3">
            <input type="submit" class="btn btn-success" value="Добавить аккаунт" />
        </div>
    </div>
</form>