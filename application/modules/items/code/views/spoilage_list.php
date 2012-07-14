<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed'); ?>

<ul class="breadcrumb">
  <li>
    <a href="<?=site_url('dashboard')?>">Dashboard</a> <span class="divider">/</span>
  </li>
  <li class="active">Spoilages</li>
</ul>

<div class="row-fluid">
    <div class="span-12">    
        <a class="btn btn-success" href="<?=current_url() . '/form'?>">
            <i class="icon-plus icon-white"></i> 
            Add
        </a>
        <a class="btn" href="#filters" data-toggle="collapse"><i class="icon-plus icon-black"></i> Filters</a>
    </div>
</div>

<div id="filters" class="collapse">    
    <div class="span-12">
        <form class="well form-inline require-validation">
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="created_by">Staff</label>
                        <div class="controls">
                            <?=form_dropdown('created_by', create_dropdown('user_model', 'firstname,lastname'))?>
                        </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="created_by">Branch</label>
                        <div class="controls">
                            <?=form_dropdown('branch_id', create_dropdown('branches', 'name'),set_value('branch_id'));?>
                        </div>
                </div>  
                <button type="submit" class="btn"><i class="icon-search icon-black"></i> Search</button>  
            </fieldset>   
            <input type="hidden" name="search" value="1" />        
        </form>
    </div>
</div>

<div class="row-fluid">
    <div class="span12">
    <?php if (isset($spoilages) && count($spoilages) > 0):?>
        <table class="table table-stiped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Branch</th>
                    <th>Item</th>
                    <th>Staff</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Date Created</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($spoilages as $spoilage):?>
                <tr>
                    <td><?=$spoilage->item_inventory_spoilage_id?></td>
                    <td><?=$spoilage->getBranch()->name?></td>
                    <td><?=$spoilage->getItem()->getItem()->name?></td>
                    <td><?=$spoilage->getStaff()->getFullName()?></td>
                    <td><?=$spoilage->quantity?></td>
                    <td><?=$spoilage->amount?></td>
                    <td><?=$spoilage->getDateCreated();?>
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