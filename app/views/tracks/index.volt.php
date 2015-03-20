<?php use Phalcon\Tag as Tag ?>

<?php echo $this->getContent() ?>

<div align="right">
    <?php echo Tag::linkTo(array("tracks/new", "Create Track", "class" => "btn btn-primary")) ?>
</div>

<?php echo Tag::form(array("tracks/search", "autocomplete" => "off")) ?>

<div class="center scaffold">

    <h2>Search Tracks</h2>

    <div class="clearfix">
        <label for="id">Id</label>
        <?php echo Tag::textField(array("id", "class" => "form-control", "size" => 10, "maxlength" => 10, "type" => "number")) ?>
    </div>
    
    <div class="clearfix">
        <label for="name">Name</label>
        <?php echo Tag::textField(array("name", "class" => "form-control", "size" => 24, "maxlength" => 70)) ?>
    </div>

    <div class="clearfix">
        <?php echo Tag::submitButton(array("Search", "class" => "btn btn-primary")) ?></td>
    </div>

</div>

</form>
