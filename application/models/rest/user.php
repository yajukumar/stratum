<?php 
defined( 'STRATUM' )or die('Forbidden');

class ModelUser extends StmModel
{
	public function getArchivedEvaluations($user_id)
	{

		$oDb = StmFactory::getDbo();
		$evaluations_query ="select e.*,u.first_name,u.last_name from #_evaluations as e, #_users as u where  e.user_id = u.id and e.user_id=".$user_id." order by e.id DESC";
		$evaluations_view = $oDb->mysqlQuery($evaluations_query);
		$evaluations_rows = $oDb->mysqlFetchAssocList($evaluations_view);
		return $evaluations_rows;

	}
/*
	public function getOptions($parent_id,$level,&$objPHPExcel,$question_column,$answer_column,&$cell_row,$user_id,$e_id)
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
*/
}