<?php 	
	$this->db->select('order.order_id,order.grand_total, branch.name');
	$this->db->order_by('order.date_created', 'desc');
	$this->db->limit(5);
	$this->db->join('branches branch', 'branch.branch_id = order.branch_id');	
	$this->db->from('order');
	$orders = $this->db->get();
?>
<?php if ($orders->num_rows() > 0):?>
<table class="table table-condensed">
	<tbody>
	<?php foreach ($orders->result() as $order):?>
		<tr style="cursor:pointer" onclick="window.location = '<?=site_url('/orders/view/' . $order->order_id)?>'">
			<td><?=$order->name?></td>
			<td>PHP<?=number_format($order->grand_total, 2)?></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
<?php endif;?>