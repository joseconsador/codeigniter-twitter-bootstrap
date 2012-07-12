<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<ul class="detail">
    <li>
        <dl>
            <dt>Name</dt>
            <dd><?php echo $name;?></dd>
        </dl>
    </li>
    <li>
        <dl>
            <dt>Markup</dt>
            <dd><?php echo $markup;?></dd>
        </dl>
    </li>
    <li>
        <dl>
            <dt>Use default markup</dt>
            <dd><?php echo ($use_default_markup) ? 'Yes' : 'No';?></dd>
        </dl>
    </li>
    <li>
        <dl>
            <dt>Date updated</dt>
            <dd><?php echo $date_updated;?></dd>
        </dl>
    </li>    
    <li class="submit">
        <input type="button" name="cancel" value="Back to list"/>
        <input type="button" name="modify" value="Modify" jmchref="<?php echo site_url('items/categories/edit/' . $category_id);?>"/>
    </li>
</ul>
<input type="hidden" name="index" value="<?php echo $category_id;?>" />