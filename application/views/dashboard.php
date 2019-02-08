<!-- https://proto.io/freebies/onoff/ -->
<style>
.onoffswitch {
    position: relative; width: 90px;
    -webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;
}
.onoffswitch-checkbox {
    display: none;
}
.onoffswitch-label {
    display: block; overflow: hidden; cursor: pointer;
    border: 2px solid #999999; border-radius: 20px;
}
.onoffswitch-inner {
    display: block; width: 200%; margin-left: -100%;
    transition: margin 0.3s ease-in 0s;
}
.onoffswitch-inner:before, .onoffswitch-inner:after {
    display: block; float: left; width: 50%; height: 30px; padding: 0; line-height: 30px;
    font-size: 14px; color: white; font-family: Trebuchet, Arial, sans-serif; font-weight: bold;
    box-sizing: border-box;
}
.onoffswitch-inner:before {
    content: "Stop";
    padding-left: 10px;
    background-color: #34A7C1; color: #FFFFFF;
}
.onoffswitch-inner:after {
    content: "Start";
    padding-right: 10px;
    background-color: #EEEEEE; color: #999999;
    text-align: right;
}
.onoffswitch-switch {
    display: block; width: 18px; margin: 6px;
    background: #FFFFFF;
    position: absolute; top: 0; bottom: 0;
    right: 56px;
    border: 2px solid #999999; border-radius: 20px;
    transition: all 0.3s ease-in 0s; 
}
.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
    margin-left: 0;
}
.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
    right: 0px; 
}
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #3c8dbc;
}

input:focus + .slider {
  box-shadow: 0 0 1px #3c8dbc;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}


/*-------------------------
	The clocks
--------------------------*/


#clock{
	width:370px;
	/*padding:40px;
	 margin:25px auto 60px; */
	margin:auto;
	padding:8px;
	position:relative;
}

#clock:after{
	content:'';
	position:absolute;
	width:400px;
	height:20px;
	border-radius:100%;
	left:50%;
	margin-left:-200px;
	bottom:2px;
	z-index:-1;
}


#clock .display{
	text-align:center;
	padding: 40px 20px 20px;
	border-radius:6px;
	position:relative;
	/* height: 54px; */
}


/*-------------------------
	Light color theme
--------------------------*/


#clock.light{
	background-color:#f3f3f3;
	color:#272e38;
}

#clock.light:after{
	box-shadow:0 4px 10px rgba(0,0,0,0.15);
}

#clock.light .digits div span{
	background-color:#272e38;
	border-color:#272e38;	
}

#clock.light .digits div.dots:before,
#clock.light .digits div.dots:after{
	background-color:#272e38;
}

#clock.light .alarm{
	background:url('../img/alarm_light.jpg');
}

#clock.light .display{
	background-color:#dddddd;
	box-shadow:0 1px 1px rgba(0,0,0,0.08) inset, 0 1px 1px #fafafa;
}


/*-------------------------
	Dark color theme
--------------------------*/


#clock.dark{
	/* background-color:#272e38; */
	color:#cacaca;
}

#clock.dark:after{
	box-shadow:0 4px 10px rgba(0,0,0,0.3);
}

#clock.dark .digits div span{
	background-color:#cacaca;
	border-color:#cacaca;	
}

#clock.dark .alarm{
	background:url('../img/alarm_dark.jpg');
}

#clock.dark .display{
	background-color:#0f1620;
	box-shadow:0 1px 1px rgba(0,0,0,0.08) inset, 0 1px 1px #2d3642;
}

#clock.dark .digits div.dots:before,
#clock.dark .digits div.dots:after{
	background-color:#cacaca;
}


/*-------------------------
	The Digits
--------------------------*/


#clock .digits div{
	text-align:left;
	position:relative;
	width: 28px;
	height:50px;
	display:inline-block;
	margin:0 4px;
}

