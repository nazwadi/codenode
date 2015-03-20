<?php use Phalcon\Tag as Tag ?>

<?php echo Tag::form("challenges/create") ?>

<ul class="pager">
    <li class="previous left">
        <?php echo Tag::linkTo(array("challenges", "&larr; Go Back")) ?>
    </li>
    <li class="right">
        <?php echo Tag::submitButton(array("Save", "class" => "btn btn-success")) ?>
    </li>
</ul>

<?php echo $this->getContent() ?>

<div class="left">
    <h2>Create a Challenge</h2>

    <div class="clearfix">
        <label for="category">Category</label>
        <?php echo Tag::select(array("category", $challengeCategories, "class" => "form-control", "using" => array('id', 'name'))) ?>
        <br /><br />
        <label for="name">Name</label>
        <?php echo Tag::textField(array("name", "class" => "form-control", "size" => 24, "maxlength" => 70)) ?>
        <br /><br />
        <label for="description">Description</label>
        <?php echo Tag::textArea(array("description", "class" => "form-control", "rows" => 4, "cols" => 50, "maxlength" => 250)) ?>
        <br /><br />
        <label for="difficulty">Difficulty</label>
        <?php echo Tag::select(array("difficulty", $difficultyLevels, "class" => "form-control", "using" => array('level', 'level'))) ?>
        <br /><br />
        <label for="points">Point Value</label>
        <?php echo Tag::textField(array("points", "class" => "form-control", "size" => 4, "maxlength" => 3, "type" => "number")) ?>
        <label for="problem">Problem</label>
            <?php echo Tag::textArea(array("problem", "class" => "form-control summernote","maxlength" => 65535 )) ?>
    </div>
</div>
</form>
