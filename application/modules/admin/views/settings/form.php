<link href="<?php echo base_url('assets/admin/plugins/iCheck/all.css')?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url('assets/admin/plugins/daterangepicker/daterangepicker.css')?>">
<link href="<?php echo base_url('assets/admin/plugins/colorpicker/bootstrap-colorpicker.min.css')?>" rel="stylesheet" type="text/css" />
<link type="text/css" href="<?php echo base_url('assets/admin/plugins/redactor/redactor.css');?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/admin/plugins/clockpicker/bootstrap-clockpicker.min.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/admin/plugins/multiselect/css/multi-select.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/admin/plugins/responsivetabs/responsive-tabs.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/admin/plugins/responsivetabs/style.css')?>" rel="stylesheet" type="text/css" />
<?php  $seg= $this->uri->segment(4);?>
<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
           </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li class="active"><?php echo lang('settings')?> </li>
          </ol>
</section>


<section class="content">
    	 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
					
				<form method="post" enctype="multipart/form-data">	
					<input type="hidden" name="id" value="<?php echo $id?>" />
					<div id="responsiveTabsDemo">
						<ul>
							<li><a href="#tab-1"> <?php echo lang('genrel_details')?> </a></li>
							<li><a href="#tab-2"> <?php echo lang('global_settings')?> </a></li>
							<li><a href="#tab-3"> <?php echo lang('api_settings')?></a></li>
							<li><a href="#tab-4"> <?php echo lang('smtp_settings')?></a></li>
							<li><a href="#tab-6"> <?php echo lang('backup')?></a></li>
							<li><a href="#tab-7"> <?php echo lang('payment_method')?></a></li>
							<li><a href="#tab-8"> <?php echo lang('social_details')?></a></li>
							<li><a href="#tab-9"> <?php echo lang('theme_setting')?></a></li>
						</ul>
					
						<div id="tab-1"> 
							<div class="form-group">
							  <div class="row">
								<div class="col-md-4">
									<label><?php echo lang('name') ?></label>
									<?php
										$data	= array('name'=>'name', 'value'=>set_value('name', $name), 'class'=>'form-control');
										echo form_input($data); ?>
								</div>	
							  </div>		
							</div>
							<div class="form-group">
							  <div class="row">
								<div class="col-md-4">
									<label><?php echo lang('logo') ?></label>
									<input type="file" name="logo" class="form-control" />
									<input type="hidden" name="old_logo" value="<?php echo @$setting->logo;?>" />
								</div>	
								<div class="col-md-4">
									<?php if(!empty($setting->logo)){?>
										<img src="<?php echo base_url('assets/admin/uploads/images/'.$setting->logo)?>" height="70" width="90" />
									<?php }?>
								</div>
							  </div>		
							</div>
							<div class="form-group">
							  <div class="row">
								<div class="col-md-4">
									<label><?php echo lang('address') ?></label>
									<textarea name="address" class="form-control"><?php echo set_value('address',@$setting->address)?></textarea>
								</div>	
							  </div>		
							</div>
							<div class="form-group">
							  <div class="row">
								<div class="col-md-4">
									<label><?php echo lang('email') ?></label>
									<?php
										$data	= array('name'=>'email', 'value'=>set_value('email', @$setting->email), 'class'=>'form-control');
										echo form_input($data); ?>
								</div>	
							  </div>		
							</div>
							<div class="form-group">
							  <div class="row">
								<div class="col-md-4">
									<label><?php echo lang('phone') ?></label>
									<input type="text" name="phone" value="<?php echo set_value('phone',@$setting->phone)?>" class="form-control" />
								</div>	
							  </div>		
							</div>
							<div class="form-group">
							  <div class="row">
								<div class="col-md-4">
									<label><?php echo lang('fax') ?></label>
									<input type="text" name="fax" value="<?php echo set_value('fax',@$setting->fax)?>" class="form-control" />
								</div>	
							  </div>		
							</div>
							<div class="form-group">
							  <div class="row">
								<div class="col-md-4">
									<label><?php echo lang('footer_text') ?></label>
									<input type="text" name="footer_text" value="<?php echo set_value('footer_text',@$setting->footer_text)?>" class="form-control" />
								</div>	
							  </div>		
							</div>
							
						 </div>
						<div id="tab-2">
							
								<div class="form-group">
								  <div class="row">
									<div class="col-md-4">
										<label><?php echo lang('invoice_no_start') ?></label>
										<input type="number" name="invoice" value="<?php echo set_value('invoice',@$setting->invoice)?>" class="form-control" min='1' />
									</div>	
								  </div>		
								</div>
								
								<div class="form-group">
								  <div class="row">
									<div class="col-md-4">
										<label><?php echo lang('default_language') ?></label>
										<select name="language" class="form-control">
											<option value="">--<?php echo lang('select')?> <?php echo lang('default_language')?>--</option>
											<option value="english" <?php echo (@$setting->language=='english')?'selected="selected"':'';?> >English</option>
											<?php foreach($languages as $lang){
												$sel='';
												if($lang->name==@$setting->language) $sel ='selected="selected"';
												echo '<option value="'.$lang->name.'" '.$sel.'>'.ucwords($lang->name).'</option>';
											}?>
										</select>
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-4">
										<label><?php echo lang('default_currency') ?></label>
										<select name="currency" class="form-control">
											<option value="">--<?php echo lang('select')?> <?php echo lang('default_currency')?>--</option>
											<?php foreach($currency as $cur){
												$sel='';
												if($cur->id==$setting->currency)	$sel='selected="selected"';
												echo '<option value="'.$cur->id.'" '.$sel.'>'.$cur->currency_code.' - '.ucwords($cur->name).'</option>';
											}?>
										</select>
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-4">
										<label><?php echo lang('default_date_format') ?></label>
										<select name="date_format" class="form-control">
											<option value="">--<?php echo lang('select')?> <?php echo lang('default_date_format')?>--</option>
											<option value="d/m/Y" <?php echo (@$setting->date_format=='d/m/Y')?'selected="selected"':'';?> >DD/MM/YYYY</option>
											<option value="m/d/Y" <?php echo (@$setting->date_format=='m/d/Y')?'selected="selected"':'';?>>MM/DD/YYYY</option>
											<option value="Y/m/d" <?php echo (@$setting->date_format=='Y/m/d')?'selected="selected"':'';?>>YYYY/MM/DD</option>
										</select>
									</div>	
								  </div>		
								</div>
								<?php $tz = DateTimeZone::listIdentifiers(DateTimeZone::ALL);?>	

								<div class="form-group">
								  <div class="row">
									<div class="col-md-4">
										<label><?php echo lang('site_timezone') ?></label>
										<select name="timezone" class="form-control">
											<option value="">--<?php echo lang('select')?> <?php echo lang('site_timezone')?>--</option>
											<?php 
											foreach($tz as $new){
											$sel="";
											if($new==@$setting->timezone) $sel ='selected="selected"';
											echo "<option value='".$new."' ".$sel.">".$new."</option>";
											}
											?>
										</select>
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-4">
										<label><?php echo lang('minimum_booking') ?></label>
										<select name="minimum_booking" class="form-control" >
											<option value="">--<?php echo lang('select') ?> <?php echo lang('minimum_booking') ?>--</option>
											<?php for($i=1;$i<=9;$i++){?>
												<option value="<?php echo $i?>" <?php echo ($i==@$setting->minimum_booking)?'selected="selected"':'';?> ><?php echo $i?></option>
											<?php } ?>
										</select>
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-4">
										<label><?php echo lang('advance_payment') ?> (%)</label>
										<input type="number" name="advance_payment" value="<?php echo set_value('advance_payment',@$setting->advance_payment)?>" class="form-control" step='0.1'/>
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-4">
										<label><?php echo lang('taxes') ?></label>
										<select name="taxes[]" class="form-control multiselect" multiple="multiple">
											<?php 
											foreach($taxes as $new){
											$sel="";
											if(in_array($new->id,json_decode(@$setting->taxes))) $sel ='selected="selected"';
											echo "<option value='".$new->id."' ".$sel.">".$new->name."</option>";
											}
											?>
										</select>
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-4">
										<label><?php echo lang('check_in_time') ?> </label>
										<input type="text" name="check_in_time" value="<?php echo set_value('check_in_time',@$setting->check_in_time)?>" class="form-control clockpicker" />
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-4">
										<label><?php echo lang('check_out_time') ?> </label>
										<input type="text" name="check_out_time" value="<?php echo set_value('check_out_time',@$setting->check_out_time)?>" class="form-control clockpicker" />
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-4">
										<label><?php echo lang('time_format') ?> </label>
										<select name="time_format" class="form-control" >
											<option value="">--<?php echo lang('select')?> <?php echo lang('time_format')?>--</option>
											<option value="1" <?php echo (@$setting->time_format==1)?'selected="selected"':'';?> ><?php echo lang('12_hours')?></option>
											<option value="2" <?php echo (@$setting->time_format==2)?'selected="selected"':'';?> ><?php echo lang('24_hours')?></option>
										</select>
									</div>	
								  </div>		
								</div>
								<div class="form-group">
									<div class="row">
											<div class="col-md-4">
											<label><?php echo lang('room_block_period')?></label>
							
											<div class="input-group">
											  <div class="input-group-addon">
												<i class="fa fa-clock-o"></i>
											  </div>
											  <input type="text" name="room_block_period" class="form-control " id="reservationtime" value="<?php echo set_value('room_block_period',$room_block_period)?>" autocomplete='off'>
											</div>
											<!-- /.input group -->
										</div>
									</div>
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-4">
										<label><?php echo lang('maintenance_mode') ?> </label>
									&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="radio" name="maintenance_mode" value="0" <?php echo ($maintenance_mode==0)?'checked="checked"':''?>  /> <?php echo lang('no')?> 
									&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="radio" name="maintenance_mode" value="1" <?php echo ($maintenance_mode==1)?'checked="checked"':''?> />  <?php echo lang('yes')?>
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-8">
										<label><?php echo lang('maintenance_message') ?> </label>
									<textarea name="maintenance_message" class="form-control redactor"><?php echo set_value('maintenance_message',@$setting->maintenance_message)?></textarea>
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-8">
										<label><?php echo lang('cancellation_policy') ?> </label>
									<textarea name="cancellation_policy" class="form-control redactor"><?php echo set_value('cancellation_policy',@$setting->cancellation_policy)?></textarea>
									</div>	
								  </div>		
								</div>
						</div>
						<div id="tab-3">
							<legend><?php echo lang('paypal_settings');?></legend>
							<div class="form-group">
							  <div class="row">
								<div class="col-md-4">
									<label>Sandbox</label>
								</div>	
								<div class="col-md-4">
									<input type="checkbox" name="paypal_sandbox" value="1" <?php echo ($setting->paypal_sandbox==1)?'checked="checked"':'checked="checked"';?> /> <label>(<?php echo lang('sandbox_label');?>)</label>
								</div>
							  </div>		
							</div>
							<div class="form-group">
							  <div class="row">
								<div class="col-md-4">
									<label><?php echo lang('business_email')?></label>
								</div>	
								<div class="col-md-4">
									<input type="text" name="paypal_business_email" class="form-control" value="<?php echo $setting->paypal_business_email?>" />
								</div>
							  </div>		
							</div>
							
							<legend><?php echo lang('stripe_settings');?></legend>
							<div class="form-group">
							  <div class="row">
								<div class="col-md-4">
									<label>Key</label>
								</div>	
								<div class="col-md-4">
									<input type="text" name="stripe_key" class="form-control" value="<?php echo $setting->stripe_key?>" />
								</div>
							  </div>		
							</div>
							<div class="form-group">
							  <div class="row">
								<div class="col-md-4">
									<label>API Key</label>
								</div>	
								<div class="col-md-4">
									<input type="text" name="stripe_api_key" class="form-control" value="<?php echo $setting->stripe_api_key?>" placeholder="<?php echo lang('secret_key');?>" />
								</div>
							  </div>		
							</div>
							
						</div>
						<div id="tab-4">
								
								<div class="form-group">
								  <div class="row">
									<div class="col-md-4">
										<label><?php echo lang('smtp_mail') ?> </label>
										<input type="text" name="smtp_mail" value="<?php echo set_value('smtp_mail',@$setting->smtp_mail)?>" class="form-control" />
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-4">
										<label><?php echo lang('smtp_host') ?> </label>
										<input type="text" name="smtp_host" value="<?php echo set_value('smtp_host',@$setting->smtp_host)?>" class="form-control" />
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-4">
										<label><?php echo lang('smtp_user') ?> </label>
										<input type="text" name="smtp_user" value="<?php echo set_value('smtp_user',@$setting->smtp_user)?>" class="form-control" />
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-4">
										<label><?php echo lang('smtp_pass') ?> </label>
										<input type="password" name="smtp_pass" value="<?php echo set_value('smtp_pass',@$setting->smtp_pass)?>" class="form-control" />
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-4">
										<label><?php echo lang('smtp_port') ?> </label>
										<input type="text" name="smtp_port" value="<?php echo set_value('smtp_port',@$setting->smtp_port)?>" class="form-control" />
									</div>	
								  </div>		
								</div>
								
						</div>
						<div id="tab-6"> 
							<div class="form-group">
								  <div class="row">
									<div class="col-md-4">
										<a href="<?php echo site_url('admin/settings/export')?>" class="btn btn-success"> <i class="fa fa-download"></i> <?php echo lang('export_database') ?></a>
									</div>	
								  </div>		
								</div>
						</div>
						<div id="tab-7"> 
								<div class="form-group">
								  <div class="row">
									<div class="col-md-4">
										<b><?php echo lang('paypal');?></b>
									</div>
									<div class="col-md-4">
										<input type="checkbox" name="paypal" value="1" <?php echo ($setting->paypal==1)?'checked="checked"':'';?> />
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-4">
										<b><?php echo lang('stripe');?></b>
									</div>
									<div class="col-md-4">
										<input type="checkbox" name="stripe" value="1" <?php echo ($setting->stripe==1)?'checked="checked"':'';?>/>
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-4">
										<b><?php echo lang('pay_on_arrival');?></b>
									</div>
									<div class="col-md-4">
										<input type="checkbox" name="pay_on_arrival" value="1" <?php echo ($setting->pay_on_arrival==1)?'checked="checked"':'';?> />
									</div>	
								  </div>		
								</div>
						</div>
						<div id="tab-8"> 
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<b><?php echo lang('facebook');?></b>
									</div>
									<div class="col-md-10">
										<input type="text" name="facebook_link" class="form-control" value="<?php echo $setting->facebook_link;?>" />
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<b><?php echo lang('twitter');?></b>
									</div>
									<div class="col-md-10">
										<input type="text" name="twitter_link" class="form-control" value="<?php echo $setting->twitter_link;?>" />
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<b><?php echo lang('google_plus');?></b>
									</div>
									<div class="col-md-10">
										<input type="text" name="google_plus_link" class="form-control" value="<?php echo $setting->google_plus_link;?>" />
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<b><?php echo lang('linkedin');?></b>
									</div>
									<div class="col-md-10">
										<input type="text" name="linkedin_link" class="form-control" value="<?php echo $setting->linkedin_link;?>" />
									</div>	
								  </div>		
								</div>
						</div>
						
						<div id="tab-9"> 
							
								<legend><?php echo lang('content');?></legend>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<b><?php echo lang('content_section');?> <?php echo lang('title');?></b>
									</div>
									<div class="col-md-4">
										<input type="text" name="content_section_title" class="form-control" value="<?php echo @$setting->content_section_title;?>" />
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<b><?php echo lang('content_section');?> <?php echo lang('description');?></b>
									</div>
									<div class="col-md-8">
										<textarea name="content_section_description" class="form-control redactor" ><?php echo @$setting->content_section_description;?></textarea>
									</div>	
								  </div>		
								</div>
							
								
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<b><?php echo lang('meta_description');?> </b>
									</div>
									<div class="col-md-8">
										<textarea name="meta_description" class="form-control"><?php echo $setting->meta_description?></textarea>
									</div>	
								  </div>		
								</div>
								<div class="form-group">
								  <div class="row">
									<div class="col-md-2">
										<b><?php echo lang('meta_keywords');?> </b>
									</div>
									<div class="col-md-8">
										<textarea name="meta_keywords" class="form-control"><?php echo $setting->meta_keywords?></textarea>
									</div>	
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="<?php echo base_url('assets/admin/plugins/iCheck/icheck.min.js')?>" type="text/javascript"></script>		
<script type="text/javascript" src="<?php echo base_url('assets/admin/plugins/colorpicker/bootstrap-colorpicker.min.js');?>"></script>		
<script type="text/javascript" src="<?php echo base_url('assets/admin/plugins/redactor/redactor.min.js');?>"></script>		
<script src="<?php echo base_url('assets/admin/plugins/clockpicker/bootstrap-clockpicker.min.js')?>" type="text/javascript"></script>		
<script src="<?php echo base_url('assets/admin/plugins/multiselect/js/jquery.multi-select.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/admin/plugins/multiselect/js/jquery.quicksearch.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/admin/plugins/responsivetabs/jquery.responsiveTabs.min.js')?>" type="text/javascript"></script>

<script src="<?php echo base_url('assets/admin/plugins/daterangepicker/daterangepicker.js')?>"></script>
<script>
$(function() {
	$(".colorpicker").colorpicker();
	$(".colorpicker2").colorpicker();
	$('.clockpicker').clockpicker({donetext:'Done'});
	$('#responsiveTabsDemo').responsiveTabs({
    	startCollapsed: 'accordion'
	});
	$('#reservationtime').daterangepicker({
        timePicker: true,
		timePickerIncrement: 30,
        locale: {
            format: 'YYYY-MM-DD'
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
</script>