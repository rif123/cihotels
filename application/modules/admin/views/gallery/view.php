<link href="<?php echo base_url('assets/admin/plugins/lightbox/simplelightbox.min.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/admin/plugins/lightbox/demo.css')?>" rel="stylesheet" type="text/css" />
<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
           </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
			<li><a href="<?php echo site_url('admin/gallery') ?>"> <?php echo lang('gallery')?> </a></li>
            <li class="active"><?php echo lang('view');?></li>
          </ol>
</section>

<section class="content">
    	 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
					
					<div class="form-group">
					  <div class="row">
						<div class="col-md-3">
                      		<label><?php echo lang('title') ?></label>
                      	</div>	
						<div class="col-md-3">
                      			<?php echo $gallery->title?>
						</div>	
					  </div>		
                    </div>
					<div class="icontainer ">	
							<div class="gallery ">	
										<?php if(!empty($images)){
											foreach($images as $new){
										?>
										<a href="<?php echo base_url('assets/admin/uploads/gallery/full/'.$new->image)?>"  ><img src="<?php echo base_url('assets/admin/uploads/gallery/thumbnails/'.$new->image)?>" alt="" title="<?php echo $new->caption?>"  width="205" height="155" /></a>
										<?php	 } 
											}
										?>
										
										
										
							</div>
						</div>
							 </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>
<script src="<?php echo base_url('assets/admin/plugins/lightbox/simple-lightbox.js')?>" type="text/javascript"></script>		
<script type="text/javascript">
$(function(){
		var $gallery = $('.gallery a').simpleLightbox();
		
		$gallery.on('show.simplelightbox', function(){
			console.log('Requested for showing');
		})
		.on('shown.simplelightbox', function(){
			console.log('Shown');
		})
		.on('close.simplelightbox', function(){
			console.log('Requested for closing');
		})
		.on('closed.simplelightbox', function(){
			console.log('Closed');
		})
		.on('change.simplelightbox', function(){
			console.log('Requested for change');
		})
		.on('next.simplelightbox', function(){
			console.log('Requested for next');
		})
		.on('prev.simplelightbox', function(){
			console.log('Requested for prev');
		})
		.on('nextImageLoaded.simplelightbox', function(){
			console.log('Next image loaded');
		})
		.on('prevImageLoaded.simplelightbox', function(){
			console.log('Prev image loaded');
		})
		.on('changed.simplelightbox', function(){
			console.log('Image changed');
		})
		.on('nextDone.simplelightbox', function(){
			console.log('Image changed to next');
		})
		.on('prevDone.simplelightbox', function(){
			console.log('Image changed to prev');
		})
		.on('error.simplelightbox', function(e){
			console.log('No image found, go to the next/prev');
			console.log(e);
		});
	});


</script>

 