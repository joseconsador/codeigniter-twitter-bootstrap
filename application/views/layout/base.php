<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Tecson Flowers Ordering</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le styles -->
        <link href="<?=css_dir('bootstrap.css')?>" rel="stylesheet">

        <style type="text/css">
            body {
            padding-top: 60px;
            padding-bottom: 40px;
            }

            label.valid {
              width: 24px;
              height: 24px;
              background: url(<?=image_dir('valid.png')?>) center center no-repeat;
              display: inline-block;
              text-indent: -9999px;
            }
            label.error {
                font-weight: bold;
                color: red;                
                padding: 2px 8px;
                margin-top: 2px;
            }
            .error {
                color: red;              
            }            
            
            /* css for timepicker */
            .ui-timepicker-div .ui-widget-header { margin-bottom: 8px; }
            .ui-timepicker-div dl { text-align: left; }
            .ui-timepicker-div dl dt { height: 25px; margin-bottom: -25px; }
            .ui-timepicker-div dl dd { margin: 0 10px 10px 65px; }
            .ui-timepicker-div td { font-size: 90%; }
            .ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; }                 
        </style>
        <link href="<?=css_dir('bootstrap-responsive.css')?>" rel="stylesheet">
        <link href="<?=css_dir('jquery-ui-1.8.16.custom.css')?>" rel="stylesheet">        
        <link type="text/css" rel="stylesheet" href="<?= css_dir('chosen.css'); ?>" />
        
        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Le fav and touch icons -->
        <link rel="shortcut icon" href="../assets/ico/favicon.ico">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
        
        <script src="<?=js_dir('jquery.js')?>"></script>
        <script src="<?=js_dir('jquery/jquery.validate.min.js')?>"></script>
        <script src="<?=js_dir('jquery/jquery-ui-1.8.16.custom.min.js')?>"></script>        
        
        <script type="text/javascript">
            /**
             * Define BASE_URL.
             */            
            var BASE_URL = "<?= base_url(); ?>";    
        </script>
    </head>    
    <body>        
        <div class="navbar navbar-fixed-top">
          <div class="navbar-inner">
            <div class="container-fluid">
              <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </a>
              <a class="brand" href="#">Tecson Flowers</a>
              <div class="btn-group pull-right">
                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                  <i class="icon-user"></i> <?=$this->user->username?>
                  <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li><a href="<?=site_url('auth/logout')?>">Sign Out</a></li>
                </ul>
              </div>
              <div class="nav-collapse">
                <ul class="nav">                    
                    <li <?=isset($dashboard_nav) ? $dashboard_nav : ''?>><a href="<?= site_url('dashboard') ?>">Dashboard</a></li>
                    <li <?=isset($order_nav) ? $order_nav : ''?>><a href="<?= site_url('orders') ?>">Orders</a></li>
                    <li <?=isset($transfers_nav) ? $transfers_nav : ''?>><a href="<?= site_url('items/inventory/transfers') ?>">Transfers</a></li>
                    <?php if ($this->user->is_admin):?>                                        
                    <li class="dropdown <?=isset($catalog_nav) ? 'active' : ''?>">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Catalog</a>
                        <ul class="dropdown-menu">
                            <li><a href="<?= site_url('items/inventory') ?>">Inventory</a></li>
                            <li><a href="<?= site_url('items') ?>">Items</a></li>
                            <li><a href="<?= site_url('items/categories') ?>">Categories</a></li>
                            <li><a href="<?= site_url('items/inventory/spoilages') ?>">Spoilage</a></li>
                            <li><a href="<?= site_url('items/purchasing') ?>">Purchasing</a></li>
                        </ul>
                    </li>                                        
                    <li <?=isset($branch_nav) ? $branch_nav : ''?>><a href="<?= site_url('branches') ?>">Branches</a></li>
                    <li <?=isset($suppliers_nav) ? $suppliers_nav : ''?>><a href="<?= site_url('suppliers') ?>">Suppliers</a></li>
                    <li <?=isset($staff_nav) ? $staff_nav : ''?>><a href="<?= site_url('staff') ?>">Staff</a></li>
                    <?php endif;?>
                </ul>
              </div><!--/.nav-collapse -->
            </div>
          </div>
        </div>

        <div class="container-fluid">            
<!--             <div id="message-div" class="ui-widget">
                <div style="margin-top: 20px; padding: 0pt 0.7em;" class="ui-state-highlight ui-corner-all"> 
                    <p>
                        <span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-info"></span>
                        <strong>Notice:</strong><span id="message-text"></span>
                    </p>
                </div>                                
            </div>  -->           
            <?php if ($this->session->flashdata('message')): ?>     
                <div class="alert alert-success">
                    <strong>Notice:</strong> <?php echo $this->session->flashdata('message');?>
                    <a class="close" href="#" data-dismiss="alert">&times;</a>
                </div>                          
            <?php endif ?>
            <div class="row-fluid">
                <?= $content_for_layout ?>
            </div>
            <hr/>
            <footer>&copy; <?= date('Y') ?> Tecson Flowers</footer>        
        </div>
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="<?=js_dir('validate.js')?>"></script>
        <script type="text/javascript" src="<?= js_dir('jquery/jqueryui.timepicker.addon.js') ?>"></script>        
        <script src="<?=js_dir('scripts.js')?>"></script>
        <script src="<?=js_dir('bootstrap-transition.js')?>"></script>
        <script src="<?=js_dir('bootstrap-alert.js')?>"></script>
        <script src="<?=js_dir('bootstrap-modal.js')?>"></script>
        <script src="<?=js_dir('bootstrap-dropdown.js')?>"></script>
        <script src="<?=js_dir('bootstrap-scrollspy.js')?>"></script>
        <script src="<?=js_dir('bootstrap-tab.js')?>"></script>
        <script src="<?=js_dir('bootstrap-tooltip.js')?>"></script>
        <script src="<?=js_dir('bootstrap-popover.js')?>"></script>
        <script src="<?=js_dir('bootstrap-button.js')?>"></script>
        <script src="<?=js_dir('bootstrap-collapse.js')?>"></script>
        <script src="<?=js_dir('bootstrap-carousel.js')?>"></script>
        <script src="<?=js_dir('bootstrap-typeahead.js')?>"></script>   
        <script src="<?=js_dir('bootbox.min.js')?>"></script>
        <script type="text/javascript" src="<?= js_dir('chosen/chosen/chosen.jquery.min.js') ?>"></script>        
    </body>
</html>