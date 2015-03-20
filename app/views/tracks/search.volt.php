<?php use Phalcon\Tag as Tag ?>

<?php echo $this->getContent() ?>

<ul class="pager">
    <li class="previous left">
        <?php echo Tag::linkTo("tracks/index", "&larr; Go Back") ?>
    </li>
    <li class="right">
        <?php echo Tag::linkTo(array("tracks/new", "Create Track", "class" => "btn btn-primary")) ?>
    </li>
</ul>

<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
        </tr>
    </thead>
    <tbody>
    <?php
        if(isset($page->items)) {
            foreach($page->items as $track) { ?>
                <tr>
                    <td><?php echo $track->id ?></td>
                    <td><?php echo $track->name ?></td>
                    <td width="12%"><?php echo Tag::linkTo(array("tracks/edit/".$track->id, '<i class="icon-pencil"></i> Edit', "class" => "btn")) ?></td>
                    <td width="12%"><?php echo Tag::linkTo(array("tracks/delete/".$track->id, '<i class="icon-remove"></i> Delete', "class" => "btn")) ?></td>
                </tr>
                <?php }
        } ?>
        </tbody>
        <tbody>
            <tr>
                <td colspan="4" align="right">
                    <div class="btn-group">
                        <?php echo Tag::linkTo(array("tracks/search", '<i class="icon-fast-backward"></i> First', "class" => "btn")) ?>
                        <?php echo Tag::linkTo(array("tracks/search?page=".$page->before, '<i class="icon-step-backward"></i> Previous', "class" => "btn ")) ?>
                        <?php echo Tag::linkTo(array("tracks/search?page=".$page->next, '<i class="icon-step-forward"></i> Next', "class" => "btn")) ?>
                        <?php echo Tag::linkTo(array("tracks/search?page=".$page->last, '<i class="icon-fast-forward"></i> Last', "class" => "btn")) ?>
                        <span class="help-inline"><?php echo $page->current, "/", $page->total_pages ?></span>
                    </div>
                </td>
            </tr>
    </tbody>
</table>
