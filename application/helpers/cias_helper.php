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

function getBreakInfoByBreakId($breakId){
        $CI = get_instance();
        $CI->load->model('common_model');
        $userId=$CI->session->userdata ( 'userId' );
        $currentDate=date("Y-m-d");
        $where=array(
            'userid'=>$userId,
            'created_on'=>$currentDate,
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

function displayDate($date1){
    return date('d/m/Y',strtotime($date1));
}

function displayTime($date1){
    return date('h:i a',strtotime($date1));
}

?>