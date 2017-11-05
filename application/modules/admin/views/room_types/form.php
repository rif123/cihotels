 <link type="text/css" href="<?php echo base_url('assets/admin/plugins/redactor/redactor.css');?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/admin/plugins/responsivetabs/responsive-tabs.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/admin/plugins/responsivetabs/style.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/admin/plugins/iCheck/all.css')?>" rel="stylesheet" type="text/css" />
  <?php  $seg= $this->uri->segment(4);?>
<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
           </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li><a href="<?php echo site_url('admin/room_types') ?>"> <?php echo lang('room_types')?> </a></li>
            <li class="active"><?php echo (empty($seg))?lang('add'):lang('edit');?></li>
          </ol>
</section>


<section class="content">
    	 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
					
				<form method="post" action="<?php echo site_url('admin/room_types/form/'.$id); ?>" enctype="multipart/form-data">	
					<div id="responsiveTabsDemo">
						<ul>
							<li><a href="#tab-1"> <?php echo lang('details')?> </a></li>
							<li><a href="#tab-2"> <?php echo lang('images')?></a></li>
						</ul>
					
						<div id="tab-1"> 
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<label><?php echo lang('title') ?></label>
									</div>
									<div class="col-md-4">
										<?php
											$data	= array('name'=>'title', 'value'=>set_value('title', $title), 'class'=>'form-control');
											echo form_input($data); ?>
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<label><?php echo lang('slug') ?></label>
									</div>
									<div class="col-md-4">
										<?php
											$data	= array('name'=>'slug', 'value'=>set_value('slug', $slug), 'class'=>'form-control');
											echo form_input($data); ?>
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<label><?php echo lang('shortcode') ?></label>
									</div>
									<div class="col-md-4">
										<?php
											$data	= array('name'=>'shortcode', 'value'=>set_value('shortcode', $shortcode), 'class'=>'form-control');
											echo form_input($data); ?>
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<label><?php echo lang('description') ?></label>
									</div>
									<div class="col-md-8">	
										<textarea name="description" class="form-control redactor"><?php echo $description?></textarea>
									</div>	
								  </div>		
								</div>
								<!--
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<label><?php echo lang('base_occupancy') ?></label>
									</div>
									<div class="col-md-4">
											<input type="number" name="base_occupancy" class="form-control" value="<?php echo set_value('base_occupancy', $base_occupancy) ?>" id="base_occupancy" />
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<label><?php echo lang('higher_occupancy') ?></label>
									</div>
									<div class="col-md-4">
										
											<input type="number" name="higher_occupancy" class="form-control" value="<?php echo set_value('higher_occupancy', $higher_occupancy) ?>" id="higher_occupancy" />
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<label><?php echo lang('extra_bed') ?></label>
									</div>
									<div class="col-md-4">
										<input type="checkbox" name="extra_bed" value="1" id="extra_bed" <?php echo ($extra_bed==1)?'checked="checked"':''?> />
									</div>	
									<div class="col-md-4" id="extra_beds_div">
										<?php
											$data	= array('name'=>'extra_beds', 'value'=>set_value('extra_beds', @$extra_beds), 'class'=>'form-control','placeholder'=>lang('no_of_extra_bed'),'id'=>'extra_beds');
											echo form_input($data); ?>
									</div>	
								  </div>		
								</div>
								
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<label><?php echo lang('kids_occupancy') ?></label>
									</div>
									<div class="col-md-4">
										<?php
											$data	= array('name'=>'kids_occupancy', 'value'=>set_value('kids_occupancy', $kids_occupancy), 'class'=>'form-control');
											echo form_input($data); ?>
									</div>	
								  </div>		
								</div>
								-->
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<label><?php echo lang('amenities') ?></label>
									</div>
									<div class="col-md-10">
									<?php foreach($amenities as $am){?>
											<b><?php  echo $am->name?> </b>  &nbsp;&nbsp; <input type="checkbox" name="amenity[<?php  echo $am->id?>]" value="1" <?php echo (in_array($am->id,$room_amenities))?'checked="checked"':'';?>  /> &nbsp;&nbsp;
									<?php } ?>
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<label><?php echo lang('base_price') ?></label>
									</div>
									<div class="col-md-4">
										<?php
											$data	= array('name'=>'base_price', 'value'=>set_value('base_price', $base_price), 'class'=>'form-control');
											echo form_input($data); ?>
									</div>	
								  </div>		
								</div>
								<!--
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<label><?php echo lang('additional_person') ?></label>
									</div>
									<div class="col-md-4">
										<?php
											$data	= array('name'=>'additional_person', 'value'=>set_value('additional_person', $additional_person), 'class'=>'form-control');
											echo form_input($data); ?>
									</div>	
								  </div>		
								</div>
								
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<label><?php echo lang('extra_bed_price') ?></label>
									</div>
									<div class="col-md-4">
										<?php
											$data	= array('name'=>'extra_bed_price', 'value'=>set_value('extra_bed_price', $extra_bed_price), 'class'=>'form-control');
											echo form_input($data); ?>
									</div>	
								  </div>		
								</div>
								-->
									
									 </div>
						<div id="tab-2">
							<div class="form-group ">
								<div class="input_fields_wrap">
								<?php if(!$id){?>
								  <div class="row ">
									<div class="col-md-3">
										<label><?php echo lang('image') ?></label>
										<input type="file" name="image[]" class="form-control" id="1"  onchange="readURL(this,blah1);"   />
									</div>	
									<div class="col-md-2  blah1"  >
												<img class="blah hide" src="#" alt="your image" id="blah1" />
									</div>
										<div style="padding-top:20px;"><button class="add_field_button btn btn-success"><?php echo lang('add_more');?></button>
									</div>
								 </div>	
								 <?php } ?>
									<?php if($id){?>
									<?php if(empty($images)){?>
										<div class="row ">
										<div class="col-md-3">
											<label><?php echo lang('image') ?></label>
											<input type="file" name="image[]" class="form-control" id="1"  onchange="readURL(this,blah1);"   />
										</div>	
										<div class="col-md-2  blah1"  >
													<img class="blah hide" src="#" alt="your image" id="blah1" />
										</div>
											<div style="padding-top:20px;"><button class="add_field_button btn btn-success"><?php echo lang('add_more');?></button>
										</div>
									 </div>	
									<?php } ?>
									
									<?php $i=0;foreach($images as $img){?>
									<div class="row ">
										<div class="col-md-3 ">
											<label><?php echo lang('image') ?></label>
											<input type="file" name="image[]" class="form-control imgchange"  id="<?php echo $img->id?>"onchange="readURL(this,urblah<?php echo $i?>);" />
										</div>	
										<div class="col-md-2  urblah<?php echo $i?>"  >
													<img class="blah " src="<?php echo base_url('assets/admin/uploads/gallery/small/'.$img->image)?>" alt="your image" id="urblah<?php echo $i?>" width="100" height="80" />
										</div>
										<div class="col-md-3" style="padding-top:10px;">
											<input type="radio" name="featured" value="1" id="<?php echo $img->id?>" class="featured" <?php echo ($img->is_featured==1)?'checked="checked"':''?>  /> <?php echo lang('featured_image')?>
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
<script type="text/javascript" src="<?php echo base_url('assets/admin/plugins/redactor/redactor.min.js');?>"></script>		
<script src="<?php echo base_url('assets/admin/plugins/iCheck/icheck.min.js')?>" type="text/javascript"></script>		
<script src="<?php echo base_url('assets/admin/plugins/responsivetabs/jquery.responsiveTabs.min.js')?>" type="text/javascript"></script>
<script>
$(function() {
	$('#responsiveTabsDemo').responsiveTabs({
    	startCollapsed: 'accordion',
		<?php
		 if(isset($_GET['show'])){?>
		active: 1,
		<?php } ?>
	});
	$('.redactor').redactor({
			  // formatting: ['p', 'blockquote', 'h2','img'],
            minHeight: 200,
            imageUpload: '<?php echo site_url('/wysiwyg/upload_image');?>',
            fileUpload: '<?php echo site_url('/wysiwyg/upload_file');?>',
            imageGetJson: '<?php echo site_url('/wysiwyg/get_images');?>',
            imageUploadErrorCallback: function(json)
            {
                alert(json.error);
            },
            fileUploadErrorCallback: function(json)
            {
                alert(json.error);
            }
      });
});
$(function() {
	<?php if($extra_bed==1){?>
	$('#extra_beds_div').show();
	<?php } else { ?>
	$('#extra_beds_div').hide();
	<?php } ?>
	$('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
     });
	 
	 $('#extra_bed').on('ifChecked', function (event){
			var ho	=	parseInt($('#higher_occupancy').val(),10);
			var bo	=	parseInt($('#base_occupancy').val(),10);
			var eb	=	parseInt($('#extra_beds').val(),10);
			var sb	=	ho	-	bo;	
			if(sb>0){
						$('#extra_beds_div').show();         
					
			}else{
				$('#extra_bed').attr('checked', false); // Unchecks it
				alert('Extra Bed Not Available');
				
			}
		
		 
	});
	$('#extra_bed').on('ifUnchecked', function (event) {
		$('#extra_beds').val('');
		$('#extra_beds_div').hide();
	});
	$('#higher_occupancy').on('keypress, keyup, blur', function (event){
			var ho	=	parseInt($('#higher_occupancy').val(),10);
			var bo	=	parseInt($('#base_occupancy').val(),10);
			if(ho){
					if(ho < bo){
						//$('#higher_occupancy').focus();
						alert('Higher Occupancy Must Greather Then Or Equal To Base Price'); return false;
					}
			}
	});
	$('#extra_beds').on('keypress, keyup, blur', function (event){
			var ho	=	parseInt($('#higher_occupancy').val(),10);
			var bo	=	parseInt($('#base_occupancy').val(),10);
			var eb	=	parseInt($('#extra_beds').val(),10);
			var sb	=	ho	-	bo;	
			if(sb>0){
					if(eb > sb){
						//$('#higher_occupancy').focus();
						alert('Extra Bed Must Less Then Higher Occupancy  And Greter Then Base Occupancy'); return false;
					}
			}
	});
});

$(document).ready(function() {
    var max_fields      = 1000; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 2; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="row"><div class="col-md-3"><label><?php echo lang('image') ?></label><input type="file" name="image[]" class="form-control" onchange="readURL(this,blah'+x+');"  /></div><div class="col-md-2  blah'+x+'"  ><img class="blah hide" src="#" alt="your image" id="blah'+x+'" /></div><div class="col-md-2"><div style="padding-top:20px;"><a href="#" class="remove_field btn btn-danger">Remove</a></button></div></div>'); //add input box
			//$('.chzn').chosen({search_contains:true});
        }
		$('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
     });
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').parent('div').parent('div').remove(); x--;
    })
	
});
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
	
<?php if($id){?>
$(document).on("click",".remove_fieldedit", function(e){ //user click on remove text
        e.preventDefault(); 
		var	id=	event.target.id;
		if(id){
			 if (window.confirm("Are you sure remove this image ?")) {
				 call_loader();
				  $.ajax({
					url: '<?php echo site_url('admin/room_types/updateimg') ?>',
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
	

$(document).on("change",".imgchange", function(e){ //user click on remove text
        e.preventDefault(); 
		var	id=	event.target.id;
		var formData = new FormData($(this).parents('form')[0]);
		//alert(id);return false;
		if(id){
			 
			
			call_loader();
			$.ajax({
				url: '<?php echo site_url('admin/room_types/edit_image');?>/'+id,
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

$(document).ready(function() {
	$('.featured').on('ifChecked', function (event){
	   var	id	=	event.target.id;
		var room_type_id = '<?php echo @$id?>';
		if(id){
			call_loader();
			 $.ajax({
					url: '<?php echo site_url('admin/room_types/featured') ?>',
					type:'POST',
					data:{id:id,room_type_id:room_type_id},
					success:function(result){
						remove_loader();
						alert('<?php echo lang('featured_message')?>');
					 }
				  });
		  }  
		
	});
});

</script>