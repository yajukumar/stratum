<?php 
defined( 'STRATUM' )or die('Forbidden');

	
class ModelAdmin extends StmModel
{
	public function getActiveEvaluationUsers()
	{
		// $helper = StmFactory::getHelper()->helper('questionnaire');
		$oDb = StmFactory::getDbo();
		$user_query ="select distinct user_id from #_answers ";
		$user_view = $oDb->mysqlQuery($user_query);
		$user_rows = $oDb->mysqlFetchAssocList($user_view);
		
		$data = array();
		foreach ($user_rows as $key => $user) {
			
			$query ="select * from #_users where user_group_id = 2 and id=".$user['user_id'];
			$view = $oDb->mysqlQuery($query);
			if($row = $oDb->mysqlFetchAssoc($view) )
			{
				array_push($data,$row);
			}
		
		}
		// print_r($data);
		return $data;
		

	}

	public function getUserList($current_user_id =NULL)
	{
		// $helper = StmFactory::getHelper()->helper('questionnaire');
		$oDb = StmFactory::getDbo();
		
		$query ="select u.*, ug.group_name from #_users as u,#_user_group as ug where u.user_group_id = ug.id and u.id!=".$current_user_id;
		$view = $oDb->mysqlQuery($query);
		$data = $oDb->mysqlFetchAssocList($view);
		
		return $data;
		

	}


	public function getEvaluation($eid)
	{
		$oDb = StmFactory::getDbo();
		$evaluations_query ="select e.*,u.first_name,u.last_name,u.middle_name from #_evaluations as e, #_users as u where e.id =".$eid." and u.id = e.user_id LIMIT 0,1";
		$evaluations_view = $oDb->mysqlQuery($evaluations_query);
		$evaluations_rows = $oDb->mysqlFetchAssoc($evaluations_view);
		return $evaluations_rows;
	}
	public function getPendingEvaluations()
	{

		$oDb = StmFactory::getDbo();
		$evaluations_query ="select e.*,u.first_name,u.last_name from #_evaluations as e, #_users as u where e.archive = 0 and e.status =1 and e.user_id = u.id order by e.submitted_on DESC";
		$evaluations_view = $oDb->mysqlQuery($evaluations_query);
		$evaluations_rows = $oDb->mysqlFetchAssocList($evaluations_view);
		return $evaluations_rows;

	}
	public function getArchivedEvaluations()
	{

		$oDb = StmFactory::getDbo();
		$evaluations_query ="select e.*,u.first_name,u.last_name from #_evaluations as e, #_users as u where e.archive = 1 and e.user_id = u.id order by e.submitted_on DESC";
		$evaluations_view = $oDb->mysqlQuery($evaluations_query);
		$evaluations_rows = $oDb->mysqlFetchAssocList($evaluations_view);
		return $evaluations_rows;

	}
	public function checkAnswer($user_id,$answer_id,$e_id)
	{
		
		$oDb = StmFactory::getDbo();
		$query ="select * from #_answers where user_id = ".$user_id." and answer_id=".$answer_id." and evaluation_id=".$e_id;
		$view = $oDb->mysqlQuery($query);
		if($row = $oDb->mysqlFetchAssoc($view))
		{
			return $row;
		}
		else
		{
			return false;
		}

	}
	public function updateReportStatus($eid,$report_name)
	{
		$oDb = StmFactory::getDbo();
		$query ="update #_evaluations SET `report_status`= 1, `report_name`='".$report_name."', updated_on=NOW() where `id` = ".$eid;
		$view = $oDb->mysqlQuery($query);
		if($view)
		{
			return true;

		}
		else
		{
			return false;
		}

	}
	public function archiveEvaluation($eid)
	{
		$oDb = StmFactory::getDbo();
		$query ="update #_evaluations SET `archive`= 1 where `id` = ".$eid;
		$view = $oDb->mysqlQuery($query);
		if($view)
		{
			return true;

		}
		else
		{
			return false;
		}

	}
	public function deleteEvaluation($eid)
	{
		$oDb = StmFactory::getDbo();
		$query ="Delete from #_evaluations where `id` = ".$eid;
		$view = $oDb->mysqlQuery($query);
		if($view)
		{
			return true;

		}
		else
		{
			return false;
		}

	}

