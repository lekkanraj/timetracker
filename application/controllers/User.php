<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class User extends BaseController
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
    public function index()
    {
        $this->global['pageTitle'] = 'Dashboard';
        $userId=$this->session->userdata ( 'userId' );
        $dailytrackingid=$this->session->userdata ( 'dailytrackingid' );
        $currentDate=date("Y-m-d");
        $where=array(
            'userid'=>$userId,
            //'created_on'=>$currentDate
            'id'=>$dailytrackingid
        );
        $select=array('*');
        
        $trackInfo=$this->common_model->selectData(TABLE_DAILY_TRACKING,$select,$where);
        $projectId=$this->session->userdata ( 'projectId' );
        $where1=array(
            'id'=>$projectId,
        );
        $select1=array('breaks');
        
        $breaks=$this->common_model->selectData(TABLE_MASTER_PROJECTS,$select1,$where1);
        if(count($breaks)>0){
            $breaks=$breaks[0]->breaks;
        }
        $pageInfo=array(
            'trackInfo'=>$trackInfo,
            'breaks'=>$breaks,
            'userId'=>$userId,
        );
        
        $this->loadViews("dashboard", $this->global, $pageInfo , NULL);
    }
    
    /**
     * This function is used to load the user list
     */
    function userListing()
    {
        if($this->isAdminManager() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('user_model');
            $post=$this->input->post();
            $searchText = $this->input->post('searchText');
            $data['searchText'] = $searchText;
            $role=$project=$teamlead='';
            if($post){
                $role=isset($post['role'])?$post['role']:'';
                $project=isset($post['project'])? $post['project']:'';
                $teamlead=isset($post['teamlead'])?$post['teamlead']:'';
                $data['post']=$post;
            }
            
            $select=array('*');
            $where=array(
                'isActive'=>1
            );
            $projects=$this->common_model->selectData(TABLE_MASTER_PROJECTS,$select,$where);
            $data['projects']=$projects;
            $data['roles'] = $this->user_model->getUserRoles();
            
            $this->load->library('pagination');
            
            $count = $this->user_model->userListingCount($searchText,$project,$role);

			$returns = $this->paginationCompress ( "userListing/", $count, 20 );
            
			$data['userRecords'] = $this->user_model->userListing($searchText,$project,$role, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'User Listing';
            
            $this->loadViews("users", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function addNew()
    {
        if($this->isAdminManager() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('user_model');
            $data['roles'] = $this->user_model->getUserRoles();
            $data['roleId']=$this->session->userdata ( 'role' );
            $this->global['pageTitle'] = 'Add New User';
            
            $where=array(
                'isActive'=>1,
            );
            $select=array('id,name');
            
            $data['projects']=$this->common_model->selectData(TABLE_MASTER_PROJECTS,$select,$where);
           

            $this->loadViews("addNew", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to check whether email already exist or not
     */
    function checkEmailExists()
    {
        $userId = $this->input->post("userId");
        $email = $this->input->post("email");

        if(empty($userId)){
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
    
    /**
     * This function is used to add new user to the system
     */
    function addNewUser()
    {
        if($this->isAdminManager() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]|xss_clean');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|max_length[128]');
            $this->form_validation->set_rules('password','Password','required|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('project','Project','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]|xss_clean');
            $this->form_validation->set_rules('employeeid','Employee Id','required|max_length[10]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNew();
            }
            else
            {
                $name = ucwords(strtolower($this->input->post('fname')));
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $projectId = $this->input->post('project');
                $mobile = $this->input->post('mobile');
                $employeeid= $this->input->post('employeeid');
                
                $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password), 'roleId'=>$roleId, 'name'=> $name,
                    'mobile'=>$mobile, 'createdBy'=>$this->vendorId,'createdDtm'=>date('Y-m-d H:i:s'),
                    'projectId'=>$projectId,'employeeid'=>$employeeid
                );
                
                if($this->input->post('teamlead')){
                    $teamlead = $this->input->post('teamlead');
                    $userInfo['teamleadId']=$teamlead;
                }
                
                $this->load->model('user_model');
                $result = $this->user_model->addNewUser($userInfo);
                
                if($result > 0)
                {
                    $data1=array();
                    $data1["name"] = $name;
                    $data1["email"] = $email;
                    $data1["password"] = $password;                  
                    
                    $sendStatus = newUserEmail($data1);
                    if($sendStatus){
                        $this->session->set_flashdata('success', 'New User created & Email Sent successfully ');
                    }else{
                        $this->session->set_flashdata('success', 'New User created successfully');
                    }
                   
                }
                else
                {
                    $this->session->set_flashdata('error', 'User creation failed');
                }
                
                redirect('addNew');
            }
        }
    }

    
    /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function editOld($userId = NULL)
    {
        if($this->isAdminManager() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($userId == null)
            {
                redirect('userListing');
            }
            
            $data['roles'] = $this->user_model->getUserRoles();
            $data['userInfo'] = $this->user_model->getUserInfo($userId);
           
            $projectid=isset($data['userInfo'][0]->projectId)?$data['userInfo'][0]->projectId:'';
            
            $select=array('userId,name');
            $where=array(
                'isDeleted'=>0,
                'roleId'=>2,
                'projectId'=>$projectid,
            );
            $leadlist=$this->common_model->selectData(TABLE_USERS,$select,$where);
            $data['leadlist'] =$leadlist;
            $where=array(
                'isActive'=>1,
            );
            $select=array('id,name');
            
            $data['projects']=$this->common_model->selectData(TABLE_MASTER_PROJECTS,$select,$where);
            
            $this->global['pageTitle'] = 'Edit User';
            
            $this->loadViews("editOld", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function editUser()
    {
        if($this->isAdminManager() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $userId = $this->input->post('userId');
            
            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]|xss_clean');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|max_length[128]');
            $this->form_validation->set_rules('password','Password','matches[cpassword]|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','matches[password]|max_length[20]');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]|xss_clean');
            if($userId !=1){
                $this->form_validation->set_rules('role','Role','trim|required|numeric');
                $this->form_validation->set_rules('project','Project','trim|required|numeric');
                $this->form_validation->set_rules('employeeid','Employee Id','required|max_length[10]');
            }
            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($userId);
            }
            else
            {
                $post=$this->input->post(); 
                $name = ucwords(strtolower($this->input->post('fname')));
                $email = isset($post['email'])? $post['email']:'';
                $password = isset($post['password'])? $post['password']:'';
                $roleId = isset($post['role'])? $post['role']:'';
                $mobile = isset($post['mobile'])? $post['mobile']:'';
                $projectId = isset($post['project'])? $post['project']:'';
                $employeeid= isset($post['employeeid'])? $post['employeeid']:'';
                
                $userInfo = array();
                
                if(empty($password))
                {
                    $userInfo = array('email'=>$email, 'roleId'=>$roleId, 'name'=>$name,
                        'mobile'=>$mobile, 'updatedBy'=>$this->vendorId,'projectId'=>$projectId, 'updatedDtm'=>date('Y-m-d H:i:s'),'employeeid'=>$employeeid);
                }
                else
                {
                    $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password), 'roleId'=>$roleId,
                        'name'=>ucwords($name), 'mobile'=>$mobile, 'updatedBy'=>$this->vendorId, 'projectId'=>$projectId,
                        'updatedDtm'=>date('Y-m-d H:i:s'),'employeeid'=>$employeeid);
                }
                
                if($this->input->post('teamlead')){
                    $teamlead = $this->input->post('teamlead');
                    $userInfo['teamleadId']=$teamlead;
                }
                
                if($userId==1){
                    if(empty($password))
                    {
                        $userInfo = array('email'=>$email, 'name'=>$name,
                            'mobile'=>$mobile, 'updatedBy'=>$this->vendorId,'updatedDtm'=>date('Y-m-d H:i:s'),'employeeid'=>$employeeid);
                    }
                    else
                    {
                        $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password),
                            'name'=>ucwords($name), 'mobile'=>$mobile, 'updatedBy'=>$this->vendorId, 
                            'updatedDtm'=>date('Y-m-d H:i:s'),'employeeid'=>$employeeid);
                    }
                }
                
                $result = $this->user_model->editUser($userInfo, $userId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'User updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User updation failed');
                }
                
                redirect('userListing');
            }
        }
    }


    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $userId = $this->input->post('userId');
            $userInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            
            $result = $this->user_model->deleteUser($userId, $userInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
    
    /**
     * This function is used to load the change password screen
     */
    function loadChangePass()
    {
        $this->global['pageTitle'] = 'Change Password';
        
        $this->loadViews("changePassword", $this->global, NULL, NULL);
    }
    
    
    /**
     * This function is used to change the password of the user
     */
    function changePassword()
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('oldPassword','Old password','required|max_length[20]');
        $this->form_validation->set_rules('newPassword','New password','required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword','Confirm new password','required|matches[newPassword]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->loadChangePass();
        }
        else
        {
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');
            
            $resultPas = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);
            
            if(empty($resultPas))
            {
                $this->session->set_flashdata('nomatch', 'Your old password is incorrect');
                redirect('loadChangePass');
            }
            else
            {
                $usersData = array('password'=>getHashedPassword($newPassword), 'updatedBy'=>$this->vendorId,
                                'updatedDtm'=>date('Y-m-d H:i:s'));
                
                $result = $this->user_model->changePassword($this->vendorId, $usersData);
                
                if($result > 0) { $this->session->set_flashdata('success', 'Password updation successful'); }
                else { $this->session->set_flashdata('error', 'Password updation failed'); }
                
                redirect('loadChangePass');
            }
        }
    }

    function pageNotFound()
    {
        $this->global['pageTitle'] = '404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }
    
    function getteamlead(){
        $post= $this->input->post();       
        if($post){
            $select=array('userId,name');
            $where=array(
                'isDeleted'=>0,
                'roleId'=>2,
                'projectId'=>$post['project'],
            );
            $Info=$this->common_model->selectData(TABLE_USERS,$select,$where);
           
            if(count($Info)>0){
                $lead=array();
                foreach($Info as $data){
                    $lead[$data->userId]=$data->name;
                }
               // pre($lead);
                echo json_encode($lead);
            }
        }
    }
}

?>