#clock .digits div span{
	opacity:0;
	position:absolute;

	-webkit-transition:0.25s;
	-moz-transition:0.25s;
	transition:0.25s;
}

#clock .digits div span:before,
#clock .digits div span:after{
	content:'';
	position:absolute;
	width:0;
	height:0;
	border:5px solid transparent;
}

#clock .digits .d1{			height:5px;width:16px;top:0;left:6px;}
#clock .digits .d1:before{	border-width:0 5px 5px 0;border-right-color:inherit;left:-5px;}
#clock .digits .d1:after{	border-width:0 0 5px 5px;border-left-color:inherit;right:-5px;}

#clock .digits .d2{			height:5px;width:16px;top:24px;left:6px;}
#clock .digits .d2:before{	border-width:3px 4px 2px;border-right-color:inherit;left:-8px;}
#clock .digits .d2:after{	border-width:3px 4px 2px;border-left-color:inherit;right:-8px;}

#clock .digits .d3{			height:5px;width:16px;top:48px;left:6px;}
#clock .digits .d3:before{	border-width:5px 5px 0 0;border-right-color:inherit;left:-5px;}
#clock .digits .d3:after{	border-width:5px 0 0 5px;border-left-color:inherit;right:-5px;}

#clock .digits .d4{			width:5px;height:14px;top:7px;left:0;}
#clock .digits .d4:before{	border-width:0 5px 5px 0;border-bottom-color:inherit;top:-5px;}
#clock .digits .d4:after{	border-width:0 0 5px 5px;border-left-color:inherit;bottom:-5px;}

#clock .digits .d5{			width:5px;height:14px;top:7px;right:0;}
#clock .digits .d5:before{	border-width:0 0 5px 5px;border-bottom-color:inherit;top:-5px;}
#clock .digits .d5:after{	border-width:5px 0 0 5px;border-top-color:inherit;bottom:-5px;}

#clock .digits .d6{			width:5px;height:14px;top:32px;left:0;}
#clock .digits .d6:before{	border-width:0 5px 5px 0;border-bottom-color:inherit;top:-5px;}
#clock .digits .d6:after{	border-width:0 0 5px 5px;border-left-color:inherit;bottom:-5px;}

#clock .digits .d7{			width:5px;height:14px;top:32px;right:0;}
#clock .digits .d7:before{	border-width:0 0 5px 5px;border-bottom-color:inherit;top:-5px;}
#clock .digits .d7:after{	border-width:5px 0 0 5px;border-top-color:inherit;bottom:-5px;}


/* 1 */

#clock .digits div.one .d5,
#clock .digits div.one .d7{
	opacity:1;
}

/* 2 */

#clock .digits div.two .d1,
#clock .digits div.two .d5,
#clock .digits div.two .d2,
#clock .digits div.two .d6,
#clock .digits div.two .d3{
	opacity:1;
}

/* 3 */

#clock .digits div.three .d1,
#clock .digits div.three .d5,
#clock .digits div.three .d2,
#clock .digits div.three .d7,
#clock .digits div.three .d3{
	opacity:1;
}

/* 4 */

#clock .digits div.four .d5,
#clock .digits div.four .d2,
#clock .digits div.four .d4,
#clock .digits div.four .d7{
	opacity:1;
}

/* 5 */

#clock .digits div.five .d1,
#clock .digits div.five .d2,
#clock .digits div.five .d4,
#clock .digits div.five .d3,
#clock .digits div.five .d7{
	opacity:1;
}

/* 6 */

#clock .digits div.six .d1,
#clock .digits div.six .d2,
#clock .digits div.six .d4,
#clock .digits div.six .d3,
#clock .digits div.six .d6,
#clock .digits div.six .d7{
	opacity:1;
}


/* 7 */

#clock .digits div.seven .d1,
#clock .digits div.seven .d5,
#clock .digits div.seven .d7{
	opacity:1;
}

/* 8 */