	/*public function getOptions($parent_id,$level,&$objPHPExcel,$question_column,$answer_column,&$cell_row,$user_id,$e_id)
	{
		// echo $e_id." sadasd<br/>";
		
		$select_data = false;
		$select_options = array();

		$oDb = StmFactory::getDbo();
		
		$query1 ="select * from #_questions where parent_id = ".$parent_id;		
		$view1 = $oDb->mysqlQuery( $query1 );
		$rows = $oDb->mysqlFetchAssocList($view1);		
		
		// while($row1 = $oDb->mysqlFetchAssoc($view1))
		foreach ($rows as $row1) 					
		{

			if($row1['question']!='' && $row1['option']!='' )
			{
				//this is a sub question

				if($answer = $this->checkAnswer($user_id,$row1['id'],$e_id) )
				{
					$cell_row++;
					$objPHPExcel->getActiveSheet()->SetCellValue($question_column.($cell_row),$row1['option']);
					$objPHPExcel->getActiveSheet()->getStyle($question_column.$cell_row)->getAlignment()->setIndent($level);
					// $objPHPExcel->getActiveSheet()->getStyle($question_column.$cell_row)->getFont()->setBold(true);
					if($answer['answer'] == "" )
					{
						
						$objPHPExcel->getActiveSheet()->SetCellValue($answer_column.($cell_row-1),$row1['option']);
					}
					else
					{	

						$objPHPExcel->getActiveSheet()->SetCellValue($answer_column.($cell_row-1), $answer['answer']);
					}
					
					
				}
				else if($row1['type']=='label')
				{
					$cell_row++;

					$objPHPExcel->getActiveSheet()->SetCellValue($question_column.$cell_row,$row1['option']);
					$objPHPExcel->getActiveSheet()->getStyle($question_column.$cell_row)->getAlignment()->setIndent($level);

					 $objPHPExcel->getActiveSheet()->getStyle($question_column.$cell_row)->getFont()->setBold(true);
				}

				$newlevel = $level+1;
				$this->getOptions($row1['id'],$newlevel,$objPHPExcel,$question_column,$answer_column,$cell_row,$user_id,$e_id);

			}
			elseif($row1['question']=='' && trim($row1['option'])!='' )
			{

				//this is the  leaf node.
				if($answer = $this->checkAnswer($user_id,$row1['id'],$e_id))
				{
					$cell_row++;
					if($answer['answer'] == "" )
					{
						
						$objPHPExcel->getActiveSheet()->SetCellValue($answer_column.($cell_row-1), $row1['option']);
					}
					else
					{
						$objPHPExcel->getActiveSheet()->SetCellValue($question_column.($cell_row),$row1['option']);
						$objPHPExcel->getActiveSheet()->getStyle($question_column.$cell_row)->getAlignment()->setIndent($level);
						// $objPHPExcel->getActiveSheet()->getStyle($question_column.$cell_row)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->SetCellValue($answer_column.($cell_row), $answer['answer']);
					}
					
					
				}
				
		 			
			

		 	}
		 	

		}
		

			
	}

	function drawTable($row_id,$level,&$objPHPExcel,&$cell_row,$user_id,$e_id)
	{
		$oDb = StmFactory::getDbo();
		$initial = $cell_row+1;
		$query1 ="select * from #_questions where parent_id = ".$row_id;
		$view1 = $oDb->mysqlQuery($query1);
		$row1s = $oDb->mysqlFetchAssocList($view1);
		// while($row1 = $oDb->mysqlFetchAssoc($view1))
		foreach ($row1s as $row1)		
		{
			$cell_row++;
		
			$column_1 = "B";	
			$objPHPExcel->getActiveSheet()->SetCellValue($column_1.$cell_row, $row1['option']);
			if($cell_row == $initial)
			{
				$objPHPExcel->getActiveSheet()->getStyle($column_1.$cell_row)->getFont()->setBold(true);
			}
			$query2 ="select * from #_questions where parent_id = ".$row1['id'];
			$view2 = $oDb->mysqlQuery($query2);
			$row2s = $oDb->mysqlFetchAssocList($view2);
			
			// while($row2 = $oDb->mysqlFetchAssoc($view2))
			foreach($row2s as $row2)
			{

				$column_1++;
				if($row2['type']!="label")
				{
					$answer = $this->checkAnswer($user_id,$row2['id'],$e_id);

					
					$objPHPExcel->getActiveSheet()->SetCellValue($column_1.$cell_row, $answer['answer']);
					

					
				}
				else
				{ 
					// echo "hi";continue;
					$objPHPExcel->getActiveSheet()->SetCellValue($column_1.$cell_row, $row2['option']);
				}

				if($cell_row == $initial || $column_1 == 'B')
				{
					$objPHPExcel->getActiveSheet()->getStyle($column_1.$cell_row)->getFont()->setBold(true);
				}

			}
			
		}
		
			 // die;
	}*/

	public function toggleStatus($user_id)
	{

		$oDb = StmFactory::getDbo();
		 $toggle_query ="update  #_users set block=1-block where id=".$user_id;
		
		if($toggle_view = $oDb->mysqlQuery($toggle_query))
		{
			return true;	
		}
		else
		{
			return false;
		}
		
		
	}
	public function removeUser($user_id)
	{

		$oDb = StmFactory::getDbo();
		 $remove_query ="Delete from #_users where id=".$user_id;
		
		if($tremove_view = $oDb->mysqlQuery($remove_query))
		{
			return true;	
		}
		else
		{
			return false;
		}
		
		
	}

	public function saveUser() {
		try {
			if(validateFormToken($_POST['token'])){
					StmFactory::getUser()->saveprofile($_POST);
					
				}
			else{
				throw new CustomException("Invalid Token Value.");
			}
		} catch(CustomException $e ){
				echo $e->getError();
		 }
	}

}

?>