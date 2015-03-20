<?php use Phalcon\Tag as Tag ?>
<?php echo $this->getContent() ?>
<ul class="pager">
    <li class="previous left">
        <?php echo Tag::linkTo(array("challenges", "&larr; Go Back")) ?>
    </li>
    <li class="right">
        <?php echo Tag::linkTo(array("challenges/edit/".$data->getChallengeId(), "Edit", "class" => "btn btn-primary")) ?>
</ul>

<h1><?php echo $challenge->name; ?></h1>
<p>
<?php echo $data->getProblem(); ?>
</p>
