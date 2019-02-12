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
        if($this->isAdminManager()==true){
            redirect('/');
        }
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
        $fromdate=$todate=$project='';
        $reporttype=1;
        if($post){
            $fromdate=isset($post['fromdate'])?$post['fromdate']:'';
            $todate=isset($post['todate'])?$post['todate']:'';
            $project=isset($post['project'])?$post['project']:'';
            $reporttype=isset($post['reporttype'])?$post['reporttype']:'';
            $data['post']=$post;
        }else{
            $fromdate=date("m/01/Y");
            //$fromdate=getFirstDayofWeek();
            //$data['post']['fromdate']=$fromdate;
            $data['post']['reporttype']=$reporttype;
        }
        $role=$this->session->userdata ( 'role' );
        $projectId=$this->session->userdata ('projectId' );
        $userId=$this->session->userdata ( 'userId' );
        $currentDate=date("Y-m-d");
        $trakingTable=TABLE_DAILY_TRACKING;
        $userTable=TABLE_USERS;
        $projectsTable=TABLE_MASTER_PROJECTS;
        
        //pre($data,1);
        $where=array(
           // 'dt.userid'=>$userId,            
        );
        if($fromdate){
            $where["dt.created_on >="]=sqldateformate($fromdate);
        }
        if($todate){
            $where["dt.created_on <="]=sqldateformate($todate);
        }
        if($project){
            $where["u.projectId"]=$project;
        }
        
        if($role==ROLE_TEAMLEAD){
            $where["u.roleId !="]=ROLE_MANAGER;
        }
        $select=array('u.name,dt.*,p.name as projectname');
        $join=array(
            "$userTable u"=>"u.userId=dt.userid",
            "$projectsTable p"=>"p.id=u.projectId",
        );
        //selectData($tableName=null,$select=null,$where=null,$join=null,$like=null,$order_by=null,$order=null,$ion_limit=null,$ion_offset=null,$group_by=null)
        $res=$this->common_model->selectData("$trakingTable dt",$select,$where,$join);
        $data['info']=$res;
        if($reporttype && $reporttype==2){
            $result=array();
            $user='';
            foreach ($res as $r){
                
                $name=$r->name;
                $userids=$r->userid;
                $break_hours=$r->break_hours;
                $spend_hours=$r->spend_hours;
                $projectname=$r->projectname;
                
                
                if($user=='' || $userids !=$user){
                    $user=$userids;
                    $breakCount=$hoursCount=0;
                    $days=1;
                }
                
                $hoursCount=sumofTimes($hoursCount,$spend_hours);
                $breakCount=sumofTimes($breakCount,$break_hours);
                $result[$userids]=array(
                    'name'=> $name,
                    'projectname'=>$projectname,
                    'days'=>$days,
                    'hourscount'=>$hoursCount,
                    'breakscount'=>$breakCount
                );
                //echo $userids."==>".$hoursCount."<br>";
                $days++;
                
            }
            //pre($result,1);
            $data['info']=$result;
        }
        
        
        $this->loadViews("reports", $this->global, $data , NULL);
    }
    
    public function getreportdata($post){
        $fromdate=$todate=$project=$reporttype='';
        if($post){
            $fromdate=isset($post['fromdate'])?$post['fromdate']:'';
            $todate=isset($post['todate'])?$post['todate']:'';
            $project=isset($post['project'])?$post['project']:'';
            $reporttype=isset($post['reporttype'])?$post['reporttype']:'';
            $data['post']=$post;
        }else{
            $fromdate="1-".date("m-Y");
        }       
        
        $data=array();
        //$html="Welcome";
        $role=$this->session->userdata ( 'role' );
        $projectId=$this->session->userdata ( 'projectId' );
        $userId=$this->session->userdata ( 'userId' );
        $currentDate=date("Y-m-d");
        $trakingTable=TABLE_DAILY_TRACKING;
        $userTable=TABLE_USERS;
        $projectsTable=TABLE_MASTER_PROJECTS;
        
        $where=array(
        );
        if($fromdate){
            $where["dt.created_on >="]=sqldateformate($fromdate);
        }
        if($todate){
            $where["dt.created_on <="]=sqldateformate($todate);
        }
        if($project){
            $where["u.projectId"]=$project;
        }
        if($role==ROLE_TEAMLEAD){
            $where["u.roleId !="]=ROLE_MANAGER;
        }
        $select=array('u.name,dt.*,p.name as projectname');
        $join=array(
            "$userTable u"=>"u.userId=dt.userid",
            "$projectsTable p"=>"p.id=u.projectId",
        );
        $order_by="dt.userid";
        //selectData($tableName=null,$select=null,$where=null,$join=null,$like=null,$order_by=null,$order=null,$ion_limit=null,$ion_offset=null,$group_by=null)
        $res=$this->common_model->selectData("$trakingTable dt",$select,$where,$join,'',$order_by,$order="asc");
        $data['info']=$res;
        
        if($reporttype && $reporttype!=1){
            $result=array();
            $user='';
            foreach ($res as $r){
                
                $name=$r->name;
                $userids=$r->userid;
                $break_hours=$r->break_hours;
                $spend_hours=$r->spend_hours;
                $projectname=$r->projectname;
                
                
                if($user=='' || $userids !=$user){
                    $user=$userids;
                    $breakCount=$hoursCount=0;
                    $days=1;
                }
                
                $hoursCount=sumofTimes($hoursCount,$spend_hours);
                $breakCount=sumofTimes($breakCount,$break_hours);
                $result[$userids]=array(
                    'name'=> $name,
                    'projectname'=>$projectname,
                    'days'=>$days,
                    'hourscount'=>$hoursCount,
                    'breakscount'=>$breakCount
                );
                //echo $userids."==>".$hoursCount."<br>";
                $days++;
                
            }
            //pre($result,1);
            $data['info']=$result;
        }
        return $data;
    }
    
   
    function pdf(){
        $post= $this->input->get();
        $reporttype=isset($post['reporttype'])?$post['reporttype']:1;
        $data=$this->getreportdata($post);
        if($reporttype==2){
            $html = $this->load->view('report_pdf_summary', $data, true);
        }else{
            $html = $this->load->view('report_pdf_bydays', $data, true);
        }
        
        $this->load->library('pdf');        
        $pdf = $this->pdf->load();        
        $pdf->WriteHTML($html); // write the HTML into the PDF
        
        $pdf->Output('pdffile.pdf','I');
    }
    
    function excel(){
        $post= $this->input->get();
        $reporttype=isset($post['reporttype'])?$post['reporttype']:1;
        $data=$this->getreportdata($post);
        $info=$data['info'];
        if($reporttype==2){
            //$html = $this->load->view('report_pdf_summary', $data, true);
        }else{
            //$html = $this->load->view('report_pdf_bydays', $data, true);
        }
        $style_header = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'E1E0F7'),
            ),
            'font' => array(
                'bold' => true,
            )
        );
        $borderStyle = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK
                )
            )
        );
        $default_style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP
            )
        );
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
        );
        
        //link css
        $link_style_array = array(
            'font'  =>array(
                'color' => array('rgb' => '0000FF'),
                'underline' => 'none'
            )
        );
        //load our new PHPExcel library
        $this->load->library('excel');
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Reports');
        //set cell A1 content with some text
        
       
        //change the font size
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(10);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        //merge cell A1 until D1
        $this->excel->getActiveSheet()->mergeCells('A1:D1');
        //set aligment to center for that merged cell (A1 to D1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
       
        $sheet=$this->excel->getActiveSheet();
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);  
        $sheet->getColumnDimension('H')->setWidth(15); 
        $filename='reports_by_.xlsx'; //save our workbook as this file name
        if($reporttype==1){
            $this->excel->getActiveSheet()->setCellValue('A1',"Reports By day");
            $columnNames=array('Sno','Employee Name','Team','Date','Start Time','End Time','Spend Hours','Break Hours');
            $headcol = 0;
            $headrow=3;
            foreach ($columnNames as $key=>$columns){
                $sheet->setCellValueByColumnAndRow($headcol,$headrow ,$columns);
                $headcol++;
            }
            
            $headrow=4;
            $i=1;
            foreach ($info as $record){
                $columndata=array($i,$record->name,$record->projectname,displayDate($record->day_start),displayTime($record->day_start),
                    displayTime($record->day_end),$record->spend_hours,$record->break_hours
                );
                $headcol = 0;
                foreach ($columndata as $key=>$columns){
                    $sheet->setCellValueByColumnAndRow($headcol,$headrow ,$columns);
                    $headcol++;
                }
                $headrow++;
            
            $i++;
            } 
            $filename='reports_by_days.xlsx'; //save our workbook as this file name
        }elseif($reporttype==2){
            $this->excel->getActiveSheet()->setCellValue('A1',"Reports By Summary");
            $columnNames=array('Sno','Employee Name','Team','Days','Hours Spend','Break Hours');
            $headcol = 0;
            $headrow=3;
            foreach ($columnNames as $key=>$columns){
                $sheet->setCellValueByColumnAndRow($headcol,$headrow ,$columns);
                $headcol++;
            }
            $headrow=4;
            $i=1;
            foreach ($info as $record){
                $columndata=array($i,$record['name'],$record['projectname'],$record['days'],
                    $record['hourscount'],$record['breakscount']
                );
                $headcol = 0;
                foreach ($columndata as $key=>$columns){
                    $sheet->setCellValueByColumnAndRow($headcol,$headrow ,$columns);
                    $headcol++;
                }
                $headrow++;
                
                $i++;
            } 
            $filename='reports_by_summary.xlsx'; //save our workbook as this file name
        }
        
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