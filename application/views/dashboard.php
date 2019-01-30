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
            <div class="col-md-8">
              <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"></h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" id="addUser" class="form-horizontal" action="<?php echo base_url() ?>" method="post" role="form">
                        <div class="box-body">
                            <div class="form-group">
                                <label class="control-label col-sm-4" for="email">Start Time/End</label>
                                <div class="col-sm-6">
                                  <div class="onoffswitch">
                                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="daystart">
                                    <label class="onoffswitch-label" for="daystart">
                                        <span class="onoffswitch-inner daystarton" breaktype="1" breakStatus="1"></span>
                                        <span class="onoffswitch-switch daystartoff"></span>
                                    </label>
                                </div>
                                </div>
                             </div>
                             
                             <div class="form-group">
                             	<a href="<?php echo base_url().'/logoff';?>" class="">Logoff the Day </a>
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
		var breaktype=$(this).attr('breaktype');
		var breakStatus=$(this).attr('breakStatus');
		
		var info={
				'breakid':breaktype,
				'breakStatus':breakStatus,
				};
		var res=postdata(info);
		$(this).attr('breakStatus',2);

		if(breakStatus==2){
			$(this).attr('disabled:true');
		}
		
	});


	function postdata(info){
    	var saveData = $.ajax({
    	      type: 'POST',
    	      url: "<?php echo base_url()."ajax/break"; ?>",
    	      data: info,
    	      dataType: "text",
    	      success: function(resultData) {  }
    	});
    	return saveData;
	}
});
</script>
<script src="<?php echo base_url(); ?>assets/js/addUser.js" type="text/javascript"></script>