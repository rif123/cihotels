<?php 
							$coupon_data	=	$this->session->userdata('coupon_data');
						  	//price & tax calculation
							 $nights	=	GetDays($_POST['check_in'],$_POST['check_out'])-1;	
							 
							 $base_price	=	get_price($_POST['check_in'],$_POST['check_out'],$_POST['room_type_id'],$_POST['adults'],$_POST['kids']);
							// echo '<pre>'; print_r($base_price);die;
							 if($nights==0){
							 	$nights=1;
							 }
							 //$amount	=	$room_type->base_price * $_GET['adults'] * $nights;	//old
							 $amount	=	$base_price['total_price'];
							 $taxamount	=	get_tax_amount($amount);
							 $amount	=	rate_exchange($amount);
							 
							 $taxamount	=   rate_exchange($taxamount); 
							 $total		=	$amount+$taxamount;
							 if(!empty($_POST['total'])){
							 	$total		=	$_POST['total'];
							 }
						  ?>
						  <input type="hidden"  name="adults"    value="<?php echo $_POST['adults']?>"  id="adults"/>
						  <input type="hidden"  name="nights"    value="<?php echo $nights?>" id="nights" />
						    <input type="hidden"  name="total"     value="<?php echo $total;?>" id="total" />
				<div class="form-group">
					  <div class="row">
						<div class="col-md-12">
							<?php	// echo '<pre>'; print_r($_POST);echo '</pre>';?>
          						<table class="table" border="1">
									<tr>
										<th class="success"><?php echo lang('number_of_rooms')?></th>
										<td class="table-active">1</td>
									</tr>
									<tr>
										<th class="success"><?php echo lang('adults')?></th>
										<td class="table-active"><?php echo @$_POST['adults'];?></td>
									</tr>
									<tr>
										<th class="success"><?php echo lang('kids')?></th>
										<td class="table-active"><?php echo @$_POST['kids'];?></td>
									</tr>
									<tr>
										<th class="success"><?php echo lang('nights')?></th>
										<td class="table-active"><?php echo $nights;?></td>
									</tr>
									<tr>
										<th class="success"><?php echo lang('price_per_night')?></th>
										<td class="table-active">
												<table width="100%" border="0">
														<tr>
															<th>#</th>
															<th><?php echo lang('date');?></th>
															<td align="right"><b><?php echo lang('price');?></b></td>
															 <?php if($base_price['additional_person_amount'] > 0){?>
															<td align="center"><b><?php echo lang('addi_person');?></b></td>
															<td><b><?php echo lang('total')?></b></td>
															<?php } ?>
															
														</tr>
													<?php $i=1;foreach($base_price['price_details'] as $key	=> $val){?>
														<tr>
															<td><?php echo $i?>.</td>
															<td><?php echo date_convert($key)?></td>
															<td align="right"><?php echo $this->session->userdata('currency_sybmol'); ?>  <?php echo rate_exchange($val['price'])?></td>
															 <?php if($val['add_person'] > 0){?>
															<td align="center"><?php echo $val['add_person']; ?> &times;  <?php echo $this->session->userdata('currency_sybmol'); ?> <?php echo rate_exchange($val['add_person_price']); ?> =	<?php echo rate_exchange($val['add_person_price']*$val['add_person']); ?></td>
															<td>  <?php echo $this->session->userdata('currency_sybmol'); ?> <?php echo rate_exchange($val['price']	+ $val['add_person_price']*$val['add_person'])?></td>
															<?php } ?>
															
														</tr>
														<?php $i++;}?>
														<tr>
															<td></td>
															<td align=""><b><?php echo lang('total_price')?></b></td>
															<td align="right"> <b> <?php echo $this->session->userdata('currency_sybmol'); ?> <?php echo rate_exchange($base_price['amount'])?></b></td>
															<?php if($base_price['additional_person_amount'] > 0){?>
															<td align="center"><b><?php echo $this->session->userdata('currency_sybmol'); ?> <?php echo rate_exchange($base_price['additional_person_amount'])?></b></td>
															<td><b><?php echo $this->session->userdata('currency_sybmol'); ?> <?php echo $amount;?></b></td>
															<?php }?>
														</tr>
													</table>
										
										</td>
									</tr>
									<tr>
										<th class="success"><?php echo lang('amount')?></th>
										<td class="table-active"><?php echo $this->session->userdata('currency_sybmol'); ?> <b><?php echo $amount;?></b></td>
									</tr>
									<tr>
										<th class="success"><?php echo lang('taxes')?></th>
										<td class="table-active">
												
													<table width="100%">
													<?php $i=1;foreach($taxes as $t){?>
														<tr>
															<td><?php echo $i?>.</td>
															<td><?php echo $t->name?></td>
															<td><?php echo ($t->type=='Fixed')?$this->session->userdata('currency_sybmol'):''?><?php echo $t->rate?> <?php echo ($t->type=='Percentage')?'%':''?></td>
															<td>= <?php echo $this->session->userdata('currency_sybmol'); ?> <?php echo rate_exchange(get_tax_amount_by_tax($t->id,$amount))?></td>
														</tr>
														<?php $i++;}?>
														<tr>
															<td colspan="3" align=""><b><?php echo lang('total_tax')?></b></td>
															<td>= <b><?php echo $this->session->userdata('currency_sybmol'); ?> <?php echo $taxamount?></b></td>
														</tr>
													</table>
										</td>
									</tr>
									<?php if(!empty($services)){?>
									<tr>
										<th class="success"><?php echo lang('paid_services')?></th>
										<td class="table-active">
											<table width="100%" >
												<?php $i=1;foreach($services as $serv){ 
													$checked='';
													if(!empty($_POST['paid_services'])){
														$checked	=	'';
														if(in_array($serv->id,$_POST['paid_services'])){
															$checked	=	'checked="checked"';
														}
														
													}
												?>
												<tr>
													<td><?php echo $i?></td>
													<td><?php echo $serv->title?></td>
													<td><input type="checkbox" name="paid_services[]" value="<?php echo $serv->id?>" <?php echo $checked;?> class="paid_service" /></td>
													<td><?php echo $this->session->userdata('currency_sybmol'); ?> <?php echo rate_exchange($serv->price)?></td> 
													<td><?php
														$price_type	=	'';
															if($serv->price_type==1){
																$price_type	=	lang('per_person');
															}
															if($serv->price_type==2){
																$price_type	=	lang('per_night');
															}
															if($serv->price_type==3){
																$price_type	=	lang('fixed_price');
															}
															echo $price_type;
														?>
													</td>
												</tr>
												<tr>
													<td colspan="4" style="height:5px"></td>
												</tr>
												<?php $i++;} ?>
											</table>	
										</td>
									</tr>
									<?php } ?>
									<tr>
										<th class="success"><?php echo lang('total_amount')?></th>
										<th class="table-active" id="grand_total"><?php echo $this->session->userdata('currency_sybmol'); ?> <?php echo $total;?></th>
									</tr>
									<tr class="hide">
										<th class="success"><?php echo lang('coupon')?></th>
										<th class="table-active">
											<table>
												<tr>
													<td><input type="text" name="coupon" id="coupon"  placeholder='<?php echo lang('coupon')?>' autocomplete="off" class="form-control" style="width:80%" /></td>
													<td><button type="button" name="coupon_apply" id="coupon_apply" value="coupon_apply" class="btn btn-success"><?php echo lang('apply')?></button></td>
												</tr>
											</table>
											
										</th>
									</tr>
									
								  </table>
		  		
		              	</div>
                   </div>
				  </div>

