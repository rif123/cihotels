<link rel="stylesheet" href="<?php echo base_url('assets/front/') ?>/js/datepicker3.css"/>  
<?php $room_types_all		= $this->homepage_model->get_room_types_all();?>
<div class="banner">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <?php 
          $slide_index = 0 ;
          foreach($banners as $img):?>  
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
          foreach($banners as $img):?>      
              <div class="item <?php echo ($slide_img_index == 0 ) ? 'active' : ''; ?>">
                <img src="<?php echo base_url('assets/admin/uploads/banners/'.$img->image)?>" class="img-responsive" alt="<?php echo $img->name?>" style="width:100%" height="100%;" />
              </div>
          <?php 
          $slide_img_index++;
          endforeach; 
          ?>
        </div>
        
        <div class="container">
          <div class="carousel-content hidden-xs">
            <div class="col-md-6 banner-left">
        		<h3><?php echo $img->name?></h3>
        		<p><?php echo $img->description?></p>
        	</div>
            <div class="col-md-6 banner-right">
        		<h3><span><?php echo lang('make_reservation')?></span></h3>
                <form method="get" action="<?php echo site_url('front/book/index')?>">
            		<div class="reservation">

                <div class="keywords">
   							<select name="building" id="country2" onchange="change_country(this.value)" class="frm-field required">
                    <option hidden="hidden" value="">Gedung</option>
                    <?php 
                        foreach ($listBuilding as $key => $val) {
                            echo "<option value='".$val->idBuilding."'>".$val->nameBuilding."</option>";
                        }
                    ?>
                </select>
    					</div>
                        <br>
                        
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
                    <!--
            				<div class="reservation-grid-right">
            					<div class="section_room">
				  		          <span class="fa fa-users"></span>
            						<select name="kids" id="country3" onchange="change_country(this.value)" class="frm-field required">
                            <option hidden="hidden">Kids</option>
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
                    -->
            				<div class="clearfix"> </div>
            			</div>
                        <input type="hidden" name="room_type" value="<?php echo @$_GET['room_type']?>" />
            			<div class="keywords">	
				   	         <input type="submit" value="Search">
            			</div>
            		</div>
                </form>
        	</div>
        </div>
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
	<div class="clearfix"> </div>
</div>
<script src="<?php echo base_url('assets/admin/') ?>/plugins/datepicker/bootstrap-datepicker.js"></script>		
<script>
$(function() {
	$('.datepicker1').datepicker({
      	todayHighlight: true,
		autoclose: true,
	    format: 'yyyy-mm-dd',
        orientation: "bottom",
	    startDate: new Date(),
	 // endDate : new Date('2014-08-08'),
    }).on('changeDate', function (selected) {
   		$('.datepicker2').focus();
	});;
	$('.datepicker2').datepicker({
      	todayHighlight: true,
		autoclose: true,
	    format: 'yyyy-mm-dd',
        orientation: "bottom",
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
</script>