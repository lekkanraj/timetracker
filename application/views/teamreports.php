<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tasks"></i>Moniter Team
        <small>For Team</small>
      </h1>
    </section>
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                <div class="box box-primary pad">
                    <div class="box-header">
                        <!-- <h3 class="box-title"><b>Monitering</b></h3> -->
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php 
                    $fromdate=isset($post['fromdate'])?$post['fromdate']:'';
                    $todate=isset($post['todate'])?$post['todate']:'';
                    ?>
                    <div class="box-body">
                    	<form role="form" id="addUser" action="<?php echo base_url().'admin/team'; ?>" method="post" role="form">
                        	<div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                    	<label for="fromdate">From Date</label>
                                    	<div class="input-group">
                                    		<input id="txtFromDate" type="input" class="form-control" name="fromdate" placeholder="mm/dd/yyyy" value="<?php echo datePicker($fromdate);?>" autocomplete="off">
											<span class="input-group-addon"><i class="glyphicon glyphicon-calendar txtFromDate"></i></span>
										</div>   
                                    </div>
                                </div>
                                 <div class="col-md-2">
                                    <div class="form-group">
                                    	<label for="todate">To Date</label>
                                    	<div class="input-group">
                                    		<input id="txtToDate" type="input" class="form-control" name="todate" placeholder="mm/dd/yyyy" value="<?php echo datePicker($todate);?>" autocomplete="off">
											<span class="input-group-addon"><i class="glyphicon glyphicon-calendar txtToDate"></i></span>
										</div>   
                                    </div>
                                </div>
                                <div class="col-md-2">
                                	<div class="" style="margin-top: 24px;">
                                		<input type='hidden' class='filetype' value='1' />
                                		<input type="submit" class="btn btn-primary" value="Search" style=" margin-right:10px;" />
                            			<input type="reset" class="btn btn-default" value="Reset" id="reset"/>
                            		</div>
                                </div>
                            </div>
                            </form>
                            </div>
                        
                      <div class="row">
                            <div class="col-md-12">  
                        <table class="table table-hover table-bordered project_table">
                        <thead>
                          <tr>
                            <th align='center'>Sno</th>
                            <th align='center'>Employee Name</th>
                            <th align='center'>Project Name</th>
                            <th align='center'>Date</th>
                            <th align='center'>Start Time</th>
                            <?php 
                            $breaks=getBreaksbyProject($projectId);
                            foreach($breaks as $key=>$break){
                            ?>
                            <th>
                                <?php 
                                echo  $breakname=getBreakInfo($break)->break_name;
                               ?>
                            </th>
                            <?php }?>
                            <th align='center'>End Time</th>
                            <th align='center'>Login hours</th>
                            <th align='center'>Break Hours</th>
                            <th align='center'>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                         <?php
                            if(!empty($info))
                            {
                                $i=1;
                                foreach($info as $record)
                                {
                            ?>
                              <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $record->name; ?></td>
                                <td><?php echo $record->projectname; ?></td>
                                <td><?php echo displayDate($record->day_start); ?></td>
                                <td><?php echo displayTime($record->day_start); ?></td>
                                <?php 
                                    foreach($breaks as $key=>$break){
                                    ?>
                                    <td>
                                        <?php 
                                        $breakdata=getBreakInfoByBreakId($break,$record->userid,$record->id);
                                        // pre($breakdata);
                                         $startTime=$endTime=$spendTime="";
                                         if(!empty($breakdata)){
                                             $startTime=isset($breakdata->break_start) ? $breakdata->break_start :'';
                                             $endTime=isset($breakdata->break_end) ? $breakdata->break_end :'';
                                             $spendTime=isset($breakdata->break_hours) ? $breakdata->break_hours :'';
                                         }
                                         if($startTime){
                                             echo "ST : ".displayTime($startTime)."</br>";
                                         }
                                         if($endTime){
                                             echo "ET : ".displayTime($endTime)."</br>";
                                         }
                                         if($spendTime){
                                             echo "SPT : ".$spendTime."</br>";
                                         }
                                         if($startTime && empty($spendTime)){
                                             $currentTime=date("Y-m-d H:i:s");
                                             echo "RT : ".getTimeDiffrence($startTime,$currentTime);
                                         }
                                       ?>
                                       
                                    </td>
                                    <?php }?>
                                
                                
                                <td><?php echo displayTime($record->day_end); ?></td>
                                <td><?php echo $record->spend_hours ?></td>
                                <td><?php echo $record->break_hours ?></td>
                                <td>
                                	<?php $record->day_end; if(empty($record->day_end) && $record->userid !=$userId){?>
                                        
                                	    <a href='javascript:void(0)' class='logoffusers' userid="<?php echo $record->userid;?>" logoffdate="<?php echo $record->day_start;?>">Log Off</a>
                                        
                                	<?php    } ?> 
                                </td>
                              </tr>
                          <?php 
                                $i++;
                                }
                            }else{?>
                            <tr>
                                <td colspan='10'>No Records Found.</td>
                              </tr>
                            
                            <?php }?>
                        </tbody>
                      </table>
                    </div>
            	</div>
				</div><!-- /.box-body -->
                </div>
            </div>
            
          
    </section>
</div>
<form id="logoffemp" method="post" action="<?php echo base_url().'logoffemp';?>" style="display: none;">
<input type="hidden" name="userid" id="userid" />
<input type="hidden" name="logoffdate" id="logoffdate" />
</form>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script type="text/javascript">
$(document).ready(function(){
	$('.logoffusers').on('click',function(){
		var userid=$(this).attr('userid');
		var logoffdate=$(this).attr('logoffdate');
		$("#userid").val(userid);
		$("#logoffdate").val(logoffdate);
		$("#logoffemp").submit();
		
	});
	$('#reset').on('click',function(){
		window.location="<?php echo base_url().'admin/team';?>";
	});
	 $("#txtFromDate").datepicker({
	    	//dateFormat: 'dd/mm/yy',
	        numberOfMonths:1,
	        onSelect: function(selected) {
	          $("#txtToDate").datepicker("option","minDate", selected)
	        },
	       // maxDate:'+0 d',
	        currentdate:'now' 	
	    });
	    $("#txtToDate").datepicker({
	    	//dateFormat: 'dd/mm/yy',
	        numberOfMonths: 1,
	        onSelect: function(selected) {
	           $("#txtFromDate").datepicker("option","maxDate", selected)
	        },
	        maxDate:'+0 d',
	        currentdate:'now',
	            
	    }); 
	    $('.txtFromDate').click(function() {
	        $("#txtFromDate").focus();
	      }); 
	    $('.txtToDate').click(function() {
	        $("#txtToDate").focus();
	      }); 
});
</script>
<script>
     var time = new Date().getTime();
     $(document.body).bind("mousemove keypress", function(e) {
         time = new Date().getTime();
     });

     function refresh() {
         if(new Date().getTime() - time >= 5000) 
             window.location="<?php echo base_url()."admin/team"?>";
         else 
             setTimeout(refresh, 1000);
     }

    // setTimeout(refresh, 10000);
     setInterval(function(){ 
		//console.log("interval");
		this.refresh();
     }, 3000);
</script>
