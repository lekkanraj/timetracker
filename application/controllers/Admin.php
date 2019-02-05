<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Admin extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('common_model');
        $this->isLoggedIn();   
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function projectlist()
    {
        $this->global['pageTitle'] = 'Projects';
        $userId=$this->session->userdata ( 'userId' );
        $currentDate=date("Y-m-d");
        $where=array(
            'isActive'=>1,
        );
        $select=array('*');
        
        $Info=$this->common_model->selectData(TABLE_MASTER_PROJECTS,$select,$where);
        $searchText = $this->input->post('searchText');
       $this->load->library('pagination');
        $pageInfo=array(
            'Info'=>$Info,
            'searchText'=>'',
        );
        
        $this->loadViews("projects", $this->global, $pageInfo , NULL);
    }
    
   
    function addproject()
    {
            $post= $this->input->post();        
            $this->load->model('user_model');
            if(!$post){
                $this->global['pageTitle'] = 'Add New Project';
                $select=array('*');                
                $Info=$this->common_model->selectData(TABLE_MASTER_BREAKS,$select);
                $data=array(
                    'info'=>$Info
                );
                $this->loadViews("addProject", $this->global, $data, NULL);
            }else{
                $name = $post['name'];
                $breaks= implode(',',$post['breaks']);
                $Info = array(
                    'name'=>$name, 
                    'shift_start_time'=>date('Y-m-d H:i:s'),
                    'shift_end_time'=>date('Y-m-d H:i:s'),
                    'breaks'=>$breaks,
                    'isActive'=>1
                );
                
                $result = $this->common_model->insert_db(TABLE_MASTER_PROJECTS,$Info);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New Project Created Successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Project creation failed');
                }
                
                redirect('admin/projectlist');
            }
        
    }
    
    function team(){
        
        $this->global['pageTitle'] = 'Team Report';
      
        $post= $this->input->post();
        $fromdate=$todate=$project=$reporttype='';
        if($post){
            $fromdate=isset($post['fromdate'])?$post['fromdate']:'';
            $todate=isset($post['todate'])?$post['todate']:'';
            $reporttype=isset($post['reporttype'])?$post['reporttype']:'';
            $data['post']=$post;
        }
        
        $role=$this->session->userdata ( 'role' );
        $projectId=$this->session->userdata ( 'projectId' );
        $userId=$this->session->userdata ( 'userId' );
        $currentDate=date("Y-m-d");
        $trakingTable=TABLE_DAILY_TRACKING;
        $userTable=TABLE_USERS;
        $projectsTable=TABLE_MASTER_PROJECTS;
        
        $where=array(
            'u.projectId'=>$projectId,
            'u.roleId !='=>1
        );
        if($fromdate){
            $where["dt.created_on >="]=sqldateformate($fromdate);
        }
        if($todate){
            $where["dt.created_on <="]=sqldateformate($todate);
        }
       
        $select=array('u.name,dt.*,p.name as projectname');
        $join=array(
            "$userTable u"=>"u.userId=dt.userid",
            "$projectsTable p"=>"p.id=u.projectId",
        );
        //selectData($tableName=null,$select=null,$where=null,$join=null,$like=null,$order_by=null,$order=null,$ion_limit=null,$ion_offset=null,$group_by=null)
        $res=$this->common_model->selectData("$trakingTable dt",$select,$where,$join);
        $data['info']=$res;
        $data['userId']=$userId;
        
        
        $this->loadViews("teamreports", $this->global, $data , NULL);
    }
    

    

    function pageNotFound()
    {
        $this->global['pageTitle'] = '404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }
}

?>