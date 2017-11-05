<link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/daterangepicker/daterangepicker.css')?>">
<link href="<?php echo base_url('assets/admin/plugins/multiselect/css/multi-select.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/admin/plugins/iCheck/all.css')?>" rel="stylesheet" type="text/css" />
 <link type="text/css" href="<?php echo base_url('assets/admin/plugins/redactor/redactor.css');?>" rel="stylesheet" />
  <?php  $seg= $this->uri->segment(4);?>
<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
           </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li><a href="<?php echo site_url('admin/coupons') ?>"> <?php echo lang('coupon_management')?> </a></li>
            <li class="active"><?php echo (empty($seg))?lang('add'):lang('edit');?></li>
          </ol>
</section>


<section class="content">
    	 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
					
				<form method="post" action="<?php echo site_url('admin/coupons/form/'.$id); ?>" enctype="multipart/form-data">	
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('offer_title') ?></label>
                      		<?php
								$data	= array('name'=>'title', 'value'=>set_value('title', $title), 'class'=>'form-control');
								echo form_input($data); ?>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-8">
                      		<label><?php echo lang('description') ?></label>
                      		<?php
								$data	= array('name'=>'description', 'value'=>set_value('description', $description), 'class'=>'form-control redactor');
								echo form_textarea($data); ?>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('offer_image') ?></label>
                      		<input type="file" name="image" class="form-control" />
							<input type="hidden" name="old_image" value="<?php echo $image?>" />
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
						<div class="row">
								<div class="col-md-4">
								<label><?php echo lang('coupon_period')?></label>
				
								<div class="input-group">
								  <div class="input-group-addon">
									<i class="fa fa-clock-o"></i>
								  </div>
								  <input type="text" name="date" class="form-control " id="reservationtime" value="<?php echo set_value('date',$date)?>" autocomplete='off'>
								</div>
								<!-- /.input group -->
							</div>
						</div>
					</div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('coupon_code') ?></label>
                      		<?php
								$data	= array('name'=>'code', 'value'=>set_value('code', $code), 'class'=>'form-control','autocomplete'=>'off');
								echo form_input($data); ?>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('coupon_type') ?></label>
                      		<select name="type" class="form-control"> 
								<option value="">--<?php echo lang('coupon_type')?>--</option>
								<option value="Percentage" <?php echo ($type=="Percentage")?'selected="selected"':''?> ><?php echo lang('percentage')?></option>
								<option value="Fixed" <?php echo ($type=="Fixed")?'selected="selected"':''?> ><?php echo lang('fixed')?></option>
							</select>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('coupon_value') ?></label>
                      		<input type="number" name="value" value="<?php echo set_value('value',@$value)?>"  class="form-control" />
						</div>	
					  </div>		
                    </div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('min_amount') ?></label>
                      		<input type="number" name="min_amount" value="<?php echo set_value('min_amount',@$min_amount)?>"  class="form-control" />
						</div>	
					  </div>		
                    </div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('max_amount') ?></label>
                      		<input type="number" name="max_amount" value="<?php echo set_value('max_amount',@$max_amount)?>"  class="form-control" />
						</div>	
					  </div>		
                    </div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('include_user') ?></label>
                      		<select name="include_user[]" class="form-control multiselect" multiple="multiple">
								<?php foreach($guests as $new){?>
									<option value="<?php echo $new->id?>" <?php if(!empty($include_user)){ echo (in_array($new->id,$include_user))?'selected="selected"':'';}?>><?php echo $new->firstname?> <?php echo $new->lastname?></option>
								<?php } ?>
							</select>
						</div>	
						<div class="col-md-1"></div>
						<div class="col-md-4">
                      		<label><?php echo lang('exclude_user') ?></label>
                      		<select name="exclude_user[]" class="form-control multiselect" multiple="multiple">
								<?php foreach($guests as $new){?>
									<option value="<?php echo $new->id?>" <?php if(!empty($exclude_user)){ echo (in_array($new->id,$exclude_user))?'selected="selected"':''; }?>><?php echo $new->firstname?> <?php echo $new->lastname?></option>
								<?php } ?>
							</select>
						</div>	
					  </div>		
                    </div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('include_room_type') ?></label>
                      		<select name="include_room_type[]" class="form-control multiselect" multiple="multiple">
								<?php foreach($room_types as $new){?>
									<option value="<?php echo $new->id?>" <?php if(!empty($include_room_type)){ echo (in_array($new->id,$include_room_type))?'selected="selected"':''; }?>><?php echo $new->title?></option>
								<?php } ?>
							</select>
						</div>	
						<div class="col-md-1"></div>
						<div class="col-md-4">
                      		<label><?php echo lang('exclude_room_type') ?></label>
                      		<select name="exclude_room_type[]" class="form-control multiselect" multiple="multiple">
								<?php foreach($room_types as $new){?>
									<option value="<?php echo $new->id?>" <?php if(!empty($exclude_room_type)){ echo (in_array($new->id,$exclude_room_type))?'selected="selected"':''; }?>><?php echo $new->title?></option>
								<?php } ?>
							</select>
						</div>	
					  </div>		
                    </div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('limit_per_user') ?></label>
                      		<input type="number" name="limit_per_user" value="<?php echo set_value('limit_per_user',@$limit_per_user)?>"  class="form-control" />
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('limit_per_coupon') ?></label>
                      		<input type="number" name="limit_per_coupon" value="<?php echo set_value('limit_per_coupon',@$limit_per_coupon)?>"  class="form-control" />
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-12">
                      		<label><?php echo lang('paid_services') ?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      		<?php foreach($services as $ser){?>
							<input type="checkbox" name="paid_services[]" value="<?php echo $ser->id?>" <?php if(!empty($paid_services)){	echo (in_array($ser->id,$paid_services))?'checked="checked"':'';}?> /> &nbsp;&nbsp;<?php echo $ser->title?> &nbsp;&nbsp;&nbsp;&nbsp;
							<?php  } ?>
						</div>	
					  </div>		
                    </div>
					
					
					<div class="class="box-footer"">
							<input class="btn btn-primary" type="submit" value="<?php echo lang('save')?>"/>
					</div>
					</form>
     			 </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>
