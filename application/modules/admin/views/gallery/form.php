<style>
.blah{border:2px solid #EFEFEF; padding:3px} 
</style>

  <?php  $seg= $this->uri->segment(4);?>
<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
           </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li><a href="<?php echo site_url('admin/gallery') ?>"> <?php echo lang('gallery')?> </a></li>
            <li class="active"><?php echo (empty($seg))?lang('add'):lang('edit');?></li>
          </ol>
</section>

<section class="content">
    	 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
					
				<form method="post" action="<?php echo site_url('admin/gallery/form/'.$id); ?>" enctype="multipart/form-data">	
					<div class="form-group">
					  <div class="row">
						<div class="col-md-3">
                      		<label><?php echo lang('title') ?></label>
                      		<?php
								$data	= array('name'=>'title', 'value'=>set_value('title', $title), 'class'=>'form-control', 'required'=>true);
								echo form_input($data); ?>
						</div>	
					
					  </div>		
                    </div>
					<div class="form-group ">
					<div class="input_fields_wrap">
					  <div class="row ">
						
						<?php if(!$id){?>
						<div class="col-md-3">
                      		<label><?php echo lang('caption') ?></label>
                      		<input type="text" name="caption[]" value="" class="form-control" required />
						</div>	
					  	<div class="col-md-3">
                      		<label><?php echo lang('image') ?></label>
                      		<input type="file" name="image[]" class="form-control" id="1"  required onchange="readURL(this,blah1);"   />
						</div>	
						<div class="col-md-2  blah1"  >
									<img class="blah hide" src="#" alt="your image" id="blah1" />
						</div>
							<div style="padding-top:20px;"><button class="add_field_button btn btn-success"><?php echo lang('add_more');?></button>
						</div>
						<?php }?>
					 </div>	
					 
					 	<?php if($id){?>
						<?php $i=0;foreach($images as $img){?>
					    <div class="row ">
							<div class="col-md-3">
								<label><?php echo lang('caption') ?></label>
								<input type="text" name="caption[]" value="<?php echo $img->caption?>" id="<?php echo $img->id?>" class="form-control captionedit" required />
							</div>	
							<div class="col-md-3 ">
								<label><?php echo lang('image') ?></label>
								<input type="file" name="image[]" class="form-control imgchange"  id="<?php echo $img->id?>"onchange="readURL(this,urblah<?php echo $i?>);" />
							</div>	
							<div class="col-md-2  urblah<?php echo $i?>"  >
										<img class="blah " src="<?php echo base_url('assets/admin/uploads/gallery/small/'.$img->image)?>" alt="your image" id="urblah<?php echo $i?>" width="100" height="80" />
							</div>
							<?php if($i==0){?>
								<div style="padding-top:20px;"><button class="add_field_button btn btn-success"><?php echo lang('add_more');?></button></div>
							<?php }else{?>	
								<div class="col-md-2"><div style="padding-top:20px;"><a href="#" id="<?php echo $img->id?>" class="remove_fieldedit btn btn-danger">Remove</a></div></div>
							<?php } ?>
						</div>
					  <?php $i++;}
					  	}
					  ?>
					 	
					 
					 	
					 </div>
                    </div>
					
					<div class="class="box-footer"">
							<input class="btn btn-primary" type="submit" value="Save"/>
					</div>
					</form>
     			 </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>
<script type="text/javascript">
$(document).ready(function() {
    var max_fields      = 1000; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 2; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="row"><div class="col-md-3"><label><?php echo lang('caption') ?></label><input type="text" name="caption[]" value="<?php echo @$room_no?>" class="form-control" required /></div><div class="col-md-3"><label><?php echo lang('image') ?></label><input type="file" name="image[]" class="form-control" required onchange="readURL(this,blah'+x+');"  /></div><div class="col-md-2  blah'+x+'"  ><img class="blah hide" src="#" alt="your image" id="blah'+x+'" /></div><div class="col-md-2"><div style="padding-top:20px;"><a href="#" class="remove_field btn btn-danger">Remove</a></button></div></div>'); //add input box
			//$('.chzn').chosen({search_contains:true});
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').parent('div').parent('div').remove(); x--;
    })
	
});
<?php if($id){?>
$(document).on("click",".remove_fieldedit", function(e){ //user click on remove text
        e.preventDefault(); 
		var	id=	event.target.id;
		if(id){
			 if (window.confirm("Are you sure remove this image ?")) {
				 call_loader();
				  $.ajax({
					url: '<?php echo site_url('admin/gallery/updateimg') ?>',
					type:'POST',
					data:{id:id},
					success:function(result){
						remove_loader();
						location.reload();
						//$(this).parent('div').parent('div').parent('div').remove();
					 }
				  });
			} 
		  }  
		
});
<?php } ?>

function readURL(input,d) {
		if (input.files && input.files[0]) {
            var reader = new FileReader();
	        reader.onload = function (e) {
				console.log(d);
				$(d).attr('src', e.target.result).width(100).height(80);
            };

            reader.readAsDataURL(input.files[0]);
			$(d).removeClass('hide');
        }
	}

$(document).on("change",".imgchange", function(e){ //user click on remove text
        e.preventDefault(); 
		var	id=	event.target.id;
		var formData = new FormData($(this).parents('form')[0]);
		//alert(id);return false;
		if(id){
			 
			
			call_loader();
			$.ajax({
				url: '<?php echo site_url('admin/gallery/edit_image');?>/'+id,
				type: 'POST',
				xhr: function() {
					var myXhr = $.ajaxSettings.xhr();
					return myXhr;
				},
				success: function (data) {
				   // alert("Data Uploaded: "+data);
				   remove_loader();
				   location.reload();
				},
				data: formData,
				cache: false,
				contentType: false,
				processData: false
			});
		  }  
		
});


$(document).on("change",".captionedit", function(e){ //user click on remove text
       var	id	=	event.target.id;
		var val = $(this).val();
		if(id){
			call_loader();
			 $.ajax({
					url: '<?php echo site_url('admin/gallery/edit_caption') ?>',
					type:'POST',
					data:{id:id,val:val},
					success:function(result){
						remove_loader();
						alert('<?php echo lang('caption_updated')?>');
					 }
				  });
		  }  
		
});

</script>

 