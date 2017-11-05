<link href="<?php echo base_url('assets/admin/plugins/toastr')?>/toastr.min.css" rel="stylesheet" type="text/css" media="all" />
  <?php  $seg= $this->uri->segment(4);?>
<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
           </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li><a href="<?php echo site_url('admin/rooms') ?>"> <?php echo lang('rooms')?> </a></li>
            <li class="active"><?php echo (empty($seg))?lang('add'):lang('edit');?></li>
          </ol>
</section>


<section class="content">
    	 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
					
				<form method="post" action="<?php echo site_url('admin/rooms/form/'.$id); ?>" enctype="multipart/form-data">	
					<input type="hidden" name="id" value="<?php echo $id?>" id="id" />
					<div class="form-group ">
					  <div class="row ">
						<div class="col-md-6">
                      		<label><?php echo lang('floor') ?></label>
                      		<select name="floor_id" class="form-control" required>
								<option value="">--<?php echo lang('select_floor')?>--</option>
								<?php foreach($floors as $fl){?>
									<option value="<?php echo $fl->id?>" <?php echo ($fl->id==$floor_id)?'selected="selected"':''?> ><?php echo $fl->floor_no?>  <?php echo $fl->name?> </option>
								<?php } ?>	
							</select>
						 </div>	
					   </div>
					</div>		
					<div class="form-group ">
					<div class="input_fields_wrap">
					  <div class="row ">
						<div class="col-md-3">
                      		<label><?php echo lang('room_type') ?></label>
                      		<select name="room_type_id[]" class="form-control" required>
								<option value="">--<?php echo lang('select_room_type')?>--</option>
								<?php foreach($room_types as $fl){?>
									<option value="<?php echo $fl->id?>" <?php echo ($fl->id==$room_type_id)?'selected="selected"':''?>><?php echo $fl->title?></option>
								<?php } ?>	
							</select>
						</div>	
					  	<div class="col-md-3">
                      		<label><?php echo lang('room_number') ?></label>
                      		<input type="text" name="room_number[]" value="<?php echo $room_no?>" class="form-control room_number" required />
						</div>	
						<?php if(!$id){?>
						<div class="col-md-2">
							<div style="padding-top:20px;"><button class="add_field_button btn btn-success"><?php echo lang('add_more');?></button>
						</div>
						<?php } ?>
					 </div>		
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
<script src="<?php echo base_url('assets/admin/plugins/toastr')?>/toastr.min.js"></script>				
<script type="text/javascript">
$(document).ready(function() {
    var max_fields      = 1000; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="row"><div class="col-md-3"><label><?php echo lang('room_type') ?></label><select name="room_type_id[]" class="form-control" required><option value="">--<?php echo lang('select_room_type')?>--</option><?php foreach($room_types as $fl){?><option value="<?php echo $fl->id?>"><?php echo $fl->title?></option><?php } ?></select></div><div class="col-md-3"><label><?php echo lang('room_number') ?></label><input type="text" name="room_number[]" value="" class="form-control room_number" required /></div><div class="col-md-2"><div style="padding-top:20px;"><a href="#" class="remove_field btn btn-danger">Remove</a></button></div></div>'); //add input box
			//$('.chzn').chosen({search_contains:true});
			$( ".room_number" ).blur(function( event ) {
				var val		=	$(this).val();
				var id		=	$('#id').val();
				//alert(val); return false;
				if(val){
					call_loader();
					$.ajax({
						url: '<?php echo site_url('admin/rooms/check_room_number') ?>',
						type:'POST',
						data:{value:val,id:id},
						success:function(result){
						//alert(result);return false;
							 remove_loader();
							 if(result==1){ 
								 toastr.error('This Room Number Is Exists!');
								 $(this).val(" ");
							 }		
								
						 }
					  });
				 } 
			});
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').parent('div').parent('div').remove(); x--;
    })
});

$( ".room_number" ).blur(function( event ) {
	var val		=	$(this).val();
	var id		=	$('#id').val();
	//alert(val); return false;
	if(val){
		call_loader();
		$.ajax({
			url: '<?php echo site_url('admin/rooms/check_room_number') ?>',
			type:'POST',
			data:{value:val,id:id},
			success:function(result){
			//alert(result);return false;
				 remove_loader();
				 if(result==1){ 
					 toastr.error('This Room Number Is Exists!');
					 $(this).val(" ");
				 }		
					
			 }
		  });
	 } 
});

</script>

