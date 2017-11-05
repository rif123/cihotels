<table  border="1" width="100%">
		<thead >
			<tr>
				<th>#</th>
				<th><?php echo lang('date'); ?></th>
				<th><?php echo lang('room'); ?></th>
				<th><?php echo lang('floor'); ?></th>
			</tr>
		</thead>
		
		<tbody >
	<?php if($prices):?>		
	<?php $i=1;foreach ($prices as $new):?>
			<tr>
				<td><?php echo $i;?></td>
				<td class="gc_cell_left" ><?php echo  date_convert($new->date); ?></td>
				<td><?php echo  $new->room_no; ?></td>
				<td><?php echo  $new->floor; ?></td>
			</tr>
	<?php $i++; endforeach;?>
	<?php endif ?>
		</tbody>
	</table>