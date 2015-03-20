<?php use Phalcon\Tag as Tag ?>

<?php echo $this->getContent() ?>

    <div class="row">
        <div class="col-sm-3">
            <!-- left -->
            <h3><i class="glyphicon glyphicon-briefcase"></i> Track</h3>
            <hr>
            <div class="panel panel-primary">
                <div class="panel-heading">Current Track</div>
                <div class="panel-body">
                    <h2><?php echo $current_track->name; ?></h2>
                    <p>Score:0.00pts</p>
                    <p>Level: 1</p>
                    <p>Next Challenge:<br /><a href="#">Start Here</a></p>
                </div>
            </div>
            <div id="challengeMenu">
                <div class="list-group panel">
                <?php foreach ($tracks as $track) { ?>
                    <a href="#<?php echo $track->uri_name; ?>" class="list-group-item list-group-item-info strong" data-toggle="collapse" data-parent="#challengeMenu"> <span class="glyphicon glyphicon-plus"> <?php echo $track->name; ?> </span><i class="fa fa-caret-down"></i></a>
                    <div class="collapse" id="<?php echo $track->uri_name; ?>">
                    <?php foreach ($categories[$track->id] as $category) { ?>
                        <a href="/challenges/index/<?php echo $track->uri_name; ?>/<?php echo $category->uri_name; ?>" class="list-group-item"><?php echo $category->name; ?></a>
                    <?php } ?>
                    </div>
                <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <!--right -->
            <ol class="breadcrumb">
                <li>Challenges</li>
                <li><a href="#"><?php echo $current_track->name; ?></a></li>
                <li><a href="#"><?php echo $current_category->name; ?></a></li>
            </ol>

<div align="right">
    <?php echo Tag::linkTo(array("challenges/new", "Create Challenge", "class" => "btn btn-primary")) ?>
</div>
<br /><br />
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <td>Status</td>
            <td>Name</td>
            <td>Description</td>
            <td>Difficulty</td>
            <td>Point Value</td>
        </tr>
    </thead>
    <tbody>
    <?php
        if(isset($page->items)) {
            foreach($page->items as $challenge) { ?>
        <tr>
            <td><span class="label label-info">Incomplete</span></td>
            <td><a href="/challenges/view/<?php echo $challenge->uri_name ?>"><?php echo $challenge->name ?></a></td>
            <td><?php echo $challenge->description ?></td>
            <td><?php echo $challenge->difficulty ?></td> 
            <td><?php echo $challenge->point_value ?></td> 
            <td width="12%"><?php echo Tag::linkTo(array("challenges/edit/".$challenge->id, '<i class="icon-pencil"></i> Edit', "class" => "btn")) ?></td>
            <td width="12%"><?php echo Tag::linkTo(array("challenges/delete/".$challenge->id, '<i class="icon-remove"></i> Delete', "class" => "btn")) ?></td>
        </tr>
        <?php }
    } ?>
    </tbody>
        <tbody>
            <tr>
                <td colspan="7" align="right">
                    <div class="btn-group">
                        <?php echo Tag::linkTo(array("challenges/index", '<i class="icon-fast-backward"></i> First', "class" => "btn")) ?>
                        <?php echo Tag::linkTo(array("challenges/index/".$current_track->uri_name."/".$current_category->uri_name."?page=".$page->before, '<i class="icon-step-backward"></i> Previous', "class" => "btn ")) ?>
                        <?php echo Tag::linkTo(array("challenges/index/".$current_track->uri_name."/".$current_category->uri_name."?page=".$page->next, '<i class="icon-step-forward"></i> Next', "class" => "btn")) ?>
                        <?php echo Tag::linkTo(array("challenges/index/".$current_track->uri_name."/".$current_category->uri_name."?page=".$page->last, '<i class="icon-fast-forward"></i> Last', "class" => "btn")) ?>
                        <span class="help-inline"><?php echo $page->current, "/", $page->total_pages ?></span>
                    </div>
                </td>
            </tr>
    </tbody>
</table>
        </div>
    </div>
