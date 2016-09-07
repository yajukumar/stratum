<?php 
	
class ModelDashboard extends StmModel
{
	
public function getEvaluation($user_id)
{
	$oDb = StmFactory::getDbo();
	$query1 ="select * from #_evaluations where user_id=".$user_id." and status = 0 order by id DESC";
	$view1 = $oDb->mysqlQuery($query1);
	return $oDb->mysqlFetchAssocList();
	
	
}
}

?>