<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed'); ?>

<ul class="breadcrumb">
  <li>
    <a href="<?=site_url('dashboard')?>">Dashboard</a> <span class="divider">/</span>
  </li>
  <li class="active">Suppliers</li>
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
    <?php if (isset($suppliers) && count($suppliers) > 0):?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>                                        
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Date Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($suppliers as $supplier):?>
                <tr>
                    <td><?=$supplier->supplier_id?></td>
                    <td><?=$supplier->name?></td>
                    <td><?=$supplier->address?></td>
                    <td><?=$supplier->contact?></td>                    
                    <td><?=display_datetime($supplier->date_updated)?></td>
                    <td>
                        <a class="btn" href="<?=site_url('suppliers/form/' . $supplier->supplier_id)?>">
                            <i class="icon-edit icon-black"></i> 
                            Edit
                        </a>      
                        <a class="btn btn-danger delete" href="<?=site_url('suppliers/delete/' . $supplier->supplier_id)?>">
                            <i class="icon-trash icon-white"></i> 
                            Delete
                        </a>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>            
        </table>        
        <?php echo $this->pagination->create_links(); ?>        
    <?php endif;?>
    </div>
</div>