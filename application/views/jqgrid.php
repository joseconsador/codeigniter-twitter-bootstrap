<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#jqgrid-table').jqGrid({
            url: '<?=current_url();?>/jqgrid',
            datatype: 'json',
            mtype: 'post',
            colNames: ['<?=implode("','", $column_names);?>'],
            colModel: <?=json_encode($column_model);?>,
            jsonReader : {
                      repeatitems:false
                 },
            rowNum:20,
            rowList:[20,50,100],
            pager: jQuery('#gridpager'),
            sortname: '<?=$default_sort?>',
            viewrecords: true,
            sortorder: "asc",
            height: "100%",
            caption:"<?=$grid_caption;?>",
            multiselect: true,
            editurl: '<?=current_url();?>/action',
            gridComplete: function () {                
                $('input', '.grid_16 .ui-pg-table').width('15px');
                $('select', '.grid_16 .ui-pg-table').width('50px');
            }
        }).navGrid('#gridpager', {add:false});        
    });
</script>

<div class="jqui">
    <?php if (isset($edit_url)):?>
    <a href="<?=$edit_url;?>">Add</a>
    <?php endif;?>
</div>
<div class="clearfix"><br/></div>
<div>    
    <table id="jqgrid-table"></table>
    <div id="gridpager"></div>    
</div>
<div class="clearfix"></div>
