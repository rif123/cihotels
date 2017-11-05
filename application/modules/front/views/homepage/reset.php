<div class="rooms-rates">
				<div class="container">
					<h3 class="tittle"><?php echo lang('reset_password')?></h3>
					
					<div class="col-sm-12">
					  <div class="panel panel-primary " >
						<div class="panel-heading header-panal" >
						  <h3 class="panel-title"> <?php echo lang('reset_password')?> </h3>
						 
						</div>
						<div class="panel-body">
								<form method="post" enctype="multipart/form-data">
									<div class="form-group">
									  <div class="row">
										<div class="col-md-2">
											<label><?php echo lang('password') ?></label>
										</div>
										<div class="col-md-4">
											<?php
												$data	= array('name'=>'password', 'value'=>'', 'class'=>'form-control');
												echo form_password($data); ?>
										</div>	
										<div class="col-md-2">
											<label><?php echo lang('password_confirm') ?></label>
										</div>
										<div class="col-md-4">
											<?php
												$data	= array('name'=>'confirm', 'value'=>'', 'class'=>'form-control');
												echo form_password($data); ?>
										</div>	
									  </div>		
									</div>
									
									<div class="form-group">
									  <div class="row">
										<div class="col-md-2">
										</div>
										<div class="col-md-4">
											<input class="btn btn-theme" type="submit" value="<?php echo lang('update')?>"/>
										</div>	
										
									</div>
								
							</form>
						
						</div>
					  </div>
					</div>
					
				</div>
			</div>
</div>