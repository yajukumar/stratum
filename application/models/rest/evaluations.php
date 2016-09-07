<?php 
	
class ModelEvaluations extends StmModel
{
	public function getUsers()
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
		return $data;
		

	}

	public function checkAnswer($user_id,$answer_id)
	{
		
		$oDb = StmFactory::getDbo();
		$query ="select * from #_answers where user_id = ".$user_id." and answer_id=".$answer_id;
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


	public function getOptions($parent_id,$level,&$objPHPExcel,$question_column,$answer_column,&$cell_row,$user_id)
	{

		$oDb = StmFactory::getDbo();
		$query1 ="select * from #_questions where parent_id = ".$parent_id;
		$view1 = $oDb->mysqlQuery($query1);
		$select_data = false;
		$select_options = array();
		while($row1 = $oDb->mysqlFetchAssoc($view1))
		{
			if($row1['question']!='' && $row1['option']!='' )
			{
				//this is a sub question

				if($answer = checkAnswer($user_id,$row1['id']) )
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
				{$cell_row++;

					$objPHPExcel->getActiveSheet()->SetCellValue($question_column.$cell_row,$row1['option']);
					$objPHPExcel->getActiveSheet()->getStyle($question_column.$cell_row)->getAlignment()->setIndent($level);

					 $objPHPExcel->getActiveSheet()->getStyle($question_column.$cell_row)->getFont()->setBold(true);
				}

				$newlevel = $level+1;
				getOptions($row1['id'],$newlevel,&$objPHPExcel,$question_column,$answer_column,&$cell_row);

			}
			elseif($row1['question']=='' && trim($row1['option'])!='' )
			{

				//this is the  leaf node.
				if($answer = $this->checkAnswer($user_id,$row1['id']))
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

	function drawTable($row_id,$level,&$objPHPExcel,&$cell_row,$user_id)
	{
		$initial = $cell_row+1;
		$query1 ="select * from rt_questions where parent_id = ".$row_id;
		$view1 = mysql_query($query1);
		while($row1 = mysql_fetch_assoc($view1))
		{
			$cell_row++;
		
			$column = "B";	
			$objPHPExcel->getActiveSheet()->SetCellValue($column.$cell_row, $row1['option']);
			if($cell_row == $initial)
			{
				$objPHPExcel->getActiveSheet()->getStyle($column.$cell_row)->getFont()->setBold(true);
			}
			$query2 ="select * from rt_questions where parent_id = ".$row1['id'];
			$view2 = mysql_query($query2);
			while($row2 = mysql_fetch_assoc($view2))
			{
				$column++;
				if($row2['type']!="label")
				{
					$answer = checkAnswer($user_id,$row2['id']);
					$objPHPExcel->getActiveSheet()->SetCellValue($column.$cell_row, $answer['answer']);
				}
				else
				{
					$objPHPExcel->getActiveSheet()->SetCellValue($column.$cell_row, $row2['option']);
				}

				if($cell_row == $initial || $column = 'B')
				{
					$objPHPExcel->getActiveSheet()->getStyle($column.$cell_row)->getFont()->setBold(true);
				}

			}
			
		}
		
			
	}



}

?>