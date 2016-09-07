<?php StmFactory::getApplication()->setDocumentTitle('Assign Users'); ?>
<h4>Assign User Groups</h4>
<div>You can Add, Remove User Groups here.</div><br />
<form name="listForm" id="listForm" method="post" action="?view=assign_menu&action=save" class="form-inline">
<!--Clear--><div class="clearfix"></div><!--Clear-->
<div class="container-grid">
<?php
	//Only Admin can accesss this page.
	if(StmFactory::getUser()->isAdmin()){
?>
	<div class="form-group">
		<select class="form-control" style="width: 300px;" name="menu_item_id" onchange="document.listForm.action='?view=assign_menu';document.listForm.submit();">
			<option value=''>-- Select Link --</option>
			<?php
				$menuList = menuList();
				foreach($menuList as $linkname){
					if($_POST['menu_item_id'] == $linkname->id){ $selected = 'selected'; } else{ $selected = ''; }
					echo "<option value='". $linkname->id ."' ". $selected .">". $linkname->title ." - ". $linkname->alias ."</option>";
				}
			?>
		</select>
		<?php
			if($_POST['menu_item_id'] > 0){
				$userGroups = StmFactory::getUser()->userGroupList();
				$selectedGroups = menuUserGroups($_POST['menu_item_id']);
				foreach($userGroups as $userGroup){
					if(in_array($userGroup->id, $selectedGroups)){ $checked = "checked='checked'"; } else{ $checked = ''; }
					echo "<br /><div class='clearfix'></div><div class='col-md-12' style='height: 30px; vertical-align: middle;'><input class='form-control' style='width: 20px;' type='checkbox' name='selectedGroups[]' value='". $userGroup->id ."' ". $checked ." /><label>".$userGroup->group_name."</label></div>";
				}
				echo "<div class='clearfix'></div><br /><input class='btn btn-primary' type='submit' name='save' value='Save' />";
			}
		?>
	</div>
	<?php
	}
	else {
	?>
		<h1 class="bg-danger">You are not authorised to view this page.</h1>
	<?php
	}
?>
</div>
<input type="hidden" name="page" id="page" />
<?php echo getFormToken(); ?>
</form>