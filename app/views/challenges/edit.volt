<?php use Phalcon\Tag as Tag ?>

<?php echo Tag::form("challenges/save") ?>

<ul class="pager">
    <li class="previous left">
        <?php echo Tag::linkTo(array("challenges", "&larr; Go Back")) ?>
    </li>
    <li class="right">
        <?php echo Tag::submitButton(array("Save", "class" => "btn btn-success")) ?>
    </li>
</ul>

<?php echo $this->getContent() ?>

<div class="left col-md-6">
    <h2>Edit Challenge Meta-Data</h2>

    <input type="hidden" name="id" id="id" value="<?php echo $id ?>" />

    <div class="clearfix">
        <label for="category">Category</label>
        <?php echo Tag::select(array("category", $challengeCategories, "class" => "form-control", "using" => array('id', 'name'))) ?>
        <br />
        <label for="name">Name</label>
        <?php echo Tag::textField(array("name", "class" => "form-control", "size" => 24, "maxlength" => 70)) ?>
        <label for="description">Description</label>
        <?php echo Tag::textArea(array("description", "class" => "form-control", "cols" => 50, "rows" => 4)) ?>
        <label for="difficulty">Difficulty</label>
        <?php echo Tag::select(array("difficulty", $difficultyLevels, "class" => "form-control", "using" => array('level', 'level'))) ?>
        <label for="points">Point Value</label>
        <?php echo Tag::textField(array("points", "class" => "form-control", "size" => 4, "maxlength" => 3, "type" => "number")) ?>
    </div>
</div>
<div class="left col-md-6">
<h2>Edit Problem Set</h2>
        <label for="problem">Problem</label>
            <?php echo Tag::textArea(array("problem", "class" => "form-control summernote","maxlength" => 65535 )) ?>
    </div>
</div>
</form>
