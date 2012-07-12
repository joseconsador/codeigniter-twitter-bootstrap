<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed'); ?>

<ul class="breadcrumb">
  <li>
    <a href="<?=site_url('dashboard')?>">Dashboard</a> <span class="divider">/</span>
  </li>
  <li class="active">Branches</li>
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
    <?php if (isset($branches) && count($branches) > 0):?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Location</th>       
                    <th>Date Udpated</th>
                    <th width="15%">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($branches as $branch):?>
                <tr>
                    <td><?=$branch->branch_id?></td>
                    <td><?=$branch->name?></td>
                    <td><?=$branch->location?></td>
                    <td><?=display_datetime($branch->date_updated)?></td>
                    <td>
                        <a class="btn" href="<?=site_url('branches/form/' . $branch->branch_id)?>">
                            <i class="icon-edit icon-black"></i> 
                            Edit
                        </a>      
                        <a class="btn btn-danger delete" href="<?=site_url('branches/delete/' . $branch->branch_id)?>">
                            <i class="icon-trash icon-white"></i> 
                            Delete
                        </a>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
            </tbody>
            <tfoot>              
            </tfoot>
        </table>        
        <?php echo $this->pagination->create_links(); ?>        
    <?php endif;?>
    </div>
</div>