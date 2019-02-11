<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Ajax extends BaseController
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
        
    }
    
    public function break(){
        $post=$this->input->post();
        $breakId=$post['breakid'];
        $breakStatus=isset($post['breakStatus'])?$post['breakStatus']:'';
        //$daytrackingId=isset($post['daytrackingId'])?$post['daytrackingId']:'';
        $daytrackingId=$this->getTrackingid();
        $userId=$this->session->userdata ( 'userId' );
        $currentTime=date("Y-m-d H:i:s");
        $currentDate=date("Y-m-d");
        //Break Status 1-On,0-Off
        if($breakStatus==1){
            $data=array(
                'userid'=>$userId,
                'breakid'=>$breakId,
                'user_tracking_id'=>$daytrackingId,
                'break_start'=>$currentTime,
                'created_on'=>$currentDate,
            );
            $res= $this->common_model->insert_db(TABLE_USER_BREAKS,$data);
        }
        if($breakStatus==2){
            
            $where=array(
                'userid'=>$userId,
                'breakid'=>$breakId,
                'user_tracking_id'=>$daytrackingId
            );
            $select=array('break_start');
            $count=0;
            $count=$this->common_model->selectData(TABLE_USER_BREAKS,$select,$where);
            
            if(count($count)>0){
                $count=$count[0];
                $dayStart=$count->break_start;
                $spendHours=timeDifference($dayStart,$currentTime);
            }
            $where=array(
                'userid'=>$userId,
                'breakid'=>$breakId,
                'user_tracking_id'=>$daytrackingId
            );
            $data=array(
                'break_end'=>$currentTime,
                'break_hours'=>$spendHours
            );
            $res= $this->common_model->edit_db(TABLE_USER_BREAKS,$data,$where);
            
           
        }
        
        return $res;      
        
    }
    
    public function getTrackingid(){
        $userId=$this->session->userdata ( 'userId' );
        $currentDate=date("Y-m-d");
        $where=array(
            'userid'=>$userId,
            'created_on'=>$currentDate
        );
        $select=array('id');
        $count=0;
        $count=$this->common_model->selectData(TABLE_DAILY_TRACKING,$select,$where);
        if(count($count)>0){
            $count=$count[0];
            return $count->id;
        }
        return false;
    }
    
    
}

?>