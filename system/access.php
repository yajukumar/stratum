<?php
defined( 'STRATUM' )or die('Forbidden');
/**
 * This php framework developed by Cware.
 *  * Blog:http://stratumframework.blogspot.in/
 * Facebook: https://www.facebook.com/pages/Stratum/1374415309549296
 * Twitter: https://twitter.com/StratumFramwork
 * 
 * LICENSE: Read license.txt
 * 
 * @package STRATUM
 * @author Yajuvendra <yajukumar@gmail.com><http://yajukumar.wordpress.com>
 * @copyright 2014-2015
 * @license Read license.txt
 * @version 1.14
 * @since File availabel since Release 1.14
 */

 class StmAccess {

 	public function checkViewLevelAccess() {
		$viewId = $this->getView();
		$defaultview = StmViewUtil::getDefaultView();
		$getDashboardView = StmViewUtil::getDashboardView();
		if($viewId > 0) {
			if($this->getPublicView($viewId)===false){
				$user = StmFactory::getUser()->userGroup();
				$userGroupId = $user->user_group_id;
				$oDb = StmFactory::getDbo();
				if($userGroupId > 0 ) {
					$oDb->mysqlQuery("SELECT *  FROM #_access WHERE user_group_id='$userGroupId' AND view_id='$viewId' ");
					$accesslevel = $oDb->mysqlFetchObjectList();
					if($accesslevel[0]->user_group_id < $userGroupId) {
						StmFactory::getApplication()->setMessage('You are not authorized to access this page.', 'error');
						StmFactory::getApplication()->redirect('view='.$getDashboardView[0]->view);
						//stratumMessageAndExit('You are not authorized to access this pages.');
					}
				} else {
					StmFactory::getApplication()->setMessage('You are not authorized to access this page.', 'error');
					StmFactory::getApplication()->redirect('view='.$defaultview[0]->view);
					//stratumMessageAndExit('You are not authorized to access this page.');
				}
			}
		}
 	}

 	private function getView(){
 		return StmViewUtil::getViewId();
 	}
	
	private function getPublicView($viewId) {
		return StmViewUtil::getPublicView($viewId);
	}
 }