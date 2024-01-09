<?= $this->extend('Shitcode/layout'); ?>

<?= $this->section('main') ?>
<div class="panel panel-info">
    <div class="panel-heading">
        <i class="fa fa-info-circle fa-1x"></i>
        <?php echo lang('Task.list_info'); ?>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>

            <th style="width: 50px;"></th>
            <th><?php echo lang('Task.name'); ?></th>
            <th><?php echo lang('Task.type'); ?></th>
            <th><?php echo lang('Task.total_cost'); ?></th>
            <th><?php echo lang('Task.action_cost'); ?></th>
            <th><?php echo lang('Task.complete_penalty'); ?></th>
            <th><?php echo lang('Task.manage'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php if ($results) : ?>
            <?php foreach ($results as $item) : ?>
                <tr<?php if ($item->total_cost < $item->action_cost) {
                    echo ' class="done"';
                } else if ($item->disabled) {
                    echo ' class="warning danger"';
                } ?>>


                    <?php $vid = yt_vid($item->url); ?>

                    <?php if (isset($item->youtube_extend['thumbnail'])) : ?>
                        <td>
                            <a href="https://www.google.com/url?sa=t&rct=j&q=&esrc=s&source=web&cad=rja&url=<?php echo $item->url; ?>" target="_blank">
                                <img src="<?php echo $item->youtube_extend['thumbnail']; ?>" alt="" width="60" />
                            </a>
                        </td>

                    <?php elseif ($vid) : ?>
                        <td>
                            <a href="https://www.google.com/url?sa=t&rct=j&q=&esrc=s&source=web&cad=rja&url=<?php echo $item->url; ?>" target="_blank">
                                <img src="https://img.youtube.com/vi/<?= $vid; ?>/default.jpg" alt="" width="60" />
                            </a>
                        </td>
                    <?php endif; ?>

                    <td>
                        <a href="https://www.google.com/url?sa=t&rct=j&q=&esrc=s&source=web&cad=rja&url=<?php echo $item->url; ?>"
                           target="_blank"><?php echo $item->name; ?></a>
                        <p style="margin: 0;"><?php echo $item->category; ?></p>
                    </td>
                    <td><?php echo $item->type; ?></td>
                    <td><?php printf('%.2f', $item->total_cost); ?></td>
                    <td><?php printf('%.2f', $item->action_cost); ?></td>
                    <td>
                        <?php
                        $action_done = $item->action_done - $item->action_fail - $item->action_refund;
                        $action_total = floor($item->total_cost / $item->action_cost) + $action_done;
                        echo $action_done . '&nbsp;/&nbsp;' . $action_total;
                        ?>
                        <?php if ($item->action_fail > 0) : ?>
                            <i class="fa fa-exclamation-circle fa-fw" data-toggle="tooltip" data-placement="right"
                               title=""
                               data-original-title="<?php printf(lang('Task.penalty_tip'), $item->action_fail, $item->action_fail * $item->action_cost); ?>"></i>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php echo anchor('task/edit/' . $item->id, '<i class="fa fa-pencil"></i>', 'class="btn btn-success btn-circle" title="' . lang('Task.edit') . '"'); ?>

                        <a href="/task/remove/<?php echo $item->id; ?>" class="btn btn-danger btn-circle"
                           onclick="return YT_ConfirmDelete();" title="<?php echo lang('Task.remove'); ?>"><i
                                    class="glyphicon glyphicon-remove"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="7" style="text-align: center;"><?php echo lang('Task.no_task'); ?></td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<div>
    <?php echo anchor('task/add', lang('Task.add_task'), 'class="btn btn-success"'); ?>
</div>

<?php $this->endSection(); ?>