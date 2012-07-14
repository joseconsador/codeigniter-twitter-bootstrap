<div class="control-group">
    <label class="control-label" for="branch_id">Branch</label>
    <div class="controls">
        <?= form_dropdown('branch_id', create_dropdown('branches', 'name'), isset($branch_id) ? $branch_id : '', 'id="branch_id"') ?>
    </div>
</div>   

<div class="control-group">
    <label class="control-label" for="user_id">Staff</label>
    <div class="controls">
        <?= form_dropdown('user_id', create_dropdown('users', 'username'), isset($user_id) ? $user_id : '', 'id="user_id"') ?>
    </div>
</div>