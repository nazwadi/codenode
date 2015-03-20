<?php use Phalcon\Tag as Tag ?>

<?php echo Tag::form("categories/save") ?>

<ul class="pager">
    <li class="previous left">
        <?php echo Tag::linkTo(array("categories", "&larr; Go Back")) ?>
    </li>
    <li class="right">
        <?php echo Tag::submitButton(array("Save", "class" => "btn btn-success")) ?>
    </li>
</ul>

<?php echo $this->getContent() ?>

<div class="center scaffold">
    <h2>Edit Categories</h2>

    <input type="hidden" name="id" id="id" value="<?php echo $id ?>" />

    <div class="clearfix">
        <label for="track">Track</label>
        <?php echo Tag::select(array("track", $tracks, "class" => "form-control", "using" => array('id', 'name'))); ?>
        <label for="name">Name</label>
        <?php echo Tag::textField(array("name", "class" => "form-control", "size" => 24, "maxlength" => 70)) ?>
    </div>

    </form>
</div>