<script>

$('.paid_service').on('click', function(event){
	  //alert($(this).val()); // alert value
	  
		var total	=	$('#total').val();
		var id		=	$(this).val();
		var nights	=	$('#nights').val();
		var adults	=	$('#adults').val();
		var symb	=	'<?php echo $this->setting->currency_symbol; ?>';
		 if(id){
		 	call_loader();
			if(this.checked == true) {
				$.ajax({
				url: '<?php echo site_url('admin/bookings/add_service_price') ?>',
				type:'POST',
				data:{id:id,total:total,adults:adults,nights:nights},
				success:function(result){
				  if(result){
					$('#total').val(result);
					$('#grand_total').text('');
					$('#grand_total').html(symb+''+result);
				  }
				}
			  });
			
			} else {
			  $.ajax({
				url: '<?php echo site_url('admin/bookings/less_service_price') ?>',
				type:'POST',
				data:{id:id,total:total,adults:adults,nights:nights},
				success:function(result){
				  
				  if(result){
					remove_loader();
					$('#total').val(result);
					$('#grand_total').text('');
					$('#grand_total').html(symb+''+result);
				  }
				  
				}
			  });
		   }
		  remove_loader();	
			
			
		}     
	});
	
	

$('#coupon_apply').on('click', function(event){
	  
		var coupon	=	$('#coupon').val();
		var guest_id	=	$('#guest_id').val();
		//alert(guest_id);return false;
		 if(coupon){
		 	call_loader();
				$.ajax({
				url: '<?php echo site_url('admin/bookings/apply_coupon') ?>',
				type:'POST',
				//data:{coupon:coupon,guest_id:guest_id},
				data:$('#add_form').serialize(),
				success:function(result){
					if(result==1)
					{
						remove_loader();
						get_order_data();
					}
					else
					{
						remove_loader();
						toastr.error(result);
					}
				  	
				}
			  });
			
		  remove_loader();	
			
			
		}     
});	
	
</script>	
						