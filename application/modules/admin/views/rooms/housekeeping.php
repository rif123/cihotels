<link rel="stylesheet" href="<?php echo base_url('assets/admin/') ?>/plugins/datepicker/datepicker3.css">  <?php  $seg= $this->uri->segment(4);?>
<link href="<?php echo base_url('assets/admin/plugins/datatables/dataTables.bootstrap.css')?>" rel="stylesheet" type="text/css" />

<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
            <small><?php echo lang('list'); ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li><a href="<?php echo site_url('admin/rooms') ?>"> <?php echo lang('rooms')?></a></li>
            <li class="active"><?php echo lang('housekeeping'); ?></li>
          </ol>
</section>


<section class="content">
         <div class="row">
		 	<div class="col-md-12" style="padding:20px;">
				<div class="btn-group pull-right">
					<a class="btn btn-success" href="#add" data-toggle="modal"><i class="fa fa-plus"></i> <?php echo lang('add');?></a>
				</div>

			</div>
		 </div>
		 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title"><?php echo lang('housekeeping'); ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
					
					
						<table class="table table-striped" id="example1">
							<thead >
								<tr>
									<th>#</th>
									<th><?php echo lang('room_number'); ?></th>
									<th><?php echo lang('room_type'); ?></th>
									<th><?php echo lang('floor'); ?></th>
									<th><?php echo lang('housekeping_status'); ?></th>
									<th><?php echo lang('assigned_to'); ?></th>
									<th align="center"><?php echo lang('action'); ?></th>
								</tr>
							</thead>
							
							<tbody >
						<?php if($housekeeping):?>		
						<?php $i=1;foreach ($housekeeping as $new):?>
								<tr>
									<td><?php echo $i;?></td>
									<td class="gc_cell_left" ><?php echo  $new->room_number; ?></td>
									<td><?php echo $new->room_type?></td>
									<td><?php echo $new->floor?></td>
									<td><?php echo $new->status?></td>
									<td><?php echo $new->firstname?> <?php echo $new->lastname?></td>
									<td>
										<div class="btn-group" style="float:right">
											<a class="btn btn-default" href="#view<?php echo $new->id?>" data-toggle="modal"><i class="fa fa-eye"></i> <?php echo lang('view')?></a>
											<a class="btn btn-primary" href="#edit<?php echo $new->id?>" data-toggle="modal"><i class="fa fa-edit"></i> <?php echo lang('edit')?></a>
											
											
											<a class="btn btn-danger" href="<?php echo site_url('admin/housekeeping/delete/'.$new->id); ?>" onclick="return areyousure(this);"><i class="fa fa-trash"></i> <?php echo lang('delete')?></a>
										</div>
									</td>
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

<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      <div class="modal-header">
			
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="addlabel"><?php echo lang('add');?> <?php echo lang('housekeeping');?></h4>
      </div>
      <div class="modal-body">
	  			<form method="post" action="<?php echo site_url('admin/rooms/housekeeping/'.$room_id); ?>" enctype="multipart/form-data">	
						<input type="hidden" name="room_id" value="<?php echo $room_id;?>" />
					   <!-- form start -->
			        <div class="box-body">
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-6">
                      		<label><?php echo lang('housekeping_status') ?></label>
                      		<select name="housekeeping_status" class="form-control" required>
									<option value="">--<?php echo lang('select_housekeping_status')?>--</option>
									<?php foreach($housekeeping_status_all as $new){?>
										<option value="<?php echo $new->id?>" ><?php echo $new->title?></option>
									<?php } ?>
							</select>
						</div>	
					  </div>		
                    </div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-6">
                      		<label><?php echo lang('remark') ?></label>
                      		<textarea name="remark" class="form-control"  ></textarea>
						</div>	
					  </div>		
                    </div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-6">
                      		<label><?php echo lang('assigned_to') ?></label>
                      		<select name="assigned_to" class="form-control" required>
									<option value="">--<?php echo lang('select_employee')?>--</option>
									<?php foreach($employees as $new){?>
										<option value="<?php echo $new->id?>"  ><?php echo $new->firstname?> <?php echo $new->lastname?></option>
									<?php } ?>
							</select>
						</div>	
					  </div>		
                    </div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-6">
                      		<label><?php echo lang('date') ?></label>
                      		<input type="text" name="date" class="form-control datepicker" required />
						</div>	
					  </div>		
                    </div>		
							 
            		</div>
                    <div class="box-footer">
                        <button  type="submit" class="btn btn-primary"><?php echo lang('save')?></button>
                    </div>
			</form>
	  </div>		  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>


