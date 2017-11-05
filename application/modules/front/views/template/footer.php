<!-- footer -->
<div class="footer">
	<div class="container">
		<div class="footer-grids">
			<div class="col-md-3 footer-grid">
                <h4><?php echo lang('get_in_touch'); ?></h4>
				<p><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> <?php echo $this->setting->address?></p>
				<p><a href="mailto:<?php echo $this->setting->email?>"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> <?php echo $this->setting->email?></a></p>
				<p><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span><?php echo $this->setting->phone?></p>
			</div>
			<?php echo footer_menu('footer'); //Dynamic Menus?>
			<div class="clearfix"> </div>
		</div>
		<div class="footer-copy">
			<p>&copy; <?php echo date('Y')?> <?php echo $this->setting->footer_text ?></p>
            <div class="social-icons">
				<?php if(!empty($this->setting->facebook_link)){?>
				<a href="<?php echo $this->setting->facebook_link?>" target="_blank"><i class="icon"></i></a>
				<?php } ?>
				<?php if(!empty($this->setting->twitter_link)){?>
				<a href="<?php echo $this->setting->twitter_link?>" target="_blank"><i class="icon1"></i></a>
				<?php } ?>
				<?php if(!empty($this->setting->google_plus_link)){?>
				<a href="<?php echo $this->setting->google_plus_link?>" target="_blank"><i class="icon2"></i></a>
				<?php } ?>
				<?php if(!empty($this->setting->linkedin_link)){?>
				<a href="<?php echo $this->setting->linkedin_link?>" target="_blank"><i class="icon3"></i></a>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<!-- //footer -->
<script src="<?php echo base_url('assets/admin/plugins/toastr')?>/toastr.min.js"></script>	

<script>
function remove_loader()
{
	$('#overlay1').remove();
}
function call_loader(){
	
	if($('#overlay1').length == 0 ){
		var over = '<div id="overlay1">' +
						'<img  style="padding-top:300px; margin: 0 auto; " class="img-responsive " id="loading" src="<?php echo base_url('assets/admin/dist/img/ajax-loader.gif')?>"></div>';
		
		$(over).appendTo('body');
	}
}

$(".lang").click(function(e){
	  //alert(this.id);return false;
	  call_loader();
	$.ajax({
		url: '<?php echo site_url('front/homepage/switch_language') ?>',
		type:'POST',
		data:{id:this.id},
		success:function(result){
		//alert(result);return false;
			  if(result==1)
				{
					location.reload(); 
			   }
				else
				{
					remove_loader();
				}
		
		 }
	  });
	
	event.preventDefault();
});


    $(function(){
    $(".dropdown").hover(            
            function() {
                $('.dropdown-menu', this).stop( true, true ).fadeIn("fast");
                $(this).toggleClass('open');
                $('b', this).toggleClass("caret caret-up");                
            },
            function() {
                $('.dropdown-menu', this).stop( true, true ).fadeOut("fast");
                $(this).toggleClass('open');
                $('b', this).toggleClass("caret caret-up");                
            });
    });
    
</script>
<?php
			if(function_exists('validation_errors') && validation_errors() != '')
					{
						$error  = validation_errors();
					}	
		 if ($this->session->flashdata('message')):?>
			<script>
				toastr.success("<?php echo preg_replace( "/\r|\n/", "", strip_tags($this->session->flashdata('message')));?>");
			</script>
		<?php endif;?>
		
		<?php if ($this->session->flashdata('error')):?>
			<script>
				toastr.error("<?php echo preg_replace( "/\r|\n/", "", strip_tags($this->session->flashdata('error')));?>");
			</script>
		<?php endif;?>
		
		<?php if (!empty($error)):?>
			<script>
				toastr.error("<?php echo preg_replace( "/\r|\n/", "", strip_tags($error) );?>");
			</script>
		<?php endif;?>
</body>
</html>