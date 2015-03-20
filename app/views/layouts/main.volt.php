<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">CODENODE::</a>
        </div>
            <?php echo $this->elements->getMenu(); ?>
    </div>
</div>

<div class="container">
    <?php echo $this->getContent(); ?>
    <hr>
    <footer>
        <fieldset>
        <p>Footer text goes here.</p>
        </fieldset>
    </footer>
</div>
