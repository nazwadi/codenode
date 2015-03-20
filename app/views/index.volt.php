<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <?php echo $this->tag->getTitle(); ?>
        <?php echo $this->tag->stylesheetLink('bootstrap/css/bootstrap.css'); ?>
        <?php echo $this->tag->stylesheetLink('css/style.css'); ?>
        <?php echo $this->tag->stylesheetLink('css/summernote.css'); ?>
        <?php echo $this->tag->stylesheetLink('font-awesome-4.1.0/css/font-awesome.min.css'); ?>
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
        <meta name="description" content="Learn to Code">
        <meta name="author" content="Nathan Hicks">
    </head>
    <body>
        <?php echo $this->getContent(); ?>
        <?php echo $this->tag->javascriptInclude('js/jquery-1.11.1.min.js'); ?>
        <?php echo $this->tag->javascriptInclude('bootstrap/js/bootstrap.js'); ?>
        <?php echo $this->tag->javascriptInclude('js/utils.js'); ?>
        <?php echo $this->tag->javascriptInclude('js/summernote.min.js'); ?>
<script>
$(document).ready(function() { 
    $('.summernote').summernote({
        height: 150,
        focus: true,
    });
});
</script>
    </body>
</html>
