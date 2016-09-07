<form autocomplete="off" id="UserGroupForm" name="UserGroupForm" method="post" action="?view=usergroup&action=save">
 <p>&nbsp;</p>
 <p>&nbsp;</p>
 <table align="center" width="375" border="0" cellpadding="0">
 <tr style="background:#09C;">
 <td colspan="2"><strong>User Group Detail:</strong></td>
 </tr>
 <tr>
 <td width="180">Name:</td>
 <td width="614"><label>
 <input type="text" name="group_name" id="username" />
 </label></td>
 </tr>
 <tr>
 <td colspan="2"><label>
 <input type="submit" name="button" id="button" value="Login" />
 </label></td>
 </tr>
 </table>
 <input type="hidden" name="modified_date" value="<?php echo date('Y-m-d H:i:s'); ?>"; />
</form>