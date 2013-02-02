<?php
class Result extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$this->show(now());
	}
	
	function show($date=null)
	{
		$startDate = $this->GetStartDate($date);
		
		$data['startDate'] = $startDate;
		$data['endDate'] = date('d-m-Y',strtotime($startDate.'+5 day'));
		
		$data['prev_startDate'] = strtotime($startDate.'-7 day');
		$data['next_startDate'] = strtotime($startDate.'+7 day');
		
		$data['results'] = array();
		for($i = 0;$i<6;$i++)
		{
			$data['results'][] = array('date'=>$startDate,'result'=>$this->result_model->GetResults(array('createDate'=>ConvertToSql($startDate))));
			$startDate = date('d-m-Y',strtotime($startDate.'+1 day'));
		}
		
		$this->load->view('user/result/index',$data);
	}
	
	function GetStartDate($date)
	{
		$weekDay = date('w',$date);
		return date('d-m-Y',strtotime(date('d-m-Y',$date).'-'.--$weekDay.' day'));
	}
	
	function AddResult()
	{
		if($this->input->server('REQUEST_METHOD')=='POST')
		{
			if(date('w',now()) == 1)
				$updateDate = date('Y-m-d',strtotime(date('d-m-Y',now()).'-2 day'));
			else
				$updateDate = date('Y-m-d',strtotime(date('d-m-Y',now()).'-1 day'));
			
			$finish_task = $_POST['finish_task'];
			
			$updateId = $this->result_model->UpdateResult(array('dev_id'=>$_POST['dev_id'],'createDate'=>$updateDate,'finish_task'=>$finish_task));
			
			unset($_POST['finish_task']);
			
			$id = $this->result_model->CreateResult($_POST);
			
			if($id)
			{
				$this->session->set_flashdata('success',$this->config->item('added_result'));
				redirect('user/result');
			}
			else
			{
				$this->session->set_flashdata('error',$this->config->item('db_error'));
				redirect('user/result');	
			}
		}
		$this->load->view('user/result/index');
	}
	
	function EditResult($id)
	{
		if($this->input->server('REQUEST_METHOD') == 'POST')
		{
			if(date('w',now()) == 1)
				$updateDate = date('Y-m-d',strtotime(date('d-m-Y',now()).'-2 day'));
			else
				$updateDate = date('Y-m-d',strtotime(date('d-m-Y',now()).'-1 day'));
			$finish_task = $_POST['finish_task'];
			
			$updateId = $this->result_model->UpdateResult(array('dev_id'=>$_POST['dev_id'],'createDate'=>$updateDate,'finish_task'=>$finish_task));
			
			unset($_POST['finish_task']);
			$_POST['id'] = $id;
			
			$id = $this->result_model->UpdateResult($_POST);
			
			if($id > 0 || $updateId > 0)
			{
				$this->session->set_flashdata('success',$this->config->item('updated_result'));
				redirect('user/result');
			}
			else
			{
				$this->session->set_flashdata('error',$this->config->item('db_error'));
				redirect('user/result');	
			}
		}
	}

	function DeleteResult($id)
	{
		$result = $this->result_model->GetResults(array('id'=>$id));

		if(!$result) redirect('user/result');
				
		if($this->result_model->DeleteResult(array('id'=>$id)))
		{
			$this->session->set_flashdata('success',$this->config->item('deleted_result'));
		}
		else
		{
			$this->session->set_flashdata('error',$this->config->item('db_error'));
		}
		redirect('user/result');
	}

	function GetTodoByDev()
	{
		$id = $_POST['dev_id'];
		if(date('w',now()) == 1)
			$date = date('Y-m-d',strtotime(date('d-m-Y',now()).'-2 day'));
		else
			$date = date('Y-m-d',strtotime(date('d-m-Y',now()).'-1 day'));
		
		$result = $this->result_model->GetResults(array('dev_id'=>$id,'createDate'=>$date));
		
		echo "<span class='show_todo'>";
		if(count($result) > 0)
			echo $result[0]->to_do;
		else
			echo "Nothing";
		echo "</span>";
	}
	
	function GetDataByDev()
	{
		$id = $_POST['id'];
		if(date('w',now()) == 1)
			$date = date('Y-m-d',strtotime(date('d-m-Y',now()).'-2 day'));
		else
			$date = date('Y-m-d',strtotime(date('d-m-Y',now()).'-1 day'));
			
		$result = $this->result_model->GetResults(array('dev_id'=>$id,'createDate'=>$date));
		
		if(isset($result[0])) echo $result[0]->finish_task."#";
		else echo " #";
		
		$date = date('Y-m-d',now());
		$result = $this->result_model->GetResults(array('dev_id'=>$id,'createDate'=>$date));
		
		if(isset($result[0])) 
			echo $result[0]->to_do."#".$result[0]->note;
		else 
			echo " # #";
	}
}
