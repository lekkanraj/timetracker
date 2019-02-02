<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Reports
        <small>By User & By Team</small>
      </h1>
    </section>
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Generate Reports</h3>
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
                                    		<input id="txtFromDate" type="input" class="form-control" name="fromdate" placeholder="dd/mm/yyyy" value=<?php echo $fromdate;?>>
											<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
										</div>   
                                    </div>
                                </div>
                                 <div class="col-md-2">
                                    <div class="form-group">
                                    	<label for="todate">To Date</label>
                                    	<div class="input-group">
                                    		<input id="txtToDate" type="input" class="form-control" name="todate" placeholder="dd/mm/yyyy" value=<?php echo $todate;?>>
											<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
										</div>   
                                    </div>
                                </div>
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
                                
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="project">Select Report</label>
                                        <select class="form-control required" id="role" name="reporttype" selected=<?php echo $reporttype;?>>
                                            <option value="1">Day Wise</option>
                                            <option value="2">Summary</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                	<div class="" style="margin-top: 24px;">
                                		<input type='hidden' class='filetype' value='1' />
                                		<input type="submit" class="btn btn-primary" value="Search" />
                            			<input type="reset" class="btn btn-default" value="Reset" />
                            		</div>
                                </div>
                            </div>
                            </form>
                            </div>
                        </div><!-- /.box-body -->
    					<div class="row">
                            <div class="col-md-12">
                               <div class="input-group">
                                      <div class="input-group-btn">
                                        <button class="btn btn-md btn-default  downloadfile" filetype="1"><i class="fa fa-file-excel-o" style="font-size: 35px;"></i></button>
                                        <button class="btn btn-md btn-default  downloadfile" filetype="2"><i class="fa fa-file-pdf-o" style="font-size: 35px;"></i></button>
                                      </div>
                                    </div>
                                
                            </div>
                        </div>
                        
                    
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
alert(filetype);
	});
    $("#txtFromDate").datepicker({
        numberOfMonths: 2,
        onSelect: function(selected) {
          $("#txtToDate").datepicker("option","minDate", selected)
        },
        maxDate:'+0 d',
        currentdate:'now'    	
    });
    $("#txtToDate").datepicker({ 
        numberOfMonths: 2,
        onSelect: function(selected) {
           $("#txtFromDate").datepicker("option","maxDate", selected)
        },
        maxDate:'+0 d',
        currentdate:'now'
    });  
});
</script>
