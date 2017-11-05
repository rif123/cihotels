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
			<li><a href="<?php echo site_url('admin/services') ?>"> <?php echo lang('services')?> </a></li>
            <li class="active"><?php echo (empty($seg))?lang('add'):lang('edit');?></li>
          </ol>
</section>


<section class="content">
    	 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
					
				<form method="post" action="<?php echo site_url('admin/services/form/'.$id); ?>" enctype="multipart/form-data">	
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('title') ?></label>
                      		<?php
								$data	= array('name'=>'title', 'value'=>set_value('title', $title), 'class'=>'form-control');
								echo form_input($data); ?>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('room_types') ?></label>
                      		<select name="room_types[]" class="form-control multiselect" multiple="multiple">
								<?php foreach($room_types as $new){?>
									<option value="<?php echo $new->id?>" <?php echo (in_array($new->id,$romm_services))?'selected="selected"':''?>><?php echo $new->title?></option>
								<?php } ?>
							</select>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('price_type') ?></label>
                      		<select name="price_type" class="form-control">
								<option value="">--<?php echo lang('price_type')?>--</option>
								<option value="1" <?php echo ($price_type==1)?'selected="selected"':''?> ><?php echo lang('per_person')?></option>
								<option value="2" <?php echo ($price_type==2)?'selected="selected"':''?> ><?php echo lang('per_night')?></option>
								<option value="3" <?php echo ($price_type==3)?'selected="selected"':''?> ><?php echo lang('fixed_price')?></option>
							</select>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('price') ?></label>
                      		<input type="text" name="price" value="<?php echo set_value('price',$price)?>"  class="form-control" />
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('status') ?></label>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      		<input type="radio" name="status" value="1" <?php echo ($status==1)?'checked="checked"':''?> /> <?php echo lang('active'); ?>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="status" value="2" <?php echo ($status==2)?'checked="checked"':''?> /> <?php echo lang('inactive'); ?>
						</div>	
					  </div>		
                    </div>
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-12">
                      		<label><?php echo lang('description') ?></label>
                      		<?php
								$data	= array('name'=>'description', 'value'=>set_value('description', $description), 'class'=>'form-control redactor');
								echo form_textarea($data); ?>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-12">
                      		<label><?php echo lang('short_description') ?></label>
                      		<?php
								$data	= array('name'=>'short_description', 'value'=>set_value('short_description', $short_description), 'class'=>'form-control ');
								echo form_textarea($data); ?>
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
<script src="<?php echo base_url('assets/admin/plugins/multiselect/js/jquery.multi-select.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/admin/plugins/multiselect/js/jquery.quicksearch.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/admin/plugins/iCheck/icheck.min.js')?>" type="text/javascript"></script>				
<script type="text/javascript" src="<?php echo base_url('assets/admin/plugins/redactor/redactor.min.js');?>"></script>
<script>
$(document).ready(function(){
	$('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
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