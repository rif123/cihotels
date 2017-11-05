<link rel="stylesheet" href="<?php echo base_url('assets/admin/') ?>/plugins/datepicker/datepicker3.css">  <?php  $seg= $this->uri->segment(4);?>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<link href="<?php echo base_url('assets/admin/plugins/responsivetabs/responsive-tabs.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/admin/plugins/responsivetabs/style.css')?>" rel="stylesheet" type="text/css" />

<style>
#weekchart{
  width: 100%;
  height: 500px;
}
#monthchart{
  width: 100%;
  height: 500px;
}
#yearchart{
  width: 100%;
  height: 500px;
}
#customchart{
  width: 100%;
  height: 500px;
}
.amcharts-export-menu-top-right {
  top: 10px;
  right: 0;
}
.amcharts-chart-div a{display:none !important}
</style>

<section class="content-header">
          <h1>
            <?php echo $page_title; ?>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/dashboard') ?>"><i class="fa fa-dashboard"></i> <?php echo lang('dashboard')?></a></li>
            <li class="active"><?php echo lang('guest_report'); ?></li>
          </ol>
</section>


<section class="content">
         
		 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title"><?php echo lang('guest_report'); ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
					
					<div id="responsiveTabsDemo">
						<ul>
							<li><a href="#tab-1"> <?php echo lang('weekly')?> </a></li>
							<li><a href="#tab-2"> <?php echo lang('monthly')?></a></li>
							<li><a href="#tab-3"> <?php echo lang('yearly')?></a></li>
							<li><a href="#tab-4"> <?php echo lang('custom')?></a></li>
						</ul>
					
						<div id="tab-1">
							<div id="weekchart"></div>
						</div>
						<div id="tab-2">
							<div id="monthchart"></div>
						</div>
						<div id="tab-3">
							<div id="yearchart"></div>
						</div> 
						<div id="tab-4">
							<form method="post">
							<div class="form-group">
							  <div class="row">
								<div class="col-md-4">
									<input type="text" name="from" class="form-control datepicker" placeholder="<?php echo lang('date_from')?>" onchange="this.form.submit();" autocomplete="off" value="<?php echo @$_POST['from']?>" />
								</div>
								<div class="col-md-4">
									<input type="text" name="to" class="form-control datepicker" placeholder="<?php echo lang('date_to')?>" onchange="this.form.submit();" autocomplete="off" value="<?php echo @$_POST['to']?>"/>
								</div>		
							  </div>		
							</div>
							</form>
							<div id="customchart"></div>
						</div>
					</div>
					
					
				 </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>


<!-- Resources -->
<script src="<?php echo base_url('assets/admin/plugins/responsivetabs/jquery.responsiveTabs.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/admin/') ?>/plugins/datepicker/bootstrap-datepicker.js"></script>

<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

<!-- Chart code -->
<script>
$(function() {
	$('#responsiveTabsDemo').responsiveTabs({
    	startCollapsed: 'accordion'
	});
	<?php if(!empty($_POST['from'])){?>
	$('#responsiveTabsDemo').responsiveTabs('activate', 3); // This would open the CUSTOM tab
	<?php } ?>
	$('.datepicker').datepicker({
      	todayHighlight: true,
		autoclose: true,
	   format: 'yyyy-mm-dd',
    });
});
var chart = AmCharts.makeChart("weekchart", {
  "type": "serial",
  "theme": "light",
  "marginRight": 70,
  "dataProvider": <?php echo json_encode($weekdata)?>,
  "valueAxes": [{
    "axisAlpha": 0,
    "position": "left",
    "title": "<?php echo lang('guest_report')?>"
  }],
  "startDuration": 1,
  "graphs": [{
    "balloonText": "<b>[[category]]: [[value]]</b>",
    "fillColorsField": "color",
    "fillAlphas": 0.9,
    "lineAlpha": 0.2,
    "type": "column",
    "valueField": "total"
  }],
  "chartCursor": {
    "categoryBalloonEnabled": false,
    "cursorAlpha": 0,
    "zoomable": false
  },
  "categoryField": "date",
  "categoryAxis": {
    "gridPosition": "start",
    "labelRotation": 45
  },
  "export": {
    "enabled": true
  }

});

var chart = AmCharts.makeChart("monthchart", {
  "type": "serial",
  "theme": "light",
  "marginRight": 70,
  "dataProvider": <?php echo json_encode($monthdata)?>,
  "valueAxes": [{
    "axisAlpha": 0,
    "position": "left",
    "title": "<?php echo lang('guest_report')?>"
  }],
  "startDuration": 1,
  "graphs": [{
    "balloonText": "<b>[[category]]: [[value]]</b>",
    "fillColorsField": "color",
    "fillAlphas": 0.9,
    "lineAlpha": 0.2,
    "type": "column",
    "valueField": "total"
  }],
  "chartCursor": {
    "categoryBalloonEnabled": false,
    "cursorAlpha": 0,
    "zoomable": false
  },
  "categoryField": "date",
  "categoryAxis": {
    "gridPosition": "start",
    "labelRotation": 45
  },
  "export": {
    "enabled": true
  }

});
var chart = AmCharts.makeChart("yearchart", {
  "type": "serial",
  "theme": "light",
  "marginRight": 70,
  "dataProvider": <?php echo json_encode($yeardata)?>,
  "valueAxes": [{
    "axisAlpha": 0,
    "position": "left",
    "title": "<?php echo lang('guest_report')?>"
  }],
  "startDuration": 1,
  "graphs": [{
    "balloonText": "<b>[[category]]: [[value]]</b>",
    "fillColorsField": "color",
    "fillAlphas": 0.9,
    "lineAlpha": 0.2,
    "type": "column",
    "valueField": "total"
  }],
  "chartCursor": {
    "categoryBalloonEnabled": false,
    "cursorAlpha": 0,
    "zoomable": false
  },
  "categoryField": "date",
  "categoryAxis": {
    "gridPosition": "start",
    "labelRotation": 45
  },
  "export": {
    "enabled": true
  }

});

var chart = AmCharts.makeChart("customchart", {
  "type": "serial",
  "theme": "light",
  "marginRight": 70,
  "dataProvider": <?php echo json_encode($customdata)?>,
  "valueAxes": [{
    "axisAlpha": 0,
    "position": "left",
    "title": "<?php echo lang('guest_report')?>"
  }],
  "startDuration": 1,
  "graphs": [{
    "balloonText": "<b>[[category]]: [[value]]</b>",
    "fillColorsField": "color",
    "fillAlphas": 0.9,
    "lineAlpha": 0.2,
    "type": "column",
    "valueField": "total"
  }],
  "chartCursor": {
    "categoryBalloonEnabled": false,
    "cursorAlpha": 0,
    "zoomable": false
  },
  "categoryField": "date",
  "categoryAxis": {
    "gridPosition": "start",
    "labelRotation": 45
  },
  "export": {
    "enabled": true
  }

});
</script>