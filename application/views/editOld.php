<?php

$userId = '';
$name = '';
$email = '';
$mobile = '';
$roleId = '';

if(!empty($userInfo))
{
    foreach ($userInfo as $uf)
    {
        $userId = $uf->userId;
        $name = $uf->name;
        $email = $uf->email;
        $mobile = $uf->mobile;
        $roleId = $uf->roleId;
        $projectId=$uf->projectId;
        $teamleadId=$uf->teamleadId;
        $employeeid = $uf->employeeid;
        
    }
}


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> User Management
        <small>Add / Edit User</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary pad">
                    <div class="box-header">
                        <h3 class="box-title"><b>Enter User Details</b></h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>editUser" method="post" id="editUser" role="form">
                        <div class="box-body">
                        <div class="row">
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
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Full Name</label>
                                        <input type="text" class="form-control" id="fname" placeholder="Full Name" name="fname" value="<?php echo $name; ?>" maxlength="128">
                                        <input type="hidden" value="<?php echo $userId; ?>" name="userId" id="userId" />    
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="<?php echo $email; ?>" maxlength="128">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" placeholder="Password" name="password" maxlength="10">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cpassword">Confirm Password</label>
                                        <input type="password" class="form-control" id="cpassword" placeholder="Confirm Password" name="cpassword" maxlength="10">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                        		<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cpassword">Employee ID</label>
                                        <input  class="form-control required " id="employeeid" name="employeeid" maxlength="10" autocomplete="off" value="<?php echo $employeeid;?>">
                                    </div>
                                
                        		</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile">Mobile Number</label>
                                        <input type="text" class="form-control" id="mobile" placeholder="Mobile Number" name="mobile" value="<?php echo $mobile; ?>" maxlength="10">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <select class="form-control" id="role" name="role">
                                            <option value="0">Select Role</option>
                                            <?php
                                            if(!empty($roles))
                                            {
                                                foreach ($roles as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->roleId; ?>" <?php if($rl->roleId == $roleId) {echo "selected=selected";} ?>><?php echo $rl->role ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="project">Project</label>
                                        <select class="form-control required" id="project" name="project">
                                            <option value="0">Select</option>
                                            <?php
                                            if(!empty($projects))
                                            {
                                                foreach ($projects as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->id ?>" <?php if($rl->id == $projectId) {echo "selected=selected";} ?>><?php echo $rl->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <?php 
                                if($roleId==ROLE_EMPLOYEE)
                                {
                                    $display="display:block";
                                }else{
                                    $display="display:none";
                                }
                                ?>
                                
                                 <div class="col-md-6 teamleadinfo" style="">
                                    <div class="form-group">
                                        <label for="teamlead">Team Lead Name</label>
                                        <select class="form-control required" id="teamlead" name="teamlead">
                                            <option value="0">Select</option>
                                             <?php
                                             if(!empty($leadlist))
                                            {
                                                foreach ($leadlist as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->userId ?>" <?php if($rl->userId == $teamleadId) {echo "selected=selected";} ?>><?php echo $rl->name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>  
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" style=" margin-right:10px;" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
            </div>
            
        </div>    
    </section>
</div>
<script type="text/javascript">

$(function(){
	 $('#role').change(function(){
        
         var role = $(this).val();
         if(role==3){
				$('.teamleadinfo').show();
          }else{
        	  $('.teamleadinfo').hide();
         }
        
     });

	 $('#project').change(function(){
	        
         var project = $(this).val();
         var role = $('#role').val();
         $('#teamlead').empty().append('<option value=0>Select Lead</option>');
         //Ajax for calling php function
         $.post('<?php echo  base_url().'getteamlead';?>', { project: project,role:role }, function(data){
           //console.log('ajax completed. Response:  '+data);
           var result =JSON.parse(data);           
			if(data.length>0){				
             $.each( result, function( key, value ) {
            	 $("#teamlead").append('<option value="' +key + '">' +value + '</option>');
            	});
			}
         });
     });
	
});
</script>
<script src="<?php echo base_url(); ?>assets/js/editUser.js" type="text/javascript"></script>