<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


class Login extends CI_Controller
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('common_model');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->isLoggedIn();
    }
    
    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('login');
        }
        else
        {
            redirect('/dashboard');
        }
    }
    
    
    /**
     * This function used to logged in user
     */
    public function loginMe()
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[128]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->index();
        }
        else
        {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            
            $result = $this->login_model->loginMe($email, $password);
            
            if(count($result) > 0)
            {
                foreach ($result as $res)
                {  $sessionArray = array('userId'=>$res->userId,
                    'role'=>$res->roleId,
                    'roleText'=>$res->role,
                    'name'=>$res->name,
                    'projectId'=>$res->projectId,
                    'isLoggedIn' => TRUE,
                );
                $this->session->set_userdata($sessionArray); 
                    
                    /*Day Tracking Insert*/
                    $userId=$this->session->userdata ( 'userId' );
                    
                    $select=array('id');
                    $where=array(
                        'userid'=>$userId,
                    );
                    $tracklist=$this->common_model->selectData(TABLE_DAILY_TRACKING,$select,$where);
                    //echo count($tracklist);
                    //pre($tracklist,1);
                    
                    $lasttrackingid='';
                    if(count($tracklist)>0){
                        $c=(count($tracklist))-1;
                        $lasttrackingid=$tracklist[$c]->id;
                    }
                    
                    //$dailytrackingid=$this->session->userdata ( 'dailytrackingid' );
                    $currentTime=date("Y-m-d H:i:s");
                    $currentDate=date("Y-m-d");
                    $where=array(
                        'userid'=>$userId,
                       // 'created_on'=>$currentDate
                        'id'=>$lasttrackingid
                    );
                    $count=0;
                    $count=$this->common_model->get_num_rows(TABLE_DAILY_TRACKING,$where);
                    $insertID=isset($lasttrackingid)?$lasttrackingid:'';
                    if($count<=0){
                        $data=array(
                            'userid'=>$userId,
                            'day_start'=>$currentTime,
                            'created_on'=>$currentDate,
                        );
                        $insertID= $this->common_model->insert_db(TABLE_DAILY_TRACKING,$data);
                    }
                    
                    if($insertID){
                        $sessionArray['dailytrackingid']=$insertID;
                    }                    
                    $this->session->set_userdata($sessionArray);                  
                    
                    redirect('/dashboard');
                }
            }
            else
            {
                $this->session->set_flashdata('error', 'Email or password mismatch');
                
                redirect('/login');
            }
        }
    }

    /**
     * This function used to load forgot password view
     */
    public function forgotPassword()
    {
        $this->load->view('forgotPassword');
    }
    
    /**
     * This function used to generate reset password request link
     */
    function resetPasswordUser()
    {
        $status = '';
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('login_email','Email','trim|required|valid_email|xss_clean');
                
        if($this->form_validation->run() == FALSE)
        {
            $this->forgotPassword();
        }
        else 
        {
            $email = $this->input->post('login_email');
            
            if($this->login_model->checkEmailExist($email))
            {
                $encoded_email = urlencode($email);
                
                $this->load->helper('string');
                $data['email'] = $email;
                $data['activation_id'] = random_string('alnum',15);
                $data['createdDtm'] = date('Y-m-d H:i:s');
                $data['agent'] = getBrowserAgent();
                $data['client_ip'] = $this->input->ip_address();
                
                $save = $this->login_model->resetPasswordUser($data);                
                
                if($save)
                {
                    $data1['reset_link'] = base_url() . "resetPasswordConfirmUser/" . $data['activation_id'] . "/" . $encoded_email;
                    $userInfo = $this->login_model->getCustomerInfoByEmail($email);

                    if(!empty($userInfo)){
                        $data1["name"] = $userInfo[0]->name;
                        $data1["email"] = $userInfo[0]->email;
                        $data1["message"] = "Reset Your Password";
                    }

                    $sendStatus = resetPasswordEmail($data1);

                    if($sendStatus){
                        $status = "send";
                        setFlashData($status, "Reset password link sent successfully, please check mails.");
                    } else {
                        $status = "notsend";
                        setFlashData($status, "Email has been failed, try again.");
                    }
                }
                else
                {
                    $status = 'unable';
                    setFlashData($status, "It seems an error while sending your details, try again.");
                }
            }
            else
            {
                $status = 'invalid';
                setFlashData($status, "This email is not registered with us.");
            }
            redirect('/forgotPassword');
        }
    }

    // This function used to reset the password 
    function resetPasswordConfirmUser($activation_id, $email)
    {
        // Get email and activation code from URL values at index 3-4
        $email = urldecode($email);
        
        // Check activation id in database
        $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);
        
        $data['email'] = $email;
        $data['activation_code'] = $activation_id;
        
        if ($is_correct == 1)
        {
            $this->load->view('newPassword', $data);
        }
        else
        {
            redirect('/login');
        }
    }
    
    // This function used to create new password
    function createPasswordUser()
    {
        $status = '';
        $message = '';
        $email = $this->input->post("email");
        $activation_id = $this->input->post("activation_code");
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('password','Password','required|max_length[20]');
        $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->resetPasswordConfirmUser($activation_id, urlencode($email));
        }
        else
        {
            $password = $this->input->post('password');
            $cpassword = $this->input->post('cpassword');
            
            // Check activation id in database
            $is_correct = $this->login_model->checkActivationDetails($email, $activation_id);
            
            if($is_correct == 1)
            {                
                $this->login_model->createPasswordUser($email, $password);
                
                $status = 'success';
                $message = 'Password changed successfully';
            }
            else
            {
                $status = 'error';
                $message = 'Password changed failed';
            }
            
            setFlashData($status, $message);

            redirect("/login");
        }
    }
    
    function logoff(){
        $post= $this->input->post();
        
        $userId=$this->session->userdata ( 'userId' );
        $currentTime=date("Y-m-d H:i:s");
        $currentDate=date("Y-m-d");
        if($post){
            $userId=isset($post['userid'])?$post['userid']:'';
            $currentDate=isset($post['logoffdate'])?$post['logoffdate']:'';
        }else{            
            //$currentDate=$this->input->get('datastart');
            $currentDate=date("Y-m-d");
        }
        
        $where=array(
            'userid'=>$userId,
            'created_on'=>sqldateformate($currentDate)
        );
        $select=array('day_start');
        $count=0;
        $count=$this->common_model->selectData(TABLE_DAILY_TRACKING,$select,$where);
      
        if(count($count)>0){           
            $count=$count[0];
            $dayStart=$count->day_start;
            $spendHours=timeDifference($dayStart,$currentTime);
            $break_hours=updatebreakinfointracking($userId,$currentDate);
            $data=array(
                'day_end'=>$currentTime,
                'spend_hours'=>$spendHours,
                'break_hours'=>$break_hours
            );
            $res= $this->common_model->edit_db(TABLE_DAILY_TRACKING,$data,$where);
            if($post){
                redirect("/admin/team");
            }
            /* else{
                redirect("/logout");
            } */
        }
        redirect("/dashboard");
        
    }


}

?>