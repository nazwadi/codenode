<?php use Phalcon\Tag as Tag ?>

<?php echo Tag::form("tracks/create") ?>

<ul class="pager">
    <li class="previous left">
        <?php echo Tag::linkTo(array("tracks", "&larr; Go Back")) ?>
    </li>
    <li class="right">
        <?php echo Tag::submitButton(array("Save", "class" => "btn btn-success")) ?>
    </li>
</ul>

<?php echo $this->getContent() ?>

<div class="center scaffold">
    <h2>Create Track</h2>

    <div class="clearfix">
        <label for="name">Name</label>
        <?php echo Tag::textField(array("name", "class" => "form-control", "size" => 24, "maxlength" => 70)) ?>
    <//div>

</div>
</form>
