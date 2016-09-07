<?php
StmFactory::getSession()->set('breadcrumbs', array('Home' => '#', 'Evaluations' => '#', 'Admin' => ''));

?>
<div class="content">
    <div class="evaluation_container">
        <table class="evaluation_table">
            <thead>
                <tr>
                    <th >#</th>
                    <th style="width:200px">Customer</th>
                    <th>Download spreadsheet</th>
                    <th>Upload report</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $key => $user) : ?>
                <tr>
                    <td><?php echo $key +1;?></td>
                    <td ><?php echo $user['first_name']." ".$user['last_name']; ?></td>
                    <td><button data-id='<?php echo $user["id"] ?>' class='download'>Download</button></td>
                    <td><button data-id='<?php echo $user["id"] ?>' class='upload'>Upload</button></td>
                </tr>
            <?php endforeach;?>
               
            </tbody>
        </table>
    </div>
</div>