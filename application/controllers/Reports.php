<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Reports extends BaseController
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
        $this->load->library('excel');
    }
    
    
    
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'Reports';
        $where=array(
            'isActive'=>1,
        );
        $select=array('*');
        
        $Info=$this->common_model->selectData(TABLE_MASTER_PROJECTS,$select,$where);
        $data=array(
            'projects'=>$Info
        );
        
        
        $post= $this->input->post(); 
        if($post){
            $fromdate=isset($post['fromdate'])?$post['fromdate']:'';
            $todate=isset($post['todate'])?$post['todate']:'';
            $project=isset($post['project'])?$post['project']:'';
            $reporttype=isset($post['reporttype'])?$post['reporttype']:'';
            $data['post']=$post;
        }
        
        $this->loadViews("reports", $this->global, $data , NULL);
    }
    
   
    function byday(){
        //  $html = $this->load->view('pdf_report', $data, true); // render the view into HTML
        //https://davidsimpson.me/2013/05/19/using-mpdf-with-codeigniter/
        $data=array();
        //$html="Welcome";
        $role=$this->session->userdata ( 'role' );
        $projectId=$this->session->userdata ( 'projectId' );
        $userId=$this->session->userdata ( 'userId' );
        $currentDate=date("Y-m-d");
        $where=array(
            'userid'=>$userId,
        );
        $select=array('*');
        
        $res=$this->common_model->selectData(TABLE_DAILY_TRACKING,$select,$where);
        $data['info']=$res;
        if($role == ROLE_MANAGER)
        {
                        
        }
        
        
        $html = $this->load->view('pdf', $data, true);
        $this->load->library('pdf');        
        $pdf = $this->pdf->load();        
        $pdf->WriteHTML($html); // write the HTML into the PDF
        
        $pdf->Output($pdfFilePath);
    }
    
    function excel(){
        
        //load our new PHPExcel library
        $this->load->library('excel');
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('test worksheet');
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', 'This is just some text value');
        //change the font size
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        //merge cell A1 until D1
        $this->excel->getActiveSheet()->mergeCells('A1:D1');
        //set aligment to center for that merged cell (A1 to D1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $filename='just_some_random_name.xlsx'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
        
    }
}

?>