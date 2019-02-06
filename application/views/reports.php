<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-files-o"></i> Reports
        <small>By User & By Team</small>
      </h1>
    </section>
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                <div class="box box-primary pad">
                    <div class="box-header">
                        <h3 class="box-title"><b>Generate Reports</b></h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php 
                    $fromdate=isset($post['fromdate'])?$post['fromdate']:'';
                    $todate=isset($post['todate'])?$post['todate']:'';
                    $project=isset($post['project'])?$post['project']:'';
                    $reporttype=isset($post['reporttype'])?$post['reporttype']:'';
                    ?>
                    <div class="box-body">
                    	<form role="form" id="addUser" action="<?php echo base_url().'reports'; ?>" method="post" role="form">
                        	<div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                    	<label for="fromdate">From Date</label>
                                    	<div class="input-group">
                                    		<input id="txtFromDate" type="input" class="form-control" name="fromdate" placeholder="mm/dd/yyyy" value=<?php echo datePicker($fromdate);?>>
											<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
										</div>   
                                    </div>
                                </div>
                                 <div class="col-md-2">
                                    <div class="form-group">
                                    	<label for="todate">To Date</label>
                                    	<div class="input-group">
                                    		<input id="txtToDate" type="input" class="form-control" name="todate" placeholder="mm/dd/yyyy" value=<?php echo datePicker($todate);?>>
											<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
										</div>   
                                    </div>
                                </div>
                                <?php 
                                $role=$this->session->userdata ( 'role' );
                                $projectId=$this->session->userdata ('projectId' );
                                if($role==ROLE_TEAMLEAD){
                                ?>
                                <input type="hidden" name="project" value="<?php echo $projectId?>">
                                <?php }else{?>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="project">Project/Team</label>
                                        <select class="form-control required" id="role" name="project">
                                            <option value="0">Select</option>
                                            <?php
                                            if(!empty($projects))
                                            {
                                                foreach ($projects as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->id ?>" <?php if($rl->id==$project){echo "selected";}?>><?php echo $rl->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <?php }?>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="project">Select Report</label>
                                        <select class="form-control required" id="role" name="reporttype" selected=<?php echo $reporttype;?>>
                                            <option value="1" <?php if($reporttype==1){ echo "selected";};?>>Day Wise</option>
                                            <option value="2" <?php if($reporttype==2){ echo "selected";};?>>Summary</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                	<div class="" style="margin-top: 24px;">
                                		<input type='hidden' class='filetype' value='1' />
                                		<input type="submit" class="btn btn-primary" value="Search" />
                            			<input type="reset" class="btn btn-default" value="Reset" id='reset' />
                            		</div>
                                </div>
								<div class="col-md-2">
                               		<div class="input-group">
                                      <div class="input-group-btn">
                                        <a target="_blank" class="btn btn-app" href="<?php echo base_url()."reports/pdf?fromdate=$fromdate&todate=$todate&project=$project&reporttype=$reporttype";?>">
											<i class="fa fa-file-pdf-o" style="margin: 0;"></i> PDF
										</a>
                                        <a target="_blank" class="btn btn-app" href="<?php echo base_url()."reports/excel?fromdate=$fromdate&todate=$todate&project=$project&reporttype=$reporttype";?>">
											<i class="fa fa-file-excel-o" ></i> Excel
										</a>
                                      </div>
                                    </div>
                             </div>
                            </div>
                            </form>
					<?php if($reporttype==1){?>
        					<table class="table table-hover table-bordered project_table">
                                <thead>
                                  <tr>
                                    <th align='center'>Sno</th>
                                    <th align='center'>Employee Name</th>
                                    <th align='center'>Project Name</th>
                                    <th  align='center'>Date</th>
                                    <th  align='center'>Start Time</th>
                                    <th align='center'>End Time</th>
                                    <th align='center'>Spend Hours</th>
                                    <th align='center'>Break Hours</th>
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
                                        <td><?php echo displayTime($record->day_end); ?></td>
                                        <td><?php echo $record->spend_hours ?></td>
                                        <td><?php echo $record->break_hours ?></td>
                                      </tr>
                                  <?php 
                                        $i++;
                                        }
                                    }else{?>
                                    <tr>
                                        <td colspan='8'>No Records Found.</td>
                                      </tr>
                                    
                                    <?php }?>
                                </tbody>
                              </table>
							<?php }else{?>
							<table class="table table-hover table-bordered project_table">
								<thead>
                                  <tr>
                                    <th align='center'>Sno</th>
                                    <th align='center'>Employee Name</th>
                                    <th  align='center'>Team</th>
                                    <th  align='center'>Days</th>
                                    <th align='center'>Spend Hours</th>
                                    <th align='center'>Break Hours</th>
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
                                        <td><?php echo $record['name']; ?></td>
                                        <td><?php echo $record['projectname']; ?></td>
                                        <td><?php echo $record['days']; ?></td>
                                        <td><?php echo $record['hourscount']; ?></td>
                                        <td><?php echo $record['breakscount']; ?></td>
                                      </tr>
                                  <?php 
                                        $i++;
                                        }
                                    }else{?>
                                    <tr>
                                        <td colspan='6'>No Records Found.</td>
                                      </tr>
                                    
                                    <?php }?>
                                </tbody>
                              </table>
							<?php }?>
                            </div>
                        </div><!-- /.box-body -->
    					
                     <!-- <div class="row">
                            <div class="col-md-12">  
							<div class="box box-primary pad">
                        <table class="table table-hover table-bordered project_table">
                        <thead>
                          <tr>
                            <th align='center'>Sno</th>
                            <th align='center'>Employee Name</th>
                            <th align='center'>Project Name</th>
                            <th  align='center'>Date</th>
                            <th  align='center'>Start Time</th>
                            <th align='center'>End Time</th>
                            <th align='center'>Spend Hours</th>
                            <th align='center'>Break Hours</th>
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
                                <td><?php echo displayTime($record->day_end); ?></td>
                                <td><?php echo $record->spend_hours ?></td>
                                <td><?php echo $record->break_hours ?></td>
                              </tr>
                          <?php 
                                $i++;
                                }
                            }else{?>
                            <tr>
                                <td colspan='8'>No Records Found.</td>
                              </tr>
                            
                            <?php }?>
                        </tbody>
                      </table>
                    </div>
					 </div>
            	</div>-->
                </div>
            </div>
            
          
    </section>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script type="text/javascript">
$(document).ready(function(){
	$('.downloadfile').on('click',function(){
		var filetype=$(this).attr('filetype');
		$('.filetype').val(filetype);

	});
	$('#reset').on('click',function(){
		window.location="<?php echo base_url().'reports';?>";
	});
    $("#txtFromDate").datepicker({
    	//dateFormat: 'dd/mm/yy',
        numberOfMonths:1,
        onSelect: function(selected) {
          $("#txtToDate").datepicker("option","minDate", selected)
        },
       // maxDate:'+0 d',
        currentdate:'now',
        maxDate:'now' 	
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
});
</script>
