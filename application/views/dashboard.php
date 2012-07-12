<!--script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">google.load("visualization", "1", {packages:["corechart"]});</script>
<script type="text/javascript" src="<?js_dir('dashboard.js')?>"></script-->
 
<div class="grid_5">
	<div class="box">
		<h2><?=$this->user->firstname?></h2>
		<p>
			<strong>Last Signed In : </strong> <?=date('D M/d/Y, H:i a', strtotime($this->user->last_signed_in));?>
			<br /><strong>IP Address : </strong> <?=$this->input->ip_address()?></p>
	</div>
	<div class="box">
		<h2>Last 5 Sales</h2>
		<div class="utils">
			<?=anchor('orders', 'View More');?>
		</div>		
		<?$this->load->view('dashboard/orders')?>
	</div>	
	<div class="box">
		<h2>Low Inventory</h2>
		<div class="utils">
			<?=anchor('items/inventory', 'View More');?>
		</div>		
		<?$this->load->view('dashboard/inventory')?>
	</div>		
</div>

<div class="grid_11">
	<div class="box">
		<h2>Sales</h2>
		<p>
			<label for="branch_id">Branch</label>
			<?php 
			$branches = create_dropdown('branches', 'name');
			$branches[''] = 'All';
			?>
			<?php echo form_dropdown('branch_id', $branches);?>

			<label for="date_range">Range</label>
			<select name="date_range">
				<option value="1">This month</option>
				<option value="2">Last 30 days</option>
				<option value="3">Last 2 months</option>
				<option value="4">Last 6 months</option>
				<option value="5">1 year</option>
				<option value="6">2 years</option>
			</select>

			<div id="sales_chart_div"></div>
		</p>
	</div>
</div>