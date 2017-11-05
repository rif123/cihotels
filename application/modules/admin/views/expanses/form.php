<link rel="stylesheet" href="<?php echo base_url('assets/admin/') ?>/plugins/datepicker/datepicker3.css" />
  <?php  $seg= $this->uri->segment(4);?>
<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
           </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li><a href="<?php echo site_url('admin/expenses') ?>"> <?php echo lang('expenses')?> </a></li>
            <li class="active"><?php echo (empty($seg))?lang('add'):lang('edit');?></li>
          </ol>
</section>


<section class="content">
    	 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
					
				<form method="post" action="<?php echo site_url('admin/expenses/form/'.$id); ?>" enctype="multipart/form-data">	
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('date') ?></label>
                      		<?php
								$data	= array('name'=>'date', 'value'=>set_value('date', $date), 'class'=>'form-control datepicker', 'autocomplete'=>'off');
								echo form_input($data); ?>
						</div>	
					  </div>		
                    </div>
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
                      		<label><?php echo lang('expenses_category') ?></label>
                      		<select name="expanses_category_id" class="form-control">
								<option value="">--Select Expenses Category--</option>
								<?php foreach($expenses_category as $new){?>
									<option value="<?php echo $new->id?>" <?php echo ($new->id==$expanses_category_id)?'selected="selected"':''?> ><?php echo $new->name?></option>
								<?php } ?>
							</select>
						</div>	
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('amount') ?></label>
                      		<input type="number" name="amount" class="form-control" value="<?php echo set_value('amount',$amount)?>" />
						</div>	
						
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('attachment') ?></label>
                      		<input type="file" name="attachment" class="form-control" />
							<input type="hidden" name="old_attachment"  value="<?php echo $attachment?>"/>
						</div>	
					  	<div class="col-md-4" style="padding-top:20px;">
						<?php if(!empty($attachment)){?>
							<a href="<?php echo base_url('assets/admin/uploads/images/'.$attachment)?>" download class="btn btn-info" ><i class="fa fa-download"></i> <?php echo lang('download')?> </a>
							<?php } ?>
						</div>
					  </div>		
                    </div>
					<div class="form-group">
					  <div class="row">
						<div class="col-md-4">
                      		<label><?php echo lang('remarks') ?></label>
                      		<textarea name="remarks" class="form-control"><?php echo set_value('remarks',$remarks)?></textarea>
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
<script src="<?php echo base_url('assets/admin/') ?>/plugins/datepicker/bootstrap-datepicker.js"></script>
<script>
$(function() {
	$('.datepicker').datepicker({
      	todayHighlight: true,
		autoclose: true,
	   format: 'yyyy-mm-dd',
    });
});
</script>