<?php echo $this->getContent(); ?>
<div class="profile left">
    <?php echo $this->tag->form(array('account/profile', 'id' => 'profileForm', 'onbeforesubmit' => 'return false')); ?>
        <div class="clearfix">
            <label for="name">Your Full Name:</label>
            <div class="input">
                <?php echo $this->tag->textField(array('name', 'size' => '30', 'class' => 'col-sm6 col-md6')); ?>
                <div class="alert-warning" id="name_alert">
                    <strong>Warning!</strong> Please enter your full name
                </div>
            </div>
        </div>
        <div class="clearfix">
            <label for="email">Email Address:</label>
            <div class="input">
                <?php echo $this->tag->textField(array('email', 'size' => '30', 'class' => 'sm6 md6')); ?>
                <div class="alert-warning" id="email_alert">
                    <strong>Warning!</strong> Please enter your email
                </div>
            </div>
        </div>
        <div class="clearfix">
            <input type="button" value="Update" class="btn btn-primary btn-large btn-info" onclick="Profile.validate()">
            &nbsp;
            <?php echo $this->tag->linkTo(array('challenges/index', 'Cancel')); ?>
        </div>
    </form>
