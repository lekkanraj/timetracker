<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> User Management
        <small>Add, Edit, Delete</small>
      </h1>
    </section>
    <section class="content">
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
            <div class="col-xs-12 text-right">
                <div class="form-group">
                <?php $roleId=$this->session->userdata ( 'role' );
                if($roleId==ROLE_MANAGER){
                ?>
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>addNew"><i class="fa fa-plus"></i> Add New</a>
                <?php }?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
            <form action="<?php echo base_url() ?>userListing" method="POST" id="searchList">
                            <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="project">Project</label>
                                        <select class="form-control required" id="project" name="project">
                                            <option value="">All Projects</option>
                                            <?php
                                            $projectId=isset($post['project'])?$post['project']:'';
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
                            <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <select class="form-control" id="role" name="role">
                                            <option value="">All Roles</option>
                                            <?php
                                            $roleIds=isset($post['role'])?$post['role']:'';
                                            if(!empty($roles))
                                            {
                                                foreach ($roles as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->roleId; ?>" <?php if($rl->roleId == $roleIds) {echo "selected=selected";} ?>><?php echo $rl->role ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                    	<label for="todate">By Name</label>
                                    	<div class="input-group">
                                    		<input id="txtToDate" type="input" class="form-control" name="searchText" value="<?php echo $searchText; ?>" autocomplete="off">
											
										</div>   
                                    </div>
                                </div>
                                <div class="col-md-2">
                                	<div class="" style="margin-top: 24px;">
                                		<input type="submit" class="btn btn-primary" value="Search" style=" margin-right:10px;" />
                            			<input type="reset" class="btn btn-default" value="Reset" id="reset"/>
                            		</div>
                                </div>
                        </form>
            </div>
         </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box box-primary padding">
                <div class="box-header">
                    <h3 class="box-title">Users List</h3>
                    <div class="box-tools">
                        
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover table-bordered project_table">
                    <tr>
                      <th>Id</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Mobile</th>
                      <th>Project</th>
                      <?php  if($roleId==ROLE_MANAGER){?>
                      <th>Role</th>                      
                      <th class="text-center">Actions</th>
                      <?php }?>
                      
                    </tr>
                    <?php
                    if(!empty($userRecords))
                    {
                        foreach($userRecords as $record)
                        {
                    ?>
                    <tr>
                      <td><?php echo $record->userId ?></td>
                      <td><?php echo $record->name ?></td>
                      <td><?php echo $record->email ?></td>
                      <td><?php echo $record->mobile ?></td>
                      <td><?php echo $record->projectname ?></td>
                      <?php  if($roleId==ROLE_MANAGER){?>
                      <td><?php echo $record->role ?></td>
                      <td class="text-center">
                          <a class="btn btn-sm btn-success" href="<?php echo base_url().'editOld/'.$record->userId; ?>"><i class="fa fa-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deleteUser" href="#" data-userid="<?php echo $record->userId; ?>"><i class="fa fa-trash"></i></a>
                      </td>
                      <?php }?>
                    </tr>
                    <?php
                        }
                    }else{
                    ?>
                    <tr class="text-center">
                      <td colspan=7>No Records Found</td>
                     </tr>
                    <?php }?>
                  </table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
                </div>
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "userListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
