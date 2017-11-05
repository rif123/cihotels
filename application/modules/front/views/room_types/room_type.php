<link rel="stylesheet" href="<?php echo base_url('assets/front/') ?>/js/datepicker3.css">  

<!-- breadcrumbs -->
<div class="services-top-breadcrumbs">
	<div class="container">
		<div class="services-top-breadcrumbs-right">
			<ul>
				<li><a href="<?php echo site_url()?>">Home</a> <i>/</i></li>
                <li><a href="<?php echo site_url('rooms')?>">Rooms</a> <i>/</i></li>
				<li><?php echo $room_type->title ?></li>
			</ul>
		</div>
		<div class="services-top-breadcrumbs-left">
			<h3><?php echo $room_type->title ?></h3>
		</div>
		<div class="clearfix"> </div>
	</div>
</div>
<!-- //breadcrumbs -->

<?php $rt_image	=	get_room_type_featured_image_medium($room_type->id);?>

<div class="testimonials">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                      <?php 
                      $slide_index = 0 ;
                      foreach($images as $img):?>  
                      <li data-target="#myCarousel" data-slide-to="<?php echo $slide_index; ?>" <?php echo ($slide_index == 0 ) ? 'class="active"' : ''; ?>></li>
                      <?php 
                      $slide_index++ ;
                      endforeach;
                      ?>
                    </ol>
                
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        
                      <?php 
                      $slide_img_index = 0;
                      foreach($images as $img):?>      
                          <div class="item <?php echo ($slide_img_index == 0 ) ? 'active' : ''; ?>">
                            <img src="<?php echo base_url('assets/admin/uploads/gallery/medium/'.$img->image)?>" class="img-responsive" style="width:100%;height:400px;" />
                          </div>
                      <?php 
                      $slide_img_index++;
                      endforeach; 
                      ?>
                    </div>
                    
                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                </div>
                <br />
                
                <?php if($room_type->description): ?>
                <p><?php echo $room_type->description ?></p>
                <?php endif; ?>
                
                <h4 class="sub-title"><?php echo lang('amenities');?></h4>
				<ul class="list-inline">
				<?php foreach($amenities as $am):?>
					<li> 
                        <img src="<?php echo base_url('assets/admin/uploads/amenities/'.$am->image)?>" class="img-responsive gray" width="32"  title="<?php echo $am->name?>" data-toggle="tooltip"/> 
                    </li>
				<?php endforeach; ?>	
				</ul>
            </div>
            <div class="col-md-4">
                <h4><?php echo lang('start')?> <?php echo lang('from')?> <?php echo $this->session->userdata('currency_sybmol'); ?> <?php echo rate_exchange($room_type->base_price)?>  /<?php echo lang('per_night');?></h4>
        		<h3><span><?php echo lang('make_reservation')?></span></h3>
                <br />
                <form method="get" action="<?php echo site_url('front/book/index')?>" id="checkform">
				<input type="hidden" value="<?php echo $room_type->id?>" name="room_type">
				<input type="hidden" value="" name="checked" class="chk">
            		<div class="reservation">
                        <div class="keywords">
   							<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
   							<input type="text" class="datepicker1" name="date_from" placeholder="<?php echo lang('check_in');?>" value="<?php echo @$_GET['date_from']?>" required=" " />	
    					</div>
                        <div class="keywords">
   							<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
   							<input type="text" class="datepicker2" name="date_to" placeholder="<?php echo lang('check_out');?>" value="<?php echo @$_GET['date_to']?>" required=" " />	
    					</div>
            			<div class="reservation-grids">
            				<div class="reservation-grid-left">
            					<div class="section_room">
            						<span class="fa fa-user"> </span>
            						<select name="adults" id="country2" onchange="change_country(this.value)" class="frm-field required">
                                        <option hidden="hidden">Adults</option>
            							<option value="1">1</option>         
            							<option value="2">2</option>
            							<option value="3">3</option>
            							<option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
            						</select>
            					</div>
            				</div>
            			
            				<div class="clearfix"> </div>
            			</div>
            			<div class="keywords">	
				   	         <input type="button" value="Check Availabity" name="check" id="checkAvailabel"/>
            			</div>
            		</div>
                </form>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<style>
.keywords input[type="button"] {
    width: 100%;
    padding: 10px 0;
    border: none;
    color: #fff;
    text-transform: uppercase;
    font-size: 1em;
    outline: none;
    background: #F25086;
    margin-top: 10px;
}
</style>
<script src="<?php echo base_url('assets/admin/') ?>/plugins/datepicker/bootstrap-datepicker.js"></script>		
<script>
    var room_type = "<?php echo $room_type->id?>";
    $(function(){
		$('#checkAvailabel').click(function(){
        	call_loader();
        	$.ajax({
        		url: SITE_URL+'/front/room_types/check',
        		type:'POST',
        		data:$("#checkform").serialize()+"&room_type="+room_type,
        		success:function(result){
        			  	if(result==1)
        				{
							$('.chk').val(1);
        					remove_loader();
							toastr.success('Available');
							setTimeout(function(){
        						$('#checkform').submit();
							}, 500 );
        			   	} else {
        					remove_loader();
        					toastr.error(result);
        					//$('#err').html(result);
        				}
        		 }
        	  });
		});
        // $( "#checkform" ).submit(function( event ) {
        	
        	  
        // });
        $(function() {
        	$('.datepicker1').datepicker({
              	todayHighlight: true,
        		autoclose: true,
        	    format: 'yyyy-mm-dd',
        	    startDate: new Date(),
        	 // endDate : new Date('2014-08-08'),
            }).on('changeDate', function (selected) {
           		$('.datepicker2').focus();
        	});;
        	$('.datepicker2').datepicker({
              	todayHighlight: true,
        		autoclose: true,
        	   format: 'yyyy-mm-dd',
        	   startDate: new Date(),
            }).on('changeDate', function (selected) {
           		var date1	= $(".datepicker1").datepicker('getDate');
        		var date2	= $(".datepicker2").datepicker('getDate');
        		if(date2<date1){
        			toastr.error('Checkout Date Must Be Greater Then Checkout Date');
        			$('.datepicker2').val('');
        			$('.datepicker2').focus();
        		}
        	});
        });
        
     });   	

</script>				