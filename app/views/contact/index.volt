{{ content() }}

<div class="page-header">
    <h2>Contact Us</h2>
</div>

<p>Send us a message and let us know how we can better improve the site.  Please be as descriptive as possible as it will help us serve your needs better.</p>

{{ form('contact/send', 'class': 'form-horizontal') }}
    <fieldset>
        <div class="form-group">
            <label class="control-label" for="name">Your Full Name</label>
            {{ text_field('name', 'class': 'input-xlarge') }}
            <p class="help-block">(required)</p>
        </div>
        <div class="form-group">
            <label class="control-label" for="email">Email Address</label>
            {{ text_field('email', 'class': 'input-xlarge') }}
            <p class="help-block">(required)</p>
        </div>
        <div class="form-group">
            <label class="control-label" for="comments">Comments</label>
            {{ text_area('comments', 'rows': '5', 'class': 'input-xlarge') }}
            <p class="help-block">(required)</p>
        </div>
        <div class="form-actions">
            {{ submit_button('Send', 'class': 'btn btn-primary btn-large') }}
        </div>
    </fieldset>
</form>
