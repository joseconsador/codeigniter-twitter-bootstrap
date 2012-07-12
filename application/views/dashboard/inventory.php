<?php 	
	$inventory = cInventory::getLowInventory();
?>
<?php if (count($inventory->getCollection()) > 0):?>
<table>
	<tbody>
	<?php foreach ($inventory->getCollection() as $item):?>
		<tr>
			<td><?=$item->getItem()->name?></td>
			<td><?=$item->quantity?></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
<?php endif;?>