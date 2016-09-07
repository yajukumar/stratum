<?php 
defined( 'STRATUM' )or die('Forbidden');

class ControllerAdmin extends StmController
{

	public function evaluations()
	{ 	//it shows pending evaluations
		$model = new ModelAdmin;
		$users = $model->getActiveEvaluationUsers();
		$evaluations = $model->getPendingEvaluations();
		$this->view('admin_evaluations',array('evaluations'=>$evaluations));
	}
	public function archive()
	{ 	//it shows pending evaluations
		$model = new ModelAdmin;
		$users = $model->getActiveEvaluationUsers();
		$evaluations = $model->getArchivedEvaluations();
		$this->view('admin_archived_evaluations',array('evaluations'=>$evaluations));
	}

	public function users()
	{
		
		$model = new ModelAdmin;
		$user_id = StmFactory::getSession()->get('userid');
		$users = $model->getUserList($user_id);
		$this->view('admin_user_list',array('users'=>$users));
	}

	public function user()
	{
		if(!isset($_POST['uid']))
		{
			StmFactory::getApplication()->redirect('view=admin&action=users');
		}	
		$userdetail = StmFactory::getUser()->userProfileDetail($_POST['uid']);
		$this->view( 'user_details',array('userdetail'=>$userdetail ));
	}

	public function toggleStatus()
	{
		$user_id = $_POST['uid1'];
		$model = new ModelAdmin;
		$model->toggleStatus($user_id);
		StmFactory::getApplication()->redirect('view=admin&action=users');
	}
	public function removeUser()
	{
		$user_id = $_POST['uid2'];
		$model = new ModelAdmin;
		$model->removeUser($user_id);
		StmFactory::getApplication()->redirect('view=admin&action=users');
	}
	public function saveUser()
	{
		
		$model = new ModelAdmin;
		$model->saveUser();
		StmFactory::getApplication()->redirect('view=admin&action=users');
	}

	public function upload()
	{
		if(!isset($_POST['eid']) || !isset($_POST['uid'])) 
		{			
			StmFactory::getApplication()->redirect('view=admin&action=evaluations');
		}

		$model = new ModelAdmin;
		$evaluation_id=$_POST['eid'];
		$user_id = $_POST['uid'];
		//upload file
		if(isset($_FILES['report'])) :
			
			$flag = true;
			if($_FILES['report']['type'] != 'application/pdf' && $_FILES['report']['type'] != 'application/force-download')
			{
				
				$flag = false;				
				StmFactory::getApplication()->setMessage('Invalid file type. Only PDF file allowed', 'error' );
			}
			else if($_FILES['report']['type'] != 'application/force-download')
			{

				if( substr($_FILES['report']['name'],-3,3) !='pdf') 
				{
					
					StmFactory::getApplication()->setMessage('Invalid file type. Only PDF file allowed', 'error' );
					$flag =  false;					
					
				}
			}
			if($flag) :
				$target_dir = "media/reports/";			
				$filename = "EE-Report-".$user_id."-".$evaluation_id.".pdf";
				// $target_file = $target_dir . basename($_FILES["report"]["name"]);
				$target_file = $target_dir . $filename;
				//echo $_FILES["report"]["tmp_name"];
				$uploadOk = 1;
			
				// Check if image file is a actual image or fake image			
				if ($uploadOk == 0) 
				{
				 	StmFactory::getApplication()->setMessage("Sorry, your file was not uploaded.");;
					// if everything is ok, try to upload file
				} 
				else
				{
					if (move_uploaded_file($_FILES["report"]["tmp_name"], $target_file)) 
					{
						$model->updateReportStatus($evaluation_id,$filename);
						StmFactory::getApplication()->setMessage("The file ".$filename. " has been uploaded.");
					}
					else
					{
						StmFactory::getApplication()->setMessage("Sorry, there was an error uploading your file.");
					}
				}
				endif;//flag
				
		endif;
		

		$evaluation = $model->getEvaluation($evaluation_id);
		$this->view('admin_upload',array('evaluation'=>$evaluation));



	}

