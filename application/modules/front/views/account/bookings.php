<link href="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css" />

<!-- breadcrumbs -->
<div class="services-top-breadcrumbs">
	<div class="container">
		<div class="services-top-breadcrumbs-right">
			<ul>
				<li><a href="<?php echo site_url()?>">Home</a> <i>/</i></li>
				<li><?php echo lang('my_bookings')?></li>
			</ul>
		</div>
		<div class="services-top-breadcrumbs-left">
			<h3><?php echo lang('my_bookings')?></h3>
		</div>
		<div class="clearfix"> </div>
	</div>
</div>
<!-- //breadcrumbs -->


<div class="testimonials">
    <div class="container">
        <div class="row">
			<h3><span><?php echo lang('my_bookings')?></span></h3>
			<div class="panel-body margin-40-y">
			     <table class="table table-striped" id="example1">
					<thead class="header-panal" >
						<tr  >
							<th>#</th>
							<th><?php echo lang('order_number'); ?></th>
							<th><?php echo lang('booking_date'); ?></th>
							<th><?php echo lang('room'); ?></th>
							<th><?php echo lang('check_in'); ?></th>
							<th><?php echo lang('check_in'); ?></th>
							<th><?php echo lang('payment'); ?></th>
							<th><?php echo lang('booking_status'); ?></th>
							<th class="col-md-3"><?php echo lang('action'); ?></th>
						</tr>
					</thead>
					<tbody >
        				<?php if($bookings):?>		
        				<?php $i=1;foreach ($bookings as $new):?>
        						<tr>
        							<td><?php echo $i;?></td>
        							<td class="gc_cell_left" ><?php echo  @$new->order_no; ?></td>
        							<td><?php echo  date_time_convert($new->ordered_on); ?></td>
        							<td><?php echo  $new->room_type; ?></td>
        							<td><?php echo  date_convert($new->check_in); ?></td>
        							<td><?php echo  date_convert($new->check_out); ?></td>
        							<td id="<?php echo $new->id?>"><?php echo ($new->payment_status==1)?lang('success'):''?> <?php echo ($new->payment_status==2)?lang('pending'):''?><?php echo ($new->payment_status==0)?lang('failed'):'';?> <?php echo ($new->payment_status==3)?lang('partialy_paid'):'';?></td>
        							<td id="<?php echo $new->id?>"><?php echo ($new->status==1)?lang('success'):''?> <?php echo ($new->status==2)?lang('canceled'):''?><?php echo ($new->status==0)?lang('pending'):'';?> </td>
        							<td>
        								<div class="btn-group" style="float:right">
        									<?php if($new->status!=2){?>
        									<a class="btn btn-theme" href="<?php echo site_url('front/account/cancel/'.$new->id); ?>"><i class="fa fa-close"></i> <?php echo lang('cancel')?></a>
        									<?php } ?>
        									<a class="btn btn-theme" href="<?php echo site_url('front/account/payments/'.$new->id); ?>"  style="margin-left:5px;><i><?php echo $this->setting->currency_symbol ?></i> <?php echo lang('payment')?></a>						 
        									<a class="btn btn-theme" href="<?php echo site_url('front/account/order/'.$new->id); ?>" style="margin-left:5px;"><i class="fa fa-file-text-o"></i> <?php echo lang('view')?></a>						
        								</div>
        							</td>
        						</tr>
        				<?php $i++; endforeach;?>
        				<?php endif?>
					</tbody>
				</table>
			</div>
	     </div>
    </div>
</div>
<script src="<?php echo base_url('assets/admin/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	$('#example1').dataTable({
	});
	
});

</script>
