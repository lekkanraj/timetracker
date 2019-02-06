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
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Time Tracking
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
                    <div class="box-header">
                        <h3 class="box-title">
                        	<?php echo "Day Started At : ".displayDateTime($dayStart);?>
                        </h3>
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
                                  <div class="onoffswitch">
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
                                    	<div <?php if($firstassigned==true){ echo "class='disablediv'";}$firstassigned=true;?>>
                                            <input type="checkbox" name="onoffswitch<?php echo $break;?>" class="onoffswitch-checkbox" id="daystart<?php echo $break;?>" <?php echo $checked;?>>
                                            <label class="onoffswitch-label" for="daystart<?php echo $break;?>" >
                                                <span class="onoffswitch-inner daystarton" breaktype="<?php echo $break;?>" breakStatus="<?php echo $breakStatus;?>"></span>
                                                <span class="onoffswitch-switch daystartoff"></span>
                                            </label>
                                        </div>
                                </div>
                                </div>
                                            <?php if(!empty($breakStart)){?>
                                            		<label>Started : <?php echo $breakStart;?></label>
                                            <?php }?>  
                                        <?php }else{
                                            $firstassigned=false;
                                            ?>
                                   </div>
                                </div>       <label>Started Time: <?php echo displayDateTime($breakStart);?></label>
                                				<label>Ended Time: <?php echo displayDateTime($breakEnd);?></label>  
                                            	<label>Spend Hours: <?php echo $breakHours;?></label>                                    	
                                            <?php }?>
                             </div>
                             <?php 
                             if(!empty($breakStart)){
                                 $assignedBreak=true;
                             }
                             
                             
                                }
                            ?>
                             
                             <div class="form-group">
                             	<div class="col-sm-12 text-center">
                             	<?php if($dayEnd){?><label>Day Ended:<?php echo displayDateTime($dayEnd);?></label><?php }else{?>
                             		<a href="javascript:void(0)" class="text-center logoff">
                             			<img alt="Logg Off the Day" height="100px"src="<?php echo base_url().'/assets/images/logoff.png';?>">
                             		</a>
                             		<?php }?>
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
    	    	  window.location="<?php echo base_url()."/dashboard";?>";
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
<script src="<?php echo base_url(); ?>assets/js/addUser.js" type="text/javascript"></script>

