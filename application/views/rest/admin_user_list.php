<?php
StmFactory::getSession()->set('breadcrumbs', array('Home' => '#', 'Admin' => '#','Users'=>''));

?>
<div class="header">
            <h3 class='title'>User management</h3>
        </div>
<div class="content">
    <div class="evaluation_container">
        <table class="evaluation_table">
            <thead>
                <tr>
                    
                    <th >Name</th>
                    <th>Email</th>
                    <th >Company</th>
                    <th style="">Registered on</th>
                    <th style="min-width:50px">Id</th>
                    <th style="min-width:100px">Functions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $key => $user) :?>
                <tr>
                     <td><a href="#" class="profile" data-uid="<?php echo $user['id']; ?>"><?php echo ucfirst($user['first_name'])." ".ucfirst($user['last_name']); ?></a></td>
                     <td><?php echo $user['email'] ;?></td>
                     <td><?php echo ucfirst($user['company']) ;?></td>
                     <td><?php echo date('d M,y',strtotime($user['created_date'])) ;?></td>
                     <td><?php echo ucfirst($user['id']) ;?></td>
                     <td>
                         <p class="status <?php echo $user['block'] == 0 ? 'active' : 'inactive' ?>" data-uid="<?php echo $user['id'] ;?>" ><label><i class="  glyphicon glyphicon-user  " title="<?php echo $user['block'] == 0 ? 'Active' : 'Inactive' ?>"></i> <?php echo $user['block'] == 0 ? 'Active' : 'Inactive' ?></label></p>
                        <p class="remove " data-uid="<?php echo $user['id'] ;?>"><label><i class=" remove glyphicon glyphicon-remove" title="Remove"></i> Remove</label></p>
                     </td>
                    
                </tr>
            <?php endforeach;?>
               
            </tbody>
        </table>
    </div>
</div>

<form id="user_details" action="?view=admin&action=user" method="post" name="user" >
    <input type="hidden" name="uid" value="">
</form>

<form id="toggleStatus" action="?view=admin&action=toggleStatus" method="post">
    <input type="hidden" name="uid1" value="">
</form>

<form id="remove" action="?view=admin&action=removeUser" method="post">
    <input type="hidden" name="uid2" value="">
</form>

<script type="text/javascript">
    $(document).ready(function(){

        $("a.profile").click(function(){
            id = $(this).data('uid');
            $("input[type=hidden][name=uid]").val( id );
            $("form#user_details").submit();
        })

    $("p.status").click(function(){
            id = $(this).data('uid');
            
            $("input[type=hidden][name=uid1]").val( id );
            $("form#toggleStatus").submit();
        }) 

    $("p.remove").click(function(){
            id = $(this).data('uid');
            if(confirm("Do you want to delete this user?"))
            {
                $("input[type=hidden][name=uid2]").val( id );
                $("form#remove").submit();
            }
        }) 

    })
</script>

