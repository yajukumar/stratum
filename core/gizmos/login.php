<?php
if(!StmFactory::getSession()->get('userid'))  {
?>
<section class="main">
       <form class="form-3" autocomplete="off" name="loginForm" method="post" action="?view=register&action=login">
            <p class="clearfix">
                <label for="login">Username</label>
               <input name="username:required" type="text" class="input username " placeholder="Username"  data-validation="required" data-validation-error-msg=" "/><!--END USERNAME--><span ></span>
            </p>
            <p class="clearfix">
                <label for="password">Password</label>
                <input name="password:required" type="password" class="input password" placeholder="Password" data-validation="required" data-validation-error-msg=" " /><!--END PASSWORD--></span>
            </p>
            <p class="clearfix">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember me</label><br/><br/>
                &nbsp;&nbsp;&nbsp;<a href="?view=register&action=forgetPass" class="forgot">Forgot password ?</a>
                &nbsp;&nbsp;&nbsp;<a href="?view=register" class="forgot">Register ?</a>
            </p>
            <p class="clearfix">
                <?php echo getFormToken(); ?>
                <input type="submit" name="submit" value="Sign in">
            </p>       
        </form>​
    </section>
    <br/><br/><br/><br/><br/>
<?php
}
?>
