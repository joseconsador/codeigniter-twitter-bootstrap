<div class="grid_5">
    <p>
        <label>Branch</label>
        <?= form_dropdown('branch_id', create_dropdown('branches', 'name'), isset($branch_id) ? $branch_id : '', 'id="branch_id"') ?>
    </p>
</div>
<div class="grid_5">
    <p>
        <label>Staff</label>
        <?= form_dropdown('user_id', create_dropdown('users', 'username'), isset($user_id) ? $user_id : '', 'id="user_id"') ?>
    </p>
</div>