<?php
/* 
 * @category   Model
 * @package    STRATUM
 * @author     Mukesh
 * @copyright  2014-2015
 * @license    Read license.txt
 * @version    Release: 1.13
 * @since 	   Class available since Release 1.13 
*/ 
class ModelQuestionnaire extends StmModel
{

	

	public function checkAnswer($user_id,$answer_id,$action,$e_id)
	{
		

		if($action =='new')
		{
			return false;
		}

		$helper = StmFactory::getHelper()->helper('questionnaire');
		$oDb = StmFactory::getDbo();
		$query ="select * from #_answers where user_id = ".$user_id." and answer_id=".$answer_id ." and evaluation_id =".$e_id;
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

	public function getOptions($parent_id,$level,$action,$e_id)
	{

	
	$helper = StmFactory::getHelper()->helper('questionnaire');
	$oDb = StmFactory::getDbo();
	$query1 ="select * from #_questions where parent_id = ".$parent_id;
	$view1 = $oDb->mysqlQuery($query1);
	$select_data = false;
	$select_options = array();
	$rows1 = $oDb->mysqlFetchAssocList($view1);
	$sub_counter = "A";
	foreach ($rows1 as $key => $row1)
	{
		
		if($row1['question']!=NULL && $row1['option']!=NULL )
		{
			
			echo $helper->getHtml($row1,$row1['type'],$level,true,$action,$e_id,$sub_counter);
			$sub_counter++;
			
			

			if( $helper->hasChild($row1['id']) && $helper->isLabel($row1['id'])==false )
			{
				echo "<div style='position:relative;' class='child'>";
			}
			else
			{

				echo "<div style='position:relative;' >";
			}
			
			$newlevel = $level + 1;
			
			self::getOptions($row1['id'],$newlevel,$action,$e_id);
			echo "<div class='clearfix'></div>";
			echo "</div>";

		}
		elseif($row1['question']==NULL && $row1['option']!=NULL && $row1['type']=='select')
		{
			$select_data = true;
			array_push($select_options,$row1);

		}
		elseif($row1['question']==NULL && $row1['option']!=NULL && $row1['type']!='select')
		{
			echo $helper->getHtml($row1,$row1['type'],$level,true,$action,$e_id,$sub_counter);
		}

	}
		if($select_data)
		{
			
			echo $helper->getHtml($select_options,'select',$level,true,$action,$e_id,$sub_counter);
		}
}






public function drawTable($row_id,$level,$action,$e_id){

	$helper = StmFactory::getHelper()->helper('questionnaire');
	$oDb = StmFactory::getDbo();
	$query1 ="select * from #_questions where parent_id = ".$row_id;
	$view1 = $oDb->mysqlQuery($query1);
	$data_options = array();
		echo "<table cellspacing='0' border='1'>";
		$count = 0;
	$sub_counter = "";
	$rows1 = $oDb->mysqlFetchAssocList($view1);
	foreach ($rows1 as $key => $row1) 
	{
		echo "<tr>";
		echo "<th>".$row1['option']."</th>";
		$query2 ="select * from #_questions where parent_id = ".$row1['id'];
		$view2 = $oDb->mysqlQuery($query2);
		

		$rows2 = $oDb->mysqlFetchAssocList($view2);
		foreach($rows2 as $key2 =>$row2)
		{
			if($count ==0)
			{

				echo "<th >".$helper->getHtml($row2,$row2['type'],0,false,$action,$e_id,$sub_counter)."</th>";	
			}
			else
			{
				echo "<td>".$helper->getHtml($row2,$row2['type'],0,false,$action,$e_id,$sub_counter)."</td>";	
			}
		}
		echo "</tr>";
		
		$count ++;
	}
	echo "</table>";
	
		
}

function getCategories()
{
	$helper = StmFactory::getHelper()->helper('questionnaire');
	$oDb = StmFactory::getDbo();
	$query1 ="select * from #_category ";
	$view1 = $oDb->mysqlQuery($query1);
	$rows = $oDb->mysqlFetchAssocList($view1);
	return $rows;
}


function saveAnswer($user_id,$data,$e_id)
{
	

	$oDb = StmFactory::getDbo();
	$query1 ="select * from #_answers where user_id = ".$user_id." and evaluation_id=".$e_id;
	$view1 = $oDb->mysqlQuery($query1);
	$old_data = $oDb->mysqlFetchAssocList($view1);
	$user_data = array();
	$remove_these = array();
	$add_these = array();
	foreach ($old_data as $key => $value) {
		$user_data[$value['answer_id'] ] = $value['answer'];
	}
	// print_r($data);
	// print_r($user_data);
	$remove_these = array_diff_assoc($user_data, $data);// all in user_data but not in data
	$add_these = array_diff_assoc($data, $user_data);// all in data but not in user_data
	// print_r($remove_these);
	// print_r($add_these);
	$flag1 = true;
	$flag2=true;
	if(!empty($remove_these))
	{

		foreach ($remove_these as $answer_id => $answer) 
		{
			$query ="Delete  from #_answers where user_id = ".$user_id." and answer_id=".$answer_id." and answer='".$answer."' and evaluation_id =".$e_id;
			if(!$view = $oDb->mysqlQuery($query))
			{
				$flag1 = false;	
				break;
			}
		}
	}
	if(!empty($add_these))
	{
		foreach ($add_these as $answer_id => $answer) 
		{
			$query ="Insert into #_answers (user_id,answer_id,answer,evaluation_id) VALUES (".$user_id.", ".$answer_id.", '".$answer."', ". $e_id ." )";
			if(!$view = $oDb->mysqlQuery($query))
			{
				$flag2 = false;
				break;
			}
		}
	}
	return $flag1 && $flag2;

}

//This creates a new evaluation
//returns the last inserted row id.
public function createEvaluation($user_id)
{
	$eid = $this->getEvaluation($user_id);
	if(count($eid)>0)
	{
		return $eid[0]['id'];
	}
	$oDb = StmFactory::getDbo();
	$query1 ="Insert into #_evaluations(`user_id`) values(".$user_id.")";
	$view1 = $oDb->mysqlQuery($query1);
	return $oDb->mysqlLastInsertedId();
	
	
}


public function getEvaluation($user_id)
{
	$oDb = StmFactory::getDbo();
	$query1 ="select * from #_evaluations where user_id=".$user_id." and status = 0 order by id DESC";
	$view1 = $oDb->mysqlQuery($query1);
	return $oDb->mysqlFetchAssocList();
	
	
}


public function submit($user_id,$e_id)
{
	$oDb = StmFactory::getDbo();
	$query1 ="update  #_evaluations SET status=1, submitted_on=NOW() where user_id=".$user_id." and id=".$e_id." ";
	$view1 = $oDb->mysqlQuery($query1);
	// return $oDb->mysqlFetchAssocList();
}

public function getSubmissionDate($user_id,$e_id)
{
	$oDb = StmFactory::getDbo();
	$query1 ="select submitted_on from #_evaluations where user_id=".$user_id." and id=".$e_id;
	$view1 = $oDb->mysqlQuery($query1);
	return $oDb->mysqlFetchAssoc();
}
//Export functions


public function exportGetOptions($parent_id,$level,&$objPHPExcel,$question_column,$answer_column,&$cell_row,$user_id,$e_id)
	{
		// echo $e_id." sadasd<br/>";

		$select_data = false;
		$select_options = array();

		$oDb = StmFactory::getDbo();
		
		$query1 ="select * from #_questions where parent_id = ".$parent_id;		
		// echo "<br/>";
		$view1 = $oDb->mysqlQuery( $query1 );
		$rows = $oDb->mysqlFetchAssocList($view1);		
		
		
		// while($row1 = $oDb->mysqlFetchAssoc($view1))
		foreach ($rows as $row1) 					
		{		
			if(!$this->childHasParent($user_id,$row1['id'],$e_id) && !$this->exportCheckAnswer($user_id,$row1['id'],$e_id) ):
				// this is to skip the cases that are children of a answered question but are children of non answered option and are of label type.
				continue;
			endif;

				if($row1['question']!=NULL && $row1['option']!=NULL )
				{
					$answer = $this->exportCheckAnswer($user_id,$row1['id'],$e_id);
					//this is a sub question
					if($row1['type']!='label' && $answer!=NULL )
					{
						$cell_row++;
						$objPHPExcel->getActiveSheet()->SetCellValue($question_column.($cell_row),$row1['option']);
						$objPHPExcel->getActiveSheet()->getStyle($question_column.$cell_row)->getAlignment()->setIndent($level);
						
						if($answer['answer'] == "" )
						{
							
							$objPHPExcel->getActiveSheet()->SetCellValue($answer_column.($cell_row-1),$row1['option']);
						}
						else
						{	

							$objPHPExcel->getActiveSheet()->SetCellValue($answer_column.($cell_row-1), $answer['answer']);
						}
						
						
					}
					else if($row1['type']=='label' )
					{
						$cell_row++;

						$objPHPExcel->getActiveSheet()->SetCellValue($question_column.$cell_row,$row1['option']);
						$objPHPExcel->getActiveSheet()->getStyle($question_column.$cell_row)->getAlignment()->setIndent($level);

						 $objPHPExcel->getActiveSheet()->getStyle($question_column.$cell_row)->getFont()->setBold(true);
					}

					$newlevel = $level+1;

					$this->exportGetOptions($row1['id'],$newlevel,$objPHPExcel,$question_column,$answer_column,$cell_row,$user_id,$e_id);

				}
				elseif($row1['question']==NULL && $row1['option']!=NULL )
				{
					
						//this is the  leaf node.
						$answer = $this->exportCheckAnswer($user_id,$row1['id'],$e_id);
						
						if($answer != NULL)
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

	function exportDrawTable($row_id,$level,&$objPHPExcel,&$cell_row,$user_id,$e_id)
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
					$answer = $this->exportCheckAnswer($user_id,$row2['id'],$e_id);					
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

	public function exportCheckAnswer($user_id,$answer_id,$e_id)
	{
		
		$oDb = StmFactory::getDbo();
		$query ="select * from #_answers where user_id = ".$user_id." and answer_id=".$answer_id." and evaluation_id=".$e_id;
		
		$view = $oDb->mysqlQuery($query);
		$rows = $oDb->mysqlFetchAssocList($view);
		if(isset($rows) && !empty($rows))
		{
			return $rows[0];
		}
		else
		{
			return NULL;
		}

	}

	public function childHasParent($user_id,$answer_id,$e_id)
	{
		
		$oDb = StmFactory::getDbo();
		$query ="select a.*,q.parent_id from #_answers as a LEFT JOIN #_questions as q on a.answer_id=q.id where a.user_id = ".$user_id." and q.parent_id=".$answer_id." and a.evaluation_id=".$e_id;
		
		$view = $oDb->mysqlQuery($query);
		$rows = $oDb->mysqlFetchAssocList($view);
		if(isset($rows) && !empty($rows))
		{
			return true;
		}
		else
		{
			return false;
		}

	}
	




}

?>