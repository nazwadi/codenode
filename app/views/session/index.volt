{{ content() }}

<div class="login-or-signup">
    <div class="row">

        <div class="col-sm-6 col-md-6">
            <div class="page-header">
                <h2>Log In</h2>
            </div> 
            {{ form('session/start', 'class': 'form-inline') }}
                <fieldset>
                    <div class="form-group">
                        <label class="control-label" for="email">Username/Email</label>
                        <br />
                        {{ text_field('email', 'size': "30", 'class': "form-control input-xlarge") }}
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="password">Password</label>
                        <br />
                        {{ password_field('password', 'size': "30", 'class': "form-control input-xlarge") }}
                    </div>
                    <div class="form-actions">
                        <br />
                        {{ submit_button('Login', 'class': 'btn btn-primary btn-lg') }}
                    </div>
                </fieldset>
            </form>
       </div> 
       
        <div class="col-sm-6 col-md-6">
            <div class="page-header">
                <h2>Don't have an account yet?</h2>
            </div>

            <p>Creating an account offers the following advantages:</p>
            <ul>
                <li>Track your progress through the modules/challenges</li>
                <li>Compare your progress to other users on the leader boards</li>
                <li>Earn achievements</li>
            </ul>

            <div class="clearfix center">
                {{ link_to('session/register', 'Sign Up', 'class': 'btn btn-primary btn-large btn-success') }}
            </div>
        </div>

    </div>
</div>
