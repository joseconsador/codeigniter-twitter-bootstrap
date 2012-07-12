<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed'); ?>

<ul class="breadcrumb">
  <li>
    <a href="<?=site_url('dashboard')?>">Dashboard</a> <span class="divider">/</span>
  </li>
  <li class="active">Items</li>
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
                    <label class="control-label" for="name">Item Name</label>
                        <div class="controls">
                            <input type="text" class="input-xlarge" name="name" id="name" value="<?php echo isset($name) ? $name : '';?>" />
                        </div>
                </div>       
                <div class="control-group">
                    <label class="control-label" for="item_code">Category</label>
                        <div class="controls">
                            <?=form_dropdown('category_id', create_dropdown('categories', 'name'), 'placeholder="Category"')?>
                        </div>
                </div>             
                <div class="control-group">
                    <label class="control-label" for="qty_type">Price</label>
                        <div class="controls">
                            <?=form_dropdown('qty_type', array(
                                    'eq'  => 'Equal to', 
                                    'gt'  => 'Greater than', 
                                    'gte' => 'Greater than or equal to',
                                    'lt'  => 'Less than',
                                    'lte' => 'Less than or equal to'
                                    ),
                                    set_value('qty_type')
                                );
                                ?>                            
                            <input type="text" name="price" class="number" value="<?=set_value('price');?>" />                                
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
    <?php if (isset($items) && count($items) > 0):?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Category</th>
                    <th>Initial Cost</th>
                    <th>Markup</th>
                    <th>Use Default Markup</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($items as $item):?>
                <tr>
                    <td><?=$item->item_id?></td>
                    <td><?=$item->name?></td>
                    <td><?=$item->item_code?></td>
                    <td><?=$item->category?></td>
                    <td><?=$item->initial_cost?></td>
                    <td><?=$item->markup?></td>
                    <td ><?=($item->use_default_markup) ? 'Yes' : 'No'?></td>
                    <td>
                        <a class="btn" href="<?=site_url('items/form/' . $item->item_id)?>">
                            <i class="icon-edit icon-black"></i> 
                            Edit
                        </a>                                             
                       <a class="btn btn-danger delete" href="<?=site_url('items/delete/' . $item->item_id)?>">
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

<script type="text/javascript">  
    $(document).ready(function () {
        $(".collapse").collapse({toggle: false});
    });
</script>