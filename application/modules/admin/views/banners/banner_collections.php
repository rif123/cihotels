<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
            <small><?php echo lang('list')?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li class="active"><?php echo lang('banner_collections')?></li>
          </ol>
</section>


<section class="content">
         <div class="row">
		 	<div class="col-md-12" style="padding:20px;">
				<div class="btn-group pull-right">
					<a  class="btn btn-default" href="<?php echo site_url('admin/banners/banner_collection_form'); ?>"><i class="fa fa-plus"></i> <?php echo lang('add_new_banner_collection');?></a>

				</div>

			</div>
		 </div>
		 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title"><?php echo lang('banner_collections')?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
						<table class="table table-striped">
	<thead>
		<tr>
			<th><?php echo lang('name');?></th>
			<th></th>
		</tr>
	</thead>
	<?php echo (count($banner_collections) < 1)?'<tr><td style="text-align:center;" colspan="5">'.lang('no_banner_collections').'</td></tr>':''?>
	<?php if ($banner_collections): ?>
	<tbody>
	<?php

	foreach ($banner_collections as $banner_collection):?>
		<tr>
			<td><?php echo $banner_collection->name;?></td>
			<td>
				<div class="btn-group" style="float:right">
					<a class="btn btn-default" href="<?php echo site_url('admin/banners/banner_collection/'.$banner_collection->banner_collection_id);?>"><i class="fa fa-file-picture-o "></i> <?php echo lang('banners');?></a>
					
					<a class="btn btn-primary" href="<?php echo site_url('admin/banners/banner_collection_form/'.$banner_collection->banner_collection_id);?>"><i class="fa fa-edit"></i> <?php echo lang('edit');?></a>
					
					<a class="btn btn-danger" href="<?php echo site_url('admin/banners/delete_banner_collection/'.$banner_collection->banner_collection_id);?>" onclick="return areyousure(this);"><i class="icon-trash icon-white"></i> <?php echo lang('delete');?></a>
				</div>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	<?php endif;?>
</table>


				 </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>
