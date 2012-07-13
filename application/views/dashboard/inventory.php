<?php 	
	$inventory = cInventory::getLowInventory();
?>
<?php if (count($inventory->getCollection()) > 0):?>
<table class="table table-condensed">
	<tbody>
	<?php foreach ($inventory->getCollection() as $item):?>
		<tr>
			<td><?=$item->getBranch()->name?> - <?=$item->getItem()->name?></td>			
			<td><?=$item->quantity?></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
<?php endif;?>