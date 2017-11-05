<link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/daterangepicker/daterangepicker.css')?>">
<link href="<?php echo base_url('assets/admin/plugins/responsivetabs/responsive-tabs.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/admin/plugins/responsivetabs/style.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css" />
<?php  $seg= $this->uri->segment(4);?>
<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
           </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li><a href="<?php echo site_url('admin/price_manager') ?>"> <?php echo lang('price_manager')?> </a></li>
            <li class="active"><?php echo (empty($seg))?lang('add'):lang('edit');?></li>
          </ol>
</section>


<section class="content">
    	 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
					
				<form method="post" action="<?php echo site_url('admin/price_manager/form/'.$id); ?>" enctype="multipart/form-data">	
					<div class="form-group">
						  <div class="row">
							<div class="col-md-4">
								<label><?php echo lang('room_type') ?></label>
								<select name="room_type_id" class="form-control" id="room_type_id" <?php echo ($id)?'disabled="disabled"':'';?> >
									<option value="">--<?php echo lang('select_room_type')?>--</option>
									<?php foreach($room_types as $rt){
									$sel = "";
									if(set_select('room_type_id', $rt->id)) $sel = "selected='selected'";
									if($room_type_id==$rt->id) $sel = "selected='selected'";
									?>
									<option value="<?php echo $rt->id?>" <?php echo $sel?>><?php echo $rt->title?></option>
									<?php } ?>
								</select>
							</div>	
						  </div>		
						</div>	
					<div id="responsiveTabsDemo">
						<ul>
							<li><a href="#tab-1"> <?php echo lang('regular_price')?> </a></li>
							<li><a href="#tab-2"> <?php echo lang('special_price')?></a></li>
						</ul>
					
						<div id="tab-1"> 
							<div class="form-group">
							  <div class="row">
								
								<div class="col-md-2">
									<label><?php echo lang('mon') ?></label>
									<input type="number" name="mon" value="<?php echo set_value('mon',@$mon)?>" id="mon" class="form-control" step="0.01" />
								</div>	
								<div class="col-md-2">
									<label><?php echo lang('tue') ?></label>
									<input type="number" name="tue" value="<?php echo set_value('tue',@$tue)?>" id="tue" class="form-control" step="0.01" />
								</div>	
								<div class="col-md-2">
									<label><?php echo lang('wed') ?></label>
									<input type="number" name="wed" value="<?php echo set_value('wed',@$wed)?>" id="wed" class="form-control" step="0.01"/>
								</div>	
								<div class="col-md-2">
									<label><?php echo lang('thu') ?></label>
									<input type="number" name="thu" value="<?php echo set_value('thu',@$thu)?>" id="thu" class="form-control" step="0.01" />
								</div>	
								<div class="col-md-2">
									<label><?php echo lang('fri') ?></label>
									<input type="number" name="fri" value="<?php echo set_value('fri',@$fri)?>" id="fri" class="form-control" step="0.01" />
								</div>	
								<div class="col-md-2">
									<label><?php echo lang('sat') ?></label>
									<input type="number" name="sat" value="<?php echo set_value('sat',@$sat)?>" id="sat" class="form-control" step="0.01" />
								</div>	
								<div class="col-md-2">
									<label><?php echo lang('sun') ?></label>
									<input type="number" name="sun" value="<?php echo set_value('sun',@$sun)?>" id="sun" class="form-control" step="0.01"  />
								</div>	
							  </div>		
							</div>	
							
						 </div>
						<div id="tab-2">
							
							<div class="form-group">
							  <div class="row">
								<div class="col-md-2">
									<label><?php echo lang('title') ?></label>
								</div>
								<div class="col-md-4">	
									<input type="text" name="title" value="" class="form-control" />
								</div>	
							  </div>		
							</div>	
							<div class="form-group">
							  <div class="row">
								<div class="col-md-2">
									<label><?php echo lang('date_range') ?></label>
								</div>
								<div class="col-md-4">	
									<input type="text" name="date" class="form-control " id="reservationtime" value="<?php echo set_value('date')?>" autocomplete='off'>
								</div>	
							  </div>		
							</div>	
							<div class="form-group">
							  <div class="row">
								
								<div class="col-md-2">
									<label><?php echo lang('mon') ?></label>
									<input type="number" name="spl_mon" value="<?php echo set_value('spl_mon')?>" id="spl_mon" class="form-control" step="0.01" />
								</div>	
								<div class="col-md-2">
									<label><?php echo lang('tue') ?></label>
									<input type="number" name="spl_tue" value="<?php echo set_value('spl_tue')?>" id="spl_tue" class="form-control" step="0.01" />
								</div>	
								<div class="col-md-2">
									<label><?php echo lang('wed') ?></label>
									<input type="number" name="spl_wed" value="<?php echo set_value('spl_wed')?>" id="spl_wed" class="form-control" step="0.01"/>
								</div>	
								<div class="col-md-2">
									<label><?php echo lang('thu') ?></label>
									<input type="number" name="spl_thu" value="<?php echo set_value('spl_thu')?>" id="spl_thu" class="form-control" step="0.01" />
								</div>	
								<div class="col-md-2">
									<label><?php echo lang('fri') ?></label>
									<input type="number" name="spl_fri" value="<?php echo set_value('spl_fri')?>" id="spl_fri" class="form-control" step="0.01" />
								</div>	
								<div class="col-md-2">
									<label><?php echo lang('sat') ?></label>
									<input type="number" name="spl_sat" value="<?php echo set_value('spl_sat')?>" id="spl_sat" class="form-control" step="0.01" />
								</div>	
								<div class="col-md-2">
									<label><?php echo lang('sun') ?></label>
									<input type="number" name="spl_sun" value="<?php echo set_value('spl_sun')?>" id="spl_sun" class="form-control" step="0.01"  />
								</div>	
							  
							  </div>		
							</div>
							<table class="table table-striped" id="example1">
								<thead >
									<tr>
										<th>#</th>
										<th><?php echo lang('date_range'); ?></th>
										<th><?php echo lang('title'); ?></th>
										<th><?php echo lang('mon'); ?></th>
										<th><?php echo lang('tue'); ?></th>
										<th><?php echo lang('wed'); ?></th>
										<th><?php echo lang('thu'); ?></th>
										<th><?php echo lang('fri'); ?></th>
										<th><?php echo lang('sat'); ?></th>
										<th><?php echo lang('sun'); ?></th>
										<th></th>
									</tr>
								</thead>
								
								<tbody >
							<?php if($spl_prices):?>		
							<?php $i=1;foreach ($spl_prices as $new):?>
									<tr>
										<td><?php echo $i;?></td>
										<td class="gc_cell_left" ><?php echo  date('d/m/Y h:i a', strtotime($new->date_from)); ?> to <?php echo  date('d/m/Y h:i a', strtotime($new->date_to)); ?></td>			
										<td><?php echo $new->title; ?></td>
										<td><?php echo $new->mon; ?></td>
										<td><?php echo $new->tue; ?></td>
										<td><?php echo $new->wed; ?></td>
										<td><?php echo $new->thu; ?></td>
										<td><?php echo $new->fri; ?></td>
										<td><?php echo $new->sat; ?></td>
										<td><?php echo $new->sun; ?></td>
										<td>
											<div class="btn-group" style="float:right">
												
												<a class="btn btn-danger" href="<?php echo site_url('admin/price_manager/delete_spl_price/'.$new->id.'/'.$id); ?>" onclick="return areyousure(this);"><i class="fa fa-trash"></i> </a>
											</div>
										</td>
									</tr>
							<?php $i++; endforeach;?>
							<?php endif?>
								</tbody>
							</table>

							
						</div>
					</div>
					
				
					<div class="box-footer">
									<input class="btn btn-primary" type="submit" value="Save"/>
							</div>
					
					</form>
     			 </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>
