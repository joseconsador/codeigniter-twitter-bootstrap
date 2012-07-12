<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed'); ?>

<ul class="breadcrumb">
  <li>
    <a href="<?=site_url('dashboard')?>">Dashboard</a> <span class="divider">/</span>
  </li>
  <li class="active">Staff</li>
</ul>

<div class="row-fluid">
    <div class="span-12">    
        <a class="btn btn-success" href="<?=current_url() . '/form'?>">
            <i class="icon-plus icon-white"></i> 
            Add
        </a>
    </div>
</div>
<div class="row-fluid">
    <div class="span-12">
    <?php if (isset($users) && count($users) > 0):?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                    <th>Branch</th>
                    <th>Date Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user):?>
                <tr>
                    <td><?=$user->user_id?></td>
                    <td><?=$user->firstname?></td>
                    <td><?=$user->lastname?></td>
                    <td><?=$user->username?></td>
                    <td></td>
                    <td><?=display_datetime($user->date_updated)?></td>
                    <td>
                        <a class="btn" href="<?=site_url('staff/form/' . $user->user_id)?>">
                            <i class="icon-edit icon-black"></i> 
                            Edit
                        </a>      
                        <a class="btn btn-danger delete" href="<?=site_url('staff/delete/' . $user->user_id)?>">
                            <i class="icon-trash icon-white"></i> 
                            Delete
                        </a>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
            <tfoot>              
            </tfoot>
        </table>        
        <?php echo $this->pagination->create_links(); ?>        
    <?php endif;?>
    </div>
</div>