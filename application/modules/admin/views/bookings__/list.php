<link href="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url('assets/admin/') ?>/plugins/datepicker/datepicker3.css"> 
<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
            <small><?php echo lang('list'); ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
            <li class="active"><?php echo lang('bookings'); ?></li>
          </ol>
</section>


<section class="content">
        <div class="row" style="padding:20px;">
		 	<div class="col-md-12">
				<div class="btn-group pull-right">
					<a class="btn btn-success" href="<?php echo site_url('admin/bookings/add'); ?>"><i class="fa fa-plus"></i> <?php echo lang('add');?></a>
				</div>

			</div>
		 </div>
		 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title"><?php echo lang('bookings'); ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
					<form method="post">
						<div class="form-group">
						  <div class="row">
							<div class="col-md-2">
								<select name="room_type_id" class="form-control" onchange="this.form.submit();">
									<option value="">--<?php echo lang('filter_by_room_type')?>--</option>
									<?php foreach($room_types as $rt){?>
										<option value="<?php echo $rt->id?>" <?php echo ($rt->id==@$_POST['room_type_id'])?'selected="selected"':''?>><?php echo $rt->title?></option>
									<?php } ?>
								</select>
							</div>	
							<div class="col-md-2">
								<input type="text" name="check_in" value="<?php echo @$_POST['check_in']?>" class="form-control datepicker" onchange="this.form.submit();" placeholder='<?php echo lang('check_in');?>' autocomplete="off" />
							</div>
							<div class="col-md-2">
								<input type="text" name="check_out" value="<?php echo @$_POST['check_out']?>" class="form-control datepicker" onchange="this.form.submit();" placeholder='<?php echo lang('check_out');?>' autocomplete="off" />
							</div>
							<div class="col-md-2">
								<select name="payment_status" class="form-control" onchange="this.form.submit();">
									<option value="">--<?php echo lang('filter_by_payment_status')?>--</option>
									<option value="F" <?php echo ('F'==@$_POST['payment_status'])?'selected="selected"':''?>><?php echo lang('failed')?></option>
									<option value="P" <?php echo ('P'==@$_POST['payment_status'])?'selected="selected"':''?>><?php echo lang('pending')?></option>
									<option value="PP" <?php echo ('PP'==@$_POST['payment_status'])?'selected="selected"':''?>><?php echo lang('partialy_paid')?></option>
									<option value="S" <?php echo ('S'==@$_POST['payment_status'])?'selected="selected"':''?>><?php echo lang('success')?></option>
								</select>
							</div>	
							<div class="col-md-2">
								<select name="status" class="form-control" onchange="this.form.submit();">
									<option value="">--<?php echo lang('filter_by_booking_status')?>--</option>
									<option value="SP" <?php echo ('SP'==@$_POST['status'])?'selected="selected"':''?>><?php echo lang('pending')?></option>
									<option value="SS" <?php echo ('SS'==@$_POST['status'])?'selected="selected"':''?>><?php echo lang('success')?></option>
									<option value="SC" <?php echo ('SC'==@$_POST['status'])?'selected="selected"':''?>><?php echo lang('canceled')?></option>
								</select>
							</div>	
							<div class="col-md-2">
								<input type="text" name="ordered_on" value="<?php echo @$_POST['ordered_on']?>" class="form-control datepicker" onchange="this.form.submit();" placeholder='<?php echo lang('booking_date');?>' autocomplete="off" />
							</div>
						  </div>		
						</div>
					</form>	
						<table class="table table-striped" id="example1">
							<thead >
								<tr>
									<th>#</th>
									<th><?php echo lang('booking_number'); ?></th>
									<th><?php echo lang('room'); ?></th>
									<th><?php echo lang('check_in'); ?></th>
									<th><?php echo lang('check_out'); ?></th>
									<th><?php echo lang('booking_date'); ?></th>
									<th><?php echo lang('payment_status'); ?></th>
									<th><?php echo lang('booking_status'); ?></th>
								</tr>
							</thead>
							
							<tbody style="cursor:pointer">
						<?php if($bookings):?>		
						<?php $i=1;foreach ($bookings as $new):?>
								<tr>
									<td id="<?php echo $new->id?>"><?php echo $i;?></td>
									<td id="<?php echo $new->id?>" class="gc_cell_left" ><?php echo  $new->order_no; ?></td>
									<td id="<?php echo $new->id?>"><?php echo $new->room?></td>
									<td id="<?php echo $new->id?>"><?php echo date_convert($new->check_in)?></td>
									<td id="<?php echo $new->id?>"><?php echo date_convert($new->check_out)?></td>
									<td id="<?php echo $new->id?>"><?php echo date_time_convert($new->ordered_on);?></td>
									<td id="<?php echo $new->id?>"><?php echo ($new->payment_status==1)?lang('success'):''?> <?php echo ($new->payment_status==2)?lang('pending'):''?><?php echo ($new->payment_status==0)?lang('failed'):'';?> <?php echo ($new->payment_status==3)?lang('partialy_paid'):'';?></td>
									<td id="<?php echo $new->id?>"><?php echo ($new->status==1)?lang('success'):''?> <?php echo ($new->status==2)?lang('canceled'):''?><?php echo ($new->status==0)?lang('pending'):'';?> </td>
								</tr>
						<?php $i++; endforeach;?>
						<?php endif?>
							</tbody>
						</table>

				 </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>
<script src="<?php echo base_url('assets/admin/') ?>/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url('assets/admin/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	$('#example1').dataTable({
	});
	$('.datepicker').datepicker({
      	todayHighlight: true,
		autoclose: true,
	   format: 'yyyy-mm-dd',
    });
});
$("#example1 tbody td").on('click',function() {   
    var id = $(this).attr('id');
   //alert(id);return false;
    if(id){
		document.location.href = "<?php echo site_url('admin/bookings/booking/')?>" + id;       
	}
}); 

</script>
