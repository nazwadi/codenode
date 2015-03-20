<?php echo $this->getContent(); ?>

<div class="page-header">
    <h2>Register for Codenode</h2>
</div>

<?php echo $this->tag->form(array('session/register', 'id' => 'registerForm', 'class' => 'form-horizontal', 'onbeforesubmit' => 'return false')); ?>
    <fieldset>
        <div class="form-group">
            <label class="control-label" for="name">Your Full Name</label>
            <?php echo $this->tag->textField(array('name', 'class' => 'input-xlarge')); ?>
            <p class="help-block">(required)</p>
            <div class="alert-warning" id="name_alert">
                <strong>Warning!</strong> Please enter your full name
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="username">Username</label>
            <?php echo $this->tag->textField(array('username', 'class' => 'input-xlarge')); ?>
            <p class="help-block">(required)</p>
            <div class="alert-warning" id="username_alert">
                <strong>Warning!</strong> Please enter your desired user name
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="email">Email Address</label>
            <?php echo $this->tag->textField(array('email', 'class' => 'input-xlarge')); ?>
            <p class="help-block">(required)</p>
            <div class="alert-warning" id="email_alert">
                <strong>Warning!</strong> Please enter your email
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="password">Password</label>
            <?php echo $this->tag->passwordField(array('password', 'class' => 'input-xlarge')); ?>
            <p class="help-block">(minimum % characters)</p>
            <div class="alert-warning" id="password_alert">
                <strong>Warning!</strong> Please provide a valid password
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="repeatPassword">Repeat Password</label>
            <?php echo $this->tag->passwordField(array('repeatPassword', 'class' => 'input-xlarge')); ?>
            <div class="alert-warning" id="repeatPassword_alert">
                <strong>Warning!</strong> The password does not match
            </div>
        </div>
        <p>By signing up, you accept terms of use and privacy policy.</p>
        <div class="form-actions">
            <?php echo $this->tag->submitButton(array('Register', 'class' => 'btn btn-primary btn-large', 'onclick' => 'return Signup.validate();')); ?>
        </div>
    </fieldset>
</form>
