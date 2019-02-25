<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-coffee"></i> Break Management
        <small>Add, Edit, Delete</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url().'admin/addbreak'; ?>"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box box-primary padding">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-tasks"></i> Breaks List</h3>
                    <div class="box-tools">
                        <!-- <form action="<?php echo base_url() ?>admin/projectlist" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form> -->
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
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
                  <table class="table table-hover table-bordered project_table">
                    <tr>
                      <th>Sno</th>
                      <th>Breaks Name</th>
                      <th class="text-center">Actions</th>
                   
                    </tr>
                    <?php
                    if(!empty($Info))
                    {
                        $i=1;
                        foreach($Info as $record)
                        {
                    ?>
                        <tr>
                          <td><?php echo $i; ?></td>
                          <td><?php echo $record->break_name; ?>
                          <td class="text-center">
                         
                              <a class="btn btn-sm btn-info" href="<?php echo base_url().'admin/editbreak/'.$record->id; ?>"><i class="fa fa-pencil"></i></a>
                              <!--  <a class="btn btn-sm btn-danger deleteUser" href="#" data-userid="<?php //echo $record->id; ?>"><i class="fa fa-trash"></i></a>
                           -->
                          </td>
                        </tr>
                        <?php
                        $i++;
                        }
                    }
                    ?>
                  </table>
                  
                </div><!-- /.box-body -->
               
              </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