	/*public function export()
	{
		 $user_id = $_POST['uid'];
		 $evaluation_id = $_POST['eid'];

		$model = new ModelAdmin;
		$helper = StmFactory::getHelper()->helper('evaluations');

		include( BASE_PATH.DS.'application'.DS.'helpers'.DS.'Classes'.DS.'PHPExcel.php' );
		include( BASE_PATH.DS.'application'.DS.'helpers'.DS.'Classes'.DS.'PHPExcel'.DS.'Writer'.DS.'Excel2007.php' );
		
		
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("Excellence Enablers");
		$objPHPExcel->getProperties()->setLastModifiedBy("Excellence Enablers");
		$objPHPExcel->getProperties()->setTitle("Excellence enablers report");
		$objPHPExcel->getProperties()->setSubject("Excellence Enablers");
		$oDb = StmFactory::getDbo();
		$cat_query = "select * from #_category ";
		$view = $oDb->mysqlQuery($cat_query);
		$cat_count=0;
		$cats = $oDb->mysqlFetchAssocList($view);
		// while($cat = $oDb->mysqlFetchAssoc($view))
		foreach($cats as $cat)
		{
			
			$objPHPExcel->createSheet(NULL, $cat_count);
			$objPHPExcel->setActiveSheetIndex($cat_count);
			$title = str_replace('/','-',substr($cat['category'],0,30));
			$objPHPExcel->getActiveSheet()->setTitle( $title );
		
			$oDb = StmFactory::getDbo();
			//main question
			$query ="select * from #_questions where `question` is not NULL and  `category_id`= ".$cat['id']." and `option` is NULL   ORDER BY `order`";	
			$view1 = $oDb->mysqlQuery($query);
			$question_id = NULL;
			$parent_id = NULL;
			$question_type = NULL;
			$counter = 1;
			$first_column = "A";//this is the serial no column
			$question_column = "B";//this is the main question/sub question column
			$answer_column = "C";//Answer column
			$cell_row = 1;
			
			// echo "<pre>";
			$rows = $oDb->mysqlFetchAssocList($view1);
			// while($row = $oDb->mysqlFetchAssoc($view1))
			foreach($rows as $row)
			{
				
					$objPHPExcel->getActiveSheet()->SetCellValue($first_column.$cell_row, $counter);
					$objPHPExcel->getActiveSheet()->getStyle($first_column.$cell_row)->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle($first_column.$cell_row)->getFont()->setSize(14);
					$objPHPExcel->getActiveSheet()->SetCellValue($question_column.$cell_row, $row['question']);
					$objPHPExcel->getActiveSheet()->getStyle($question_column.$cell_row)->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle($question_column.$cell_row)->getFont()->setSize(14);

					 

					$question_id = $row['id'];
					$question_type = $row['type'];

					switch($question_type)
					{
						case 'list': 
						{
							
							 $model->getOptions($row['id'],$level = 1,$objPHPExcel,$question_column,$answer_column,$cell_row,$user_id,$evaluation_id);
							

						}
						break;
						case 'table':
						{

							$model->drawTable($row['id'],$level = 1,$objPHPExcel,$cell_row,$user_id,$evaluation_id);
						}
						break;
						default:{
							
						}
					}
					$cell_row++;
					$counter++;
			

			}
			$cat_count++;
			
		
		}


		
		foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {

		    $objPHPExcel->setActiveSheetIndex($objPHPExcel->getIndex($worksheet));

		    $sheet = $objPHPExcel->getActiveSheet();
		    $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
		    $cellIterator->setIterateOnlyExistingCells(true);
		    
		    foreach ($cellIterator as $cell) {
		        $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
		    }
		}
		$filename = "EE-".$user_id."-".$evaluation_id.".xlsx";
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		$objWriter->save('media/evaluations/'.$filename);
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');		
		$objWriter->save('php://output');
		

	}*/
	//Archive evaluation. used with ajax
	public function archiveEvaluation()
	{
		$evaluation_id = $_POST['eid'];
		$model = new ModelAdmin;
		$model->archiveEvaluation($evaluation_id);


	}


	//Delete evaluation. used with ajax
	public function deleteEvaluation()
	{
		$evaluation_id = $_POST['eid'];
		$model = new ModelAdmin;
		$model->deleteEvaluation($evaluation_id);
	}


	public function getOptions($parent_id,$level,&$objPHPExcel,$question_column,$answer_column,&$cell_row,$user_id,$e_id)
	{
		/*require_once( BASE_PATH.DS.'application'.DS.'helpers'.DS.'Classes'.DS.'PHPExcel.php' );
		require_once( BASE_PATH.DS.'application'.DS.'helpers'.DS.'Classes'.DS.'PHPExcel'.DS.'Writer'.DS.'Excel2007.php' );*/
		
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

				if($answer = checkAnswer($user_id,$row1['id'],$e_id) )
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
				$this->getOptions($row1['id'],$newlevel,$objPHPExcel,$question_column,$answer_column,$cell_row,$e_id);

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
		 	echo "called1";
		}
			
	}

	function drawTable($row_id,$level,&$objPHPExcel,&$cell_row,$user_id,$e_id)
	{
		$initial = $cell_row+1;
		$query1 ="select * from #_questions where parent_id = ".$row_id;
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
			$query2 ="select * from #_questions where parent_id = ".$row1['id'];
			$view2 = mysql_query($query2);
			while($row2 = mysql_fetch_assoc($view2))
			{
				$column++;
				if($row2['type']!="label")
				{
					$answer = checkAnswer($user_id,$row2['id'],$e_id);
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