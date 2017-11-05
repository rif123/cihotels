<link rel="stylesheet" href="<?php echo base_url('assets/admin/') ?>/plugins/datepicker/datepicker3.css">  <?php  $seg= $this->uri->segment(4);?>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<link href="<?php echo base_url('assets/admin/plugins/responsivetabs/responsive-tabs.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/admin/plugins/responsivetabs/style.css')?>" rel="stylesheet" type="text/css" />
<style>
#weekchart {
  width: 100%;
  height: 500px;
}	
#monthchart {
  width: 100%;
  height: 500px;
}	
#yearchart {
  width: 100%;
  height: 500px;
}	
#customchart {
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
            <li class="active"><?php echo lang('coupon_report'); ?></li>
          </ol>
</section>


<section class="content">
         
		 
		  <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title"><?php echo lang('coupon_report'); ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
					<form method="post">
							<div class="form-group">
							  <div class="row">
								<div class="col-md-3 pull-right">
								<select name="coupon" class="form-control" onchange="this.form.submit();">
									<option value="">--<?php echo lang('filter_by_coupon');?>--</option>
									<?php foreach($coupons as $cp){?>
										<option value="<?php echo $cp->code?>" <?php echo ($cp->code==@$_POST['coupon'])?'selected="selected"':''?> ><?php echo $cp->code?></option>
									<?php } ?>
								</select>
								</div>
							  </div>		
							</div>
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
							<div id="customchart"></div>
						</div>
					</div>
				</form>	
					
				 </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->
        </section>


<!-- Resources -->
<script src="<?php echo base_url('assets/admin/plugins/responsivetabs/jquery.responsiveTabs.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/admin/') ?>/plugins/datepicker/bootstrap-datepicker.js"></script>

<!-- Resources -->
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
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
var chart = AmCharts.makeChart( "weekchart", {
  "type": "serial",
  "addClassNames": true,
  "theme": "light",
  "autoMargins": false,
  "marginLeft": 30,
  "marginRight": 8,
  "marginTop": 10,
  "marginBottom": 26,
  "balloon": {
    "adjustBorderColor": false,
    "horizontalPadding": 10,
    "verticalPadding": 8,
    "color": "#ffffff"
  },

  "dataProvider": <?php echo json_encode($weekdata);?>,
  "startDuration": 1,
  "graphs": [ {
    "alphaField": "alpha",
    "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
    "fillAlphas": 1,
    "title": "Amount",
    "type": "column",
    "valueField": "amount",
    "dashLengthField": "dashLengthColumn"
  }, {
    "id": "graph2",
    "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
    "bullet": "round",
    "lineThickness": 3,
    "bulletSize": 7,
    "bulletBorderAlpha": 1,
    "bulletColor": "#FFFFFF",
    "useLineColorForBulletBorder": true,
    "bulletBorderThickness": 3,
    "fillAlphas": 0,
    "lineAlpha": 1,
    "title": "Coupons",
    "valueField": "coupons",
    "dashLengthField": "dashLengthLine"
  } ],
  "categoryField": "date",
  "categoryAxis": {
    "gridPosition": "start",
    "axisAlpha": 0,
    "tickLength": 0
  },
  "export": {
    "enabled": true
  }
} );

//month chart
var chart = AmCharts.makeChart( "monthchart", {
  "type": "serial",
  "addClassNames": true,
  "theme": "light",
  "autoMargins": false,
  "marginLeft": 30,
  "marginRight": 8,
  "marginTop": 10,
  "marginBottom": 26,
  "balloon": {
    "adjustBorderColor": false,
    "horizontalPadding": 10,
    "verticalPadding": 8,
    "color": "#ffffff"
  },

  "dataProvider": <?php echo json_encode($monthdata);?>,
  "startDuration": 1,
  "graphs": [ {
    "alphaField": "alpha",
    "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
    "fillAlphas": 1,
    "title": "Amount",
    "type": "column",
    "valueField": "amount",
    "dashLengthField": "dashLengthColumn"
  }, {
    "id": "graph2",
    "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
    "bullet": "round",
    "lineThickness": 3,
    "bulletSize": 7,
    "bulletBorderAlpha": 1,
    "bulletColor": "#FFFFFF",
    "useLineColorForBulletBorder": true,
    "bulletBorderThickness": 3,
    "fillAlphas": 0,
    "lineAlpha": 1,
    "title": "Coupons",
    "valueField": "coupons",
    "dashLengthField": "dashLengthLine"
  } ],
  "categoryField": "date",
  "categoryAxis": {
    "gridPosition": "start",
    "axisAlpha": 0,
    "tickLength": 0
  },
  "export": {
    "enabled": true
  }
} );


//Year CHart
var chart = AmCharts.makeChart( "yearchart", {
  "type": "serial",
  "addClassNames": true,
  "theme": "light",
  "autoMargins": false,
  "marginLeft": 30,
  "marginRight": 8,
  "marginTop": 10,
  "marginBottom": 26,
  "balloon": {
    "adjustBorderColor": false,
    "horizontalPadding": 10,
    "verticalPadding": 8,
    "color": "#ffffff"
  },

  "dataProvider": <?php echo json_encode($yeardata);?>,
  "startDuration": 1,
  "graphs": [ {
    "alphaField": "alpha",
    "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
    "fillAlphas": 1,
    "title": "Amount",
    "type": "column",
    "valueField": "amount",
    "dashLengthField": "dashLengthColumn"
  }, {
    "id": "graph2",
    "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
    "bullet": "round",
    "lineThickness": 3,
    "bulletSize": 7,
    "bulletBorderAlpha": 1,
    "bulletColor": "#FFFFFF",
    "useLineColorForBulletBorder": true,
    "bulletBorderThickness": 3,
    "fillAlphas": 0,
    "lineAlpha": 1,
    "title": "Coupons",
    "valueField": "coupons",
    "dashLengthField": "dashLengthLine"
  } ],
  "categoryField": "date",
  "categoryAxis": {
    "gridPosition": "start",
    "axisAlpha": 0,
    "tickLength": 0
  },
  "export": {
    "enabled": true
  }
} );

//Custom Chart
var chart = AmCharts.makeChart( "customchart", {
  "type": "serial",
  "addClassNames": true,
  "theme": "light",
  "autoMargins": false,
  "marginLeft": 30,
  "marginRight": 8,
  "marginTop": 10,
  "marginBottom": 26,
  "balloon": {
    "adjustBorderColor": false,
    "horizontalPadding": 10,
    "verticalPadding": 8,
    "color": "#ffffff"
  },

  "dataProvider": <?php echo json_encode($customdata);?>,
  "startDuration": 1,
  "graphs": [ {
    "alphaField": "alpha",
    "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
    "fillAlphas": 1,
    "title": "Amount",
    "type": "column",
    "valueField": "amount",
    "dashLengthField": "dashLengthColumn"
  }, {
    "id": "graph2",
    "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
    "bullet": "round",
    "lineThickness": 3,
    "bulletSize": 7,
    "bulletBorderAlpha": 1,
    "bulletColor": "#FFFFFF",
    "useLineColorForBulletBorder": true,
    "bulletBorderThickness": 3,
    "fillAlphas": 0,
    "lineAlpha": 1,
    "title": "Coupons",
    "valueField": "coupons",
    "dashLengthField": "dashLengthLine"
  } ],
  "categoryField": "date",
  "categoryAxis": {
    "gridPosition": "start",
    "axisAlpha": 0,
    "tickLength": 0
  },
  "export": {
    "enabled": true
  }
} );
</script>