<script src="<?php echo base_url('assets/admin/plugins/responsivetabs/jquery.responsiveTabs.min.js')?>" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="<?php echo base_url('assets/admin/plugins/daterangepicker/daterangepicker.js')?>"></script>
<script src="<?php echo base_url('assets/admin/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	$('#example1').dataTable({
	});
	$('#responsiveTabsDemo').responsiveTabs({
    	startCollapsed: 'accordion',
		<?php if($tab){?>
		active: <?php echo $tab?>
		<?php } ?>
	});
	$('#reservationtime').daterangepicker({
        timePicker: true,
		timePickerIncrement: 30,
        locale: {
            format: 'YYYY-MM-DD h:mm A'
        }
    });
	
});
$(document).on('change', '#room_type_id', function(){
 //alert(12);
 vch = $(this).val();
  if(vch){	  
	  call_loader();
	  $.ajax({
		url: '<?php echo site_url('admin/price_manager/get_room_type_data') ?>',
		type:'POST',
		data:{id:vch},
		success:function(result){
			remove_loader();
			var t = JSON.parse(result);
		    $('#mon').val(t['mon']);
			$('#tue').val(t['tue']);
			$('#wed').val(t['wed']);
			$('#thu').val(t['thu']);
			$('#fri').val(t['fri']);
			$('#sat').val(t['sat']);
			$('#sun').val(t['sun']);
		   //alert(t['mon']);return false;
		  }
	  });
	} else{
			$('#mon').val('');
			$('#tue').val('');
			$('#wed').val('');
			$('#thu').val('');
			$('#fri').val('');
			$('#sat').val('');
			$('#sun').val('');
	} 
});

$('#reservationtime').on('apply.daterangepicker', function(ev, picker) {
  //console.log(picker.startDate.format('YYYY-MM-DD'));
  //console.log(picker.endDate.format('YYYY-MM-DD'));
	var sd	=	picker.startDate.format('YYYY-MM-DD');
	var ed	=	picker.endDate.format('YYYY-MM-DD');
	<?php if(!empty($room_type_id)){?>
	var room_type_id	=	'<?php echo $room_type_id?>';
	var id	=	'<?php echo $id?>';
	<?php } else{?>
	var room_type_id 	= $('#room_type_id').val();
	var id				=	'';
	if(id==''){
		alert('First You Select Room Type Must'); return false;
	}
	<?php } ?>
	if(id){	  
	  call_loader();
	  $.ajax({
		url: '<?php echo site_url('admin/price_manager/check_start_date') ?>',
		type:'POST',
		data:{room_type_id:room_type_id,start_date:sd,end_date:ed,id:id},
		success:function(result){
			remove_loader();
			if(result==1){
				alert('With This Room Type In This Date Special Prices Are Available');
			}
		   //alert(t['mon']);return false;
		}
	  });
	}

});

</script>