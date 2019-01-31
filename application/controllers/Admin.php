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
                $this->loadViews("addProject", $this->global, NULL, NULL);
            }else{
                $name = $post['name'];
                $breakcount= $post['breakcount'];
                $Info = array(
                    'name'=>$name, 
                    'shift_start_time'=>date('Y-m-d H:i:s'),
                    'shift_end_time'=>date('Y-m-d H:i:s'),
                    'breaks_count'=>$breakcount,
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
    
    

    function pageNotFound()
    {
        $this->global['pageTitle'] = '404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }
}

?>