#clock .digits div.eight .d1,
#clock .digits div.eight .d2,
#clock .digits div.eight .d3,
#clock .digits div.eight .d4,
#clock .digits div.eight .d5,
#clock .digits div.eight .d6,
#clock .digits div.eight .d7{
	opacity:1;
}

/* 9 */

#clock .digits div.nine .d1,
#clock .digits div.nine .d2,
#clock .digits div.nine .d3,
#clock .digits div.nine .d4,
#clock .digits div.nine .d5,
#clock .digits div.nine .d7{
	opacity:1;
}

/* 0 */

#clock .digits div.zero .d1,
#clock .digits div.zero .d3,
#clock .digits div.zero .d4,
#clock .digits div.zero .d5,
#clock .digits div.zero .d6,
#clock .digits div.zero .d7{
	opacity:1;
}


/* The dots */

#clock .digits div.dots{
	width:5px;
}

#clock .digits div.dots:before,
#clock .digits div.dots:after{
	width:5px;
	height:5px;
	content:'';
	position:absolute;
	left:0;
	top:14px;
}

#clock .digits div.dots:after{
	top:34px;
}


/*-------------------------
	The Alarm
--------------------------*/


#clock .alarm{
	width:16px;
	height:16px;
	bottom:20px;
	background:url('../img/alarm_light.jpg');
	position:absolute;
	opacity:0.2;
}

#clock .alarm.active{
	opacity:1;
}


/*-------------------------
	Weekdays
--------------------------*/


#clock .weekdays{
	font-size:12px;
	position:absolute;
	width:100%;
	top:10px;
	left:0;
	text-align:center;
}


#clock .weekdays span{
	opacity:0.2;
	padding:0 10px;
}

#clock .weekdays span.active{
	opacity:1;
}


/*-------------------------
		AM/PM
--------------------------*/


#clock .ampm{
	position:absolute;
	/* bottom:20px; */
	top:22px;
	right:20px;
	font-size:12px;
}