<script type="text/javascript" src="<?php echo base_url('assets/admin/plugins/redactor/redactor.min.js');?>"></script>		
<script src="<?php echo base_url('assets/admin/plugins/multiselect/js/jquery.multi-select.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/admin/plugins/multiselect/js/jquery.quicksearch.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/admin/plugins/iCheck/icheck.min.js')?>" type="text/javascript"></script>				
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="<?php echo base_url('assets/admin/plugins/daterangepicker/daterangepicker.js')?>"></script>
<script>
$(document).ready(function(){
	//$('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'YYYY-MM-DD h:mm A'});
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
	$('#reservationtime').daterangepicker({
        timePicker: true,
		timePickerIncrement: 30,
        locale: {
            format: 'YYYY-MM-DD h:mm A'
        }
    });
	$('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
     });
  	
	$('.multiselect').multiSelect({
	  selectableHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Search..'>",
	  selectionHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='Search..'>",
	  afterInit: function(ms){
		var that = this,
			$selectableSearch = that.$selectableUl.prev(),
			$selectionSearch = that.$selectionUl.prev(),
			selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
			selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';
	
		that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
		.on('keydown', function(e){
		  if (e.which === 40){
			that.$selectableUl.focus();
			return false;
		  }
		});
	
		that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
		.on('keydown', function(e){
		  if (e.which == 40){
			that.$selectionUl.focus();
			return false;
		  }
		});
	  },
	  afterSelect: function(){
		this.qs1.cache();
		this.qs2.cache();
	  },
	  afterDeselect: function(){
		this.qs1.cache();
		this.qs2.cache();
	  }
	});
	
	 $('.multiselect').change(function () {
			//var mangle =  $(this).closest('form').find('select.multiselect option:selected').val();
			var tot = 0;
            $.each($(this).closest('form').find('select.multiselect option:selected'), function () {
                var curr_val = parseFloat($(this).data('id'));
               // alert(curr_val);
				tot = tot + curr_val;
				//console.log(tot);
            }
            );
            //var discount = $('#dis_id').val();
			var discount =  $(this).closest('form').find('.dis_id').val();
            var gross = tot - discount;
            //$('#add_form').find('[name="sub_total"]').val(tot).end()
            $(this).closest('form').find('[name="sub_total"]').val(tot).end()
			$(this).closest('form').find('[name="total"]').val(Math.round(gross))
			//$('#add_form').find('[name="total"]').val(gross)
			 
        }

    );	  
	  
});

</script>