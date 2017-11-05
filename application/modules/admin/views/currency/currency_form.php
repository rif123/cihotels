<link href="<?php echo base_url('assets/admin/plugins/iCheck/all.css')?>" rel="stylesheet" type="text/css" />
<?php  $seg= $this->uri->segment(4);?>
<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li><a href="<?php echo site_url('admin/currency') ?>"> <?php echo lang('currency') ?></a></li>
            <li class="active"><?php echo (empty($seg))?lang('add'):lang('update');?></li>
          </ol>
</section>


<section class="content">
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
					<form method="post" action="<?php echo site_url('admin/currency/form/'.$id)?>" enctype="multipart/form-data">
					<fieldset>
							
							<div class="form-group">
							  <div class="row">
								<div class="col-md-4">
								<label for="name"><?php echo lang('country');?></label>
									<input type="text" name="name" value="<?php echo $name?>" class="form-control" />

								</div>	
							  </div>		
							</div>
							
							
							<div class="form-group">
							  <div class="row">
								<div class="col-md-4">
								<label for="name">ISO ALPHA2</label>
									<input type="text" name="iso_alpha2" value="<?php echo $iso_alpha2?>" class="form-control" />

								</div>	
							  </div>		
							</div>
							
							
							
							<div class="form-group">
							  <div class="row">
								<div class="col-md-4">
								<label for="name">ISO ALPHA3</label>
									<input type="text" name="iso_alpha3" value="<?php echo $iso_alpha3?>" class="form-control" />

								</div>	
							  </div>		
							</div>
							
							<div class="form-group">
							  <div class="row">
								<div class="col-md-4">
								<label for="name">ISO NUMERIC</label>
									<input type="text" name="iso_numeric" value="<?php echo $iso_numeric?>" class="form-control" />

								</div>	
							  </div>		
							</div>
							
							
							
							<div class="form-group">
							  <div class="row">
								<div class="col-md-4">
								<label for="name"><?php echo lang('currency_code');?></label>
									<input type="text" name="currency_code" value="<?php echo $currency_code?>" class="form-control" />

								</div>	
							  </div>		
							</div>
							
							
							
							<div class="form-group">
							  <div class="row">
								<div class="col-md-4">
								<label for="name"><?php echo lang('currency_name');?></label>
									<input type="text" name="currency_name" value="<?php echo $currency_name?>" class="form-control" />

								</div>	
							  </div>		
							</div>
							
							
							
							<div class="form-group">
							  <div class="row">
								<div class="col-md-4">
								<label for="name"><?php echo lang('currency_symbol');?></label>
									<input type="text" name="currrency_symbol" value="<?php echo $currrency_symbol?>" class="form-control" />

								</div>	
							  </div>		
							</div>
							
							<div class="form-group">
							  <div class="row">
								<div class="col-md-4">
								<label for="name"><?php echo lang('flag');?></label>
								<input type="file" name="flag" class="form-control" />
								</div>	
								<div class="col-md-2" style="padding-top:30px;">
									<?php if(!empty($flag)){?>
										<img src="<?php echo base_url('assets/admin/uploads/flags/'.$flag)?>" style="height:20px; width:30px;" />
									<?php } ?>
								</div>
							  </div>		
							</div>
														
							<div class="form-group">
							  <div class="row">
								<div class="col-md-4">
								<label for="name"><?php echo lang('status');?></label>
									<input type="checkbox" name="status" value="1"  <?php echo ($status==1)?'checked="checked"':'';?> />

								</div>	
								
							  </div>		
							</div>
					<div class="form-actions">
						<button type="submit" class="btn btn-primary"><?php echo lang('save');?></button>
					</div>
					</form>



				 </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>


<script src="<?php echo base_url('assets/admin/plugins/iCheck/icheck.min.js')?>" type="text/javascript"></script>
<script type="text/javascript">
$('form').submit(function() {
	$('.btn').attr('disabled', true).addClass('disabled');
});
</script>
<script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>