<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed'); ?>

<ul class="breadcrumb">
  <li>
    <a href="<?=site_url('dashboard')?>">Dashboard</a> <span class="divider">/</span>
  </li>
  <li class="active">Categories</li>
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
    <?php if (isset($categories) && count($categories) > 0):?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>                    
                    <th>Markup</th>
                    <th>Use Default Markup</th>
                    <th>Date Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($categories as $category):?>
                <tr>
                    <td><?=$category->category_id?></td>
                    <td><?=$category->name?></td>                    
                    <td><?=$category->markup?></td>
                    <td><?=($category->use_default_markup) ? 'Yes' : 'No'?></td>
                    <td><?=display_datetime($category->date_updated)?></td>
                    <td>
                        <a class="btn" href="<?=site_url('items/categories/form/' . $category->category_id)?>">
                            <i class="icon-edit icon-black"></i> 
                            Edit
                        </a>      
                        <a class="btn btn-danger delete" href="<?=site_url('items/categories/delete/' . $category->category_id)?>">
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