<?php if(isset($housekeeping)):?>
<?php $i=1;
foreach ($housekeeping as $new){
?>
<!-- Modal -->
<div class="modal fade" id="edit<?php echo $new->id?>" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editlabel"><?php echo lang('edit')?> <?php echo lang('housekeeping')?></h4>
      </div>
      <div class="modal-body">
			 <div id="err_edit<?php echo $new->id?>">  
				<?php if(validation_errors()){?>
				<div class="alert alert-danger alert-dismissable">
					<i class="fa fa-ban"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-close"></i></button>
					<b><?php echo lang('alert')?>!</b><?php echo validation_errors(); ?>
				</div>
				<?php  } ?>  
			 </div>
			
			<form method="post" action="<?php echo site_url('admin/rooms/edit_housekeeping/')?>" enctype="multipart/form-data">
						<input type="hidden" name="id" value="<?php echo $new->id?>" />
						<input type="hidden" name="room_id" value="<?php echo $new->room_id?>" />
			        <div class="box-body">
                     <div class="form-group">
					  <div class="row">
						<div class="col-md-6">
                      		<label><?php echo lang('housekeping_status') ?></label>
                      		<select name="housekeeping_status" class="form-control" required>
									<option value="">--<?php echo lang('select_housekeping_status')?>--</option>
									<?php foreach($housekeeping_status_all as $hs){?>
										<option value="<?php echo $hs->id?>" <?php echo ($hs->id==$new->housekeeping_status)?'selected="selected"':''?> ><?php echo $hs->title?></option>
										<?php } ?>
							</select>
						</div>	
					  </div>		
                    </div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-6">
                      		<label><?php echo lang('remark') ?></label>
                      		<textarea name="remark" class="form-control"  ><?php echo $new->remark?></textarea>
						</div>	
					  </div>		
                    </div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-6">
                      		<label><?php echo lang('assigned_to') ?></label>
                      		<select name="assigned_to" class="form-control" required>
									<option value="">--<?php echo lang('select_employee')?>--</option>
									<?php foreach($employees as $emp){?>
										<option value="<?php echo $emp->id?>" <?php echo ($emp->id==$new->assigned_to)?'selected="selected"':''?>  ><?php echo $emp->firstname?> <?php echo $emp->lastname?></option>
									<?php } ?>
							</select>
						</div>	
					  </div>		
                    </div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-6">
                      		<label><?php echo lang('date') ?></label>
                      		<input type="text" name="date" class="form-control datepicker" value="<?php echo $new->date?>" required />
						</div>	
					  </div>		
                    </div>	 
            
                    <div class="box-footer">
                        <button  type="submit" class="btn btn-primary update"><?php echo lang('update')?></button>
                    </div>
			</form>
			</div>
	  </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>

  <?php $i++;}?>
<?php endif;?>
		


<?php if(isset($housekeeping)):?>
<?php $i=1;
foreach ($housekeeping as $new){
?>
<!-- Modal -->
<div class="modal fade" id="view<?php echo $new->id?>" tabindex="-1" role="dialog" aria-labelledby="editlabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ff">
      
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="editlabel"><?php echo lang('view')?> <?php echo lang('housekeeping')?></h4>
      </div>
      <div class="modal-body">
				     <div class="box-body">
                    
					 <div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('room_number') ?></label>
                      	</div>
						<div class="col-md-6">
							<?php echo $new->room_number?> 
						</div>	
					  </div>		
                    </div>
					 <div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('room_type') ?></label>
                      	</div>
						<div class="col-md-6">
							<?php echo $new->room_type?> 
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('floor') ?></label>
                      	</div>
						<div class="col-md-6">
							<?php echo $new->floor?> 
						</div>	
					  </div>		
                    </div>
					 <div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('housekeping_status') ?></label>
                      	</div>
						<div class="col-md-6">
							<?php echo $new->status?>
						</div>	
					  </div>		
                    </div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('remark') ?></label>
                      	</div>
						<div class="col-md-6">
					  		<?php echo $new->remark?>
						</div>	
					  </div>		
                    </div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('assigned_to') ?></label>
                      	</div>
						<div class="col-md-6">
							<?php echo $new->firstname?> <?php echo $new->lastname?>
						</div>	
					  </div>		
                    </div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('date') ?></label>
                      	</div>
						<div class="col-md-6">
							<?php echo $new->date?>
						</div>	
					  </div>		
                    </div>	 
			</div>
	  </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close')?></button>  
      </div>
    </div>
  </div>
</div>

  <?php $i++;}?>
<?php endif;?>
		


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
$( ".update" ).click(function( event ) {
event.preventDefault();
//$(this).closest("form").submit();	
	
	var form = $(this).closest('form');
	id = $(form ).find('input[name=id]').val();
	call_loader();
	$.ajax({
		url: '<?php echo site_url('admin/rooms/edit_housekeeping') ?>',
		type:'POST',
		data:$(form).serialize(),
		success:function(result){
		//alert(result);return false;
			  if(result==1)
				{
					location.reload();
					// $('#edit'+id).modal('hide');
					 //window.close(); 
				}
				else
				{
					remove_loader();
					$('#err_edit'+id).html(result);
				}
		  
		  $(".chzn").chosen();
		 }
	  });
});

</script>
