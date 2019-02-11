<!-- https://proto.io/freebies/onoff/ -->
<style>

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
            $break_hours=isset($trackInfo->break_hours)?$trackInfo->break_hours:'';
            $spend_hours=isset($trackInfo->spend_hours)?$trackInfo->spend_hours:'';
            ?>
              <!-- general form elements -->
                 <div class="box box-primary padding">
                   <div class="row">
                   		<?php if(empty($dayEnd)){?>
                   		<div class="col-md-8">
                            <div id="clock" class="dark">
                            	<h3 style="color: #333;">Logged in Time: </h3>
                    			<div class="display">
                    				<div class="weekdays"></div>
                    				<div class="ampm"></div>
                    				<div class="alarm"></div>
                    				<div class="digits"></div>
                    			</div>
                    		</div>
                		</div>
                		<div class="col-md-4 text-center">
                         	<a href="javascript:void(0)" class="text-center logoff">
                         		<img class="img_logoff" title="Logg Off the Day" alt="Logg Off the Day" src="<?php echo base_url().'/assets/images/logoff1.png';?>">
                         	</a>
                		</div>
                		<?php }else{?>
                		<div class="col-md-4">
                    		<div class="table-responsive no-padding">
                      			<table class="table table-hoverproject_table">
                          			<tr>
                                      	<td> Logged In Time : </td>
                                      	<td><?php echo displayDateTime($dayStart); ?></td>
                                     </tr>
                                     <tr>
                                      	<td> Logged Out Time : </td>
                                      	<td><?php echo displayDateTime($dayEnd); ?></td>
                                     </tr>
                                     <tr>
                                      	<td> Break Hours : </td>
                                      	<td><?php echo $break_hours; ?></td>
                                     </tr>
                                     <tr>
                                      	<td> Total Spend Hours : </td>
                                      	<td><?php echo $spend_hours; ?></td>
                                     </tr>
                      			</table>
                      		</div>
                      		</div>
                		<?php }?>
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
		var a="<?php echo date('A',strtotime($dayStart));?>";
		
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
//		ampm.text(now[7]+now[8]);
		ampm.text(a);

		// Schedule this function to be run again in 1 sec
		//setTimeout(update_time, 1000);

	})();

	// Switch the theme

	

});
</script>
<script src="<?php echo base_url(); ?>assets/js/addUser.js" type="text/javascript"></script>