#date
{
	margin-top:70px;
	color:silver;
	font-size:40px;
	border:2px dashed #2E9AFE;
	padding:10px;
	width:500px;
	margin-left:250px;
}
#time
{
	margin-top:20px;
	font-size:130px;
	color:silver;
	border:2px dashed #2E9AFE;
	padding:10px;
	width:700px;
	margin-left:150px;
}
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-dashboard"></i> Time Tracking
        <small>Day Start & End</small>
      </h1>
    </section>
    
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
            <?php 
            $trackInfo=isset($trackInfo[0])?$trackInfo[0]:'';
            $dayStart=isset($trackInfo->day_start)?$trackInfo->day_start:'';
            $dayEnd=isset($trackInfo->day_end)?$trackInfo->day_end:'';
            ?>
              <!-- general form elements -->
                <div class="box box-primary padding">
                    <div class="box-header1">
                        <div id="clock" class="dark">
                        	<label style="color: #333;">Login Time: </label>
                			<div class="display">
                				<div class="weekdays"></div>
                				<div class="ampm"></div>
                				<div class="alarm"></div>
                				<div class="digits"></div>
                			</div>
                		</div>
                    </div><!-- /.box-header -->
                    <form role="form" id="addUser" class="form-horizontal" action="<?php echo base_url() ?>" method="post" role="form">
                        <div class="box-body">
                        <?php 
                        $breaks=isset($breaks)? $breaks:'array()';
                        if($breaks){
                            $breaks=explode(',', $breaks);
                        }
                        ?>
                            <?php 
                            $assignedBreak=false;
                            $firstassigned=false;
                            foreach ($breaks as $break){
                                $breakT=getBreakInfo($break);
                                $break_name=$breakT->break_name;  
                                ?>
                            <div class="form-group col-md-4 tea_box">
                                <label class="control-label col-sm-12 tea" for="email"><?php echo $break_name;?></label>
                                <div class="col-sm-12 text-center">
                                  <div class="onoffswitch1">
                                  <?php 
                                        $res=getBreakInfoByBreakId($break);
                                        $breakStart=isset($res->break_start)? $res->break_start :'';
                                        $breakEnd=isset($res->break_end)? $res->break_end :'';
                                        $breakHours=isset($res->break_hours)? $res->break_hours :'';
                                        $breakStarted=$breakEnded=false;
                                        if(empty($breakHours)){
                                            $breakStarted=true;
                                        }else{
                                            $breakEnded=true;
                                        }
                                        $breakStatus=1;
                                        $checked="";
                                      
                                        if(!empty($breakStart)){
                                            $checked="checked";
                                            $breakStatus=2;
                                        }elseif(empty($breakHours)){
                                            $checked="";
                                        }
                                    ?>
                                    <?php if($breakEnded==false){?>
                                    	<div <?php if($firstassigned==true || $dayEnd){ echo "class='disablediv'";}$firstassigned=true;?>>
                                            <!-- <input type="checkbox" name="onoffswitch<?php echo $break;?>" class="onoffswitch-checkbox" id="daystart<?php echo $break;?>" <?php echo $checked;?>>
                                            <label class="onoffswitch-label" for="daystart<?php echo $break;?>" >
                                                <span class="onoffswitch-inner daystarton" breaktype="<?php echo $break;?>" breakStatus="<?php echo $breakStatus;?>"></span>
                                                <span class="onoffswitch-switch daystartoff"></span>
                                            </label> -->
                                            <label class="switch">
                                              <input type="checkbox" name="onoffswitch<?php echo $break;?>" class="onoffswitch-checkbox" id="daystart<?php echo $break;?>" <?php echo $checked;?>>
                                              <span class="slider round daystarton" breaktype="<?php echo $break;?>" breakStatus="<?php echo $breakStatus;?>"></span>
                                            </label>
                                        </div>
                                </div>
                                </div>
                                            <?php if(!empty($breakStart)){?>
                                            <div class="col-md-12">
                                            		<label>Started : <?php echo displayTime($breakStart);?></label>
                                            </div>
                                            <?php }?>  
                                        <?php }else{
                                            $firstassigned=false;
                                            ?>
                                   </div>
                                </div>  
									<div class="col-md-12">
											<label>Started Time:<?php echo displayTime($breakStart);?></label>
									</div>
									<div class="col-md-12">
											<label>Ended Time: <?php echo displayTime($breakEnd);?></label>  
									</div>
									<div class="col-md-12">
                                		<label>Spend Hours: <?php echo $breakHours;?></label>
                                	</div>                                    	
                                <?php }?>
								</div>
                             <?php 
                             if(!empty($breakStart)){
                                 $assignedBreak=true;
                             }
                            }
                            ?>
                             <div class="row">
                             <div class="form-group">
                             	<div class="col-sm-12 text-center">
                             	<?php if($dayEnd){?>
                             		<label>Logged off Time:<?php echo displayDateTime($dayEnd);?></label>
                             	<?php }else{?>
                             		<a href="javascript:void(0)" class="text-center logoff">
                             			<img alt="Logg Off the Day" height="100px"src="<?php echo base_url().'/assets/images/logoff.png';?>">
                             		</a>
                             		<?php }?>
                             	</div>
                             </div>
                            </div>
                        </div><!-- /.box-body -->
                        </form>
                </div>
            </div>
            <div class="col-md-4">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>    
		
		
    </section>
    
