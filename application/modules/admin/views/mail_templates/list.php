<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
            <small><?php echo lang('common_list')?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
		    <li class="active"><?php echo lang('mail_templates');?></li>
          </ol>
</section>


<section class="content">
         <div class="row hide">
		 	<div class="col-md-12">
				<div class="btn-group pull-right">
				    <a class="btn btn-default" href="<?php echo site_url('admin/mail_templates/form');?>"><i class="fa fa-plus"></i> <?php echo lang('add_mail_template');?></a>

				</div>

			</div>
		 </div>
		 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title"><?php echo lang('mail_templates');?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
					
				<?php if(count($templates) > 0): ?>
				<table class="table table-striped">
					<thead>
						<tr>
							<th><?php echo lang('subject');?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($templates as $template): ?>
						<tr class="gc_row">
							<td><?php echo $template['name']; ?></td>
							<td>
								<span class="btn-group pull-right">
									<a class="btn btn-primary" href="<?php echo site_url('admin/mail_templates/form/'.$template['id']);?>"><i class="fa fa-edit"></i> <?php echo lang('edit');?></a>
								</span>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
				<?php endif; ?>

				 </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>





<script type="text/javascript">
function areyousure()
{
    return confirm('<?php echo lang('confirm_are_you_sure');?>');
}
</script>