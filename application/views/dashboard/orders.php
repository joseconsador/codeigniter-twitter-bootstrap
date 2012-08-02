<?php 				
	$orders = new tCollection('cOrder', cOrder::getModel()->fetch_all(5)->result());
	$orders = $orders->getCollection();
?>
<?php if (count($orders) > 0):?>
<table class="table table-condensed">
	<tbody>
	<?php foreach ($orders as $order):?>
		<tr style="cursor:pointer" onclick="window.location = '<?=site_url('/orders/view/' . $order->order_id)?>'">
			<td><?=$order->getBranch()->name?></td>
			<td>PHP<?=number_format($order->grand_total, 2)?></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
<?php endif;?>