</div>
<script type="text/javascript">
$(function(){
	$('.daystarton').on('click',function(){
		//alert(234324);
		var breaktype=$(this).attr('breaktype');
		var breakStatus=$(this).attr('breakStatus');
		
		var info={
				'breakid':breaktype,
				'breakStatus':breakStatus,
				};
		var res=postdata(info);
		
	});

	
	$(".disablediv *").attr("disabled", "disabled").off('click');
	function postdata(info){
    	var saveData = $.ajax({
    	      type: 'POST',
    	      url: "<?php echo base_url()."ajax/break"; ?>",
    	      data: info,
    	      dataType: "text",
    	      success: function(resultData) { 
    	    	  setTimeout(function(){ 
    	    	  window.location="<?php echo base_url()."dashboard";?>";
    	    	  }, 500);
        	  }
    	});
    	return saveData;
	}

	$('.logoff').on('click',function(){
		var res=$(".daystarton").attr('breakStatus');
		if(res==2){
			alert("Stop the Break");
		}else{
			window.location="<?php echo base_url().'logoff';?>"
		}
	});
});
</script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.0.0/moment.min.js"></script>
<script type="text/javascript">
$(function(){

	// Cache some selectors

	var clock = $('#clock'),
		alarm = clock.find('.alarm'),
		ampm = clock.find('.ampm');

	// Map digits to their names (this will be an array)
	var digit_to_name = 'zero one two three four five six seven eight nine'.split(' ');

	// This object will hold the digit elements
	var digits = {};

	// Positions for the hours, minutes, and seconds
	var positions = [
		'h1', 'h2', ':', 'm1', 'm2', ':', 's1', 's2'
	];

	// Generate the digits with the needed markup,
	// and add them to the clock

	var digit_holder = clock.find('.digits');

	$.each(positions, function(){

		if(this == ':'){
			digit_holder.append('<div class="dots">');
		}
		else{

			var pos = $('<div>');

			for(var i=1; i<8; i++){
				pos.append('<span class="d' + i + '">');
			}

			// Set the digits as key:value pairs in the digits object
			digits[this] = pos;

			// Add the digit elements to the page
			digit_holder.append(pos);
		}

	});

	// Add the weekday names

	var weekday_names = 'MON TUE WED THU FRI SAT SUN'.split(' '),
		weekday_holder = clock.find('.weekdays');

	$.each(weekday_names, function(){
		weekday_holder.append('<span>' + this + '</span>');
	});

	var weekdays = clock.find('.weekdays span');


	// Run a timer every second and update the clock

	(function update_time(){

		// Use moment.js to output the current time as a string
		// hh is for the hours in 12-hour format,
		// mm - minutes, ss-seconds (all with leading zeroes),
		// d is for day of week and A is for AM/PM
		var day="<?php echo date('d-m-Y h:i a',strtotime($dayStart));?>";
		var y="<?php echo date('Y',strtotime($dayStart));?>";
		var m="<?php echo date('m',strtotime($dayStart));?>";
		m=m-1;
		var d="<?php echo date('d',strtotime($dayStart));?>";
		var h="<?php echo date('h',strtotime($dayStart));?>";
		var mi="<?php echo date('i',strtotime($dayStart));?>";
		var s="<?php echo date('s',strtotime($dayStart));?>";
		
		var now = moment().date(d).month(m).year(y).hours(h).minutes(mi).seconds(s).format("hhmmssdA");
		
		

		digits.h1.attr('class', digit_to_name[now[0]]);
		digits.h2.attr('class', digit_to_name[now[1]]);
		digits.m1.attr('class', digit_to_name[now[2]]);
		digits.m2.attr('class', digit_to_name[now[3]]);
		digits.s1.attr('class', digit_to_name[now[4]]);
		digits.s2.attr('class', digit_to_name[now[5]]);

		// The library returns Sunday as the first day of the week.
		// Stupid, I know. Lets shift all the days one position down, 
		// and make Sunday last

		var dow = now[6];
		dow--;
		
		// Sunday!
		if(dow < 0){
			// Make it last
			dow = 6;
		}

		// Mark the active day of the week
		weekdays.removeClass('active').eq(dow).addClass('active');

		// Set the am/pm text:
		ampm.text(now[7]+now[8]);

		// Schedule this function to be run again in 1 sec
		//setTimeout(update_time, 1000);

	})();

	// Switch the theme

	

});
</script>
<script src="<?php echo base_url(); ?>assets/js/addUser.js" type="text/javascript"></script>

