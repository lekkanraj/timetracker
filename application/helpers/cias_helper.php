<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * This function is used to print the content of any data
 */
function pre($data,$die=null)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    if($die==1){
        die();
    }
}

/**
 * This function used to get the CI instance
 */
if(!function_exists('get_instance'))
{
    function get_instance()
    {
        $CI = &get_instance();
    }
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 */
if(!function_exists('getHashedPassword'))
{
    function getHashedPassword($plainPassword)
    {
        return password_hash($plainPassword, PASSWORD_DEFAULT);
    }
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 * @param {string} $hashedPassword : This is hashed password
 */
if(!function_exists('verifyHashedPassword'))
{
    function verifyHashedPassword($plainPassword, $hashedPassword)
    {
        return password_verify($plainPassword, $hashedPassword) ? true : false;
    }
}

/**
 * This method used to get current browser agent
 */
if(!function_exists('getBrowserAgent'))
{
    function getBrowserAgent()
    {
        $CI = get_instance();
        $CI->load->library('user_agent');

        $agent = '';

        if ($CI->agent->is_browser())
        {
            $agent = $CI->agent->browser().' '.$CI->agent->version();
        }
        else if ($CI->agent->is_robot())
        {
            $agent = $CI->agent->robot();
        }
        else if ($CI->agent->is_mobile())
        {
            $agent = $CI->agent->mobile();
        }
        else
        {
            $agent = 'Unidentified User Agent';
        }

        return $agent;
    }
}

if(!function_exists('setProtocol'))
{
    function setProtocol()
    {
        $CI = &get_instance();
                    
        $CI->load->library('email');
        
        $config['protocol'] = PROTOCOL;
        $config['mailpath'] = MAIL_PATH;
        $config['smtp_host'] = SMTP_HOST;
        $config['smtp_port'] = SMTP_PORT;
        $config['smtp_user'] = SMTP_USER;
        $config['smtp_pass'] = SMTP_PASS;
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        
        $CI->email->initialize($config);
        
        return $CI;
    }
}

if(!function_exists('emailConfig'))
{
    function emailConfig()
    {
        $CI->load->library('email');
        $config['protocol'] = PROTOCOL;
        $config['smtp_host'] = SMTP_HOST;
        $config['smtp_port'] = SMTP_PORT;
        $config['mailpath'] = MAIL_PATH;
        $config['charset'] = 'UTF-8';
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;
    }
}

if(!function_exists('resetPasswordEmail'))
{
    function resetPasswordEmail($detail)
    {
        $data["data"] = $detail;
        // pre($detail);
        // die;
        
        $CI = setProtocol();        
        
        $CI->email->from(EMAIL_FROM, FROM_NAME);
        $CI->email->subject("Reset Password");
        $CI->email->message($CI->load->view('email/resetPassword', $data, TRUE));
        $CI->email->to($detail["email"]);
        $status = $CI->email->send();
        
        return $status;
    }
}

if(!function_exists('setFlashData'))
{
    function setFlashData($status, $flashMsg)
    {
        $CI = get_instance();
        $CI->session->set_flashdata($status, $flashMsg);
    }
}

function timeDifference($startTime,$endTime){
    $datetime1 = new DateTime($startTime);
    $datetime2 = new DateTime($endTime);
    $interval = $datetime1->diff($datetime2);
    
    return $interval->format('%H').":".$interval->format('%i').":".$interval->format('%s');
}

function getBreakInfoByBreakId($breakId,$userID='',$daytrackingId=''){
        $CI = get_instance();
        $CI->load->model('common_model');
        //$userId=$CI->session->userdata ( 'userId' );
      /*   $currentDate=date("Y-m-d");
        if($userID){
            $userId= $userID;
        } */
        $where=array(
            'userid'=>$userID,
            'user_tracking_id'=>$daytrackingId,
            'breakid'=>$breakId
        );
        
        
        $select=array('*');
        
        $breakInfo=$CI->common_model->selectData(TABLE_USER_BREAKS,$select,$where);
        if(count($breakInfo)>0){
            $breakInfo=$breakInfo[0];
        }
        return $breakInfo;
}

function getBreakInfo($breakId){
    $CI = get_instance();
    $where=array(
        'id'=>$breakId
    );
    $select=array('*');
    
    $breakInfo=$CI->common_model->selectData(TABLE_MASTER_BREAKS,$select,$where);
    if(count($breakInfo)>0){
        $breakInfo=$breakInfo[0];
    }
    return $breakInfo;
}

function getBreaksbyProject($projectId){
    $CI = get_instance();
    $where=array(
        'id'=>$projectId
    );
    $select=array('*');
    
    $breakInfo=$CI->common_model->selectData(TABLE_MASTER_PROJECTS,$select,$where);
    if(count($breakInfo)>0){
        $breakInfo=$breakInfo[0]->breaks;        
        $breakInfo=explode(',', $breakInfo);        
    }
    return $breakInfo;
}

function displayDate($date1){
    if($date1){
        return date('d/m/Y',strtotime($date1));
    }else{
        return "";
    }
    
}

function datePicker($date1){
    if($date1){
        return date('m/d/Y',strtotime($date1));
    }else{
        return "";
    }
    
}

function displayTime($date1){    
    if($date1){
        return date('h:i a',strtotime($date1));
    }else{
        return "";
    }
}

function displayDateTime($date1){
    if($date1){
        return date('d-m-Y h:i a',strtotime($date1));
    }else{
        return "";
    }
}

function sqldateformate($date){
    return date('Y-m-d',strtotime($date));
}

function updatebreakinfointracking($userId,$date){
    $CI = get_instance();
    $CI->load->model('common_model');
   
    $where=array(
        'userid'=>$userId,
        'created_on'=>sqldateformate($date),
    );
    $select=array('break_hours');
    
    $breakInfo=$CI->common_model->selectData(TABLE_USER_BREAKS,$select,$where);
    $returnData='';
    if(count($breakInfo)>0){
        /* $minutes = 0; //declare minutes either it gives Notice: Undefined variable
        // loop throught all the times
        foreach ($breakInfo as $time) {            
            if(!empty($time->break_hours)){
                list($hour, $minute,$seconds) = explode(':', $time->break_hours);
                $minutes += $hour * 60;
                $minutes += $minute;
            }
        }
        
        $hours = floor($minutes / 60);
        $minutes -= $hours * 60; */
        
        $seconds = 0;
        foreach ($breakInfo as $time)
        {
            if(!empty($time->break_hours)){
                list($hour,$minute,$second) = explode(':', $time->break_hours);
                $seconds += $hour*3600;
                $seconds += $minute*60;
                $seconds += $second;
            }
        }
        $hours = floor($seconds/3600);
        $seconds -= $hours*3600;
        $minutes  = floor($seconds/60);
        $seconds -= $minutes*60;
        //https://vasavaa.wordpress.com/2012/03/19/sum-time-with-format-hhmmss-by-using-php/
        // returns the time already formatted
        //return sprintf('%02d:%02d', $hours, $minutes);
        $returnData="$hours:$minutes:$seconds";
    }
    return $returnData;
}

function sumofTimes($time1='',$time2=''){
    $breakInfo=array($time1,$time2);
    $returnData='';
    if(count($breakInfo)>0){
        $minutes = 0; //declare minutes either it gives Notice: Undefined variable
        // loop throught all the times
        foreach ($breakInfo as $time) {
            if(!empty($time)){
                list($hour, $minute,$seconds) = explode(':', $time);
                $minutes += $hour * 60;
                $minutes += $minute;
            }
        }
        
        $hours = floor($minutes / 60);
        $minutes -= $hours * 60;
        
        // returns the time already formatted
        //return sprintf('%02d:%02d', $hours, $minutes);
        $returnData="$hours:$minutes:00";
    }
    return $returnData;
}

function getFirstDayofWeek(){
    $currentDate=date("Y-m-d");
    $dateTime = new DateTime($currentDate);    
    $weekNo = $dateTime->format("W");    
    $newDate = new DateTime();
    $newDate->setISODate($dateTime->format("Y"), $weekNo);
    //pre($newDate,1);
    return $newDate->date;
}

function getTimeDiffrence($startTime,$currentTime){
    $dteStart = new DateTime($startTime);
    $dteEnd   = new DateTime($currentTime);
    
    $dteDiff  = $dteStart->diff($dteEnd); 
    
    return $dteDiff->format("%H:%I:%S");
    //return $dteDiff->format("%H:%I:%S");
}

?>