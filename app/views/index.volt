<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        {{ get_title() }}
        {{ stylesheet_link('bootstrap/css/bootstrap.css') }}
        {{ stylesheet_link('css/style.css') }}
        {{ stylesheet_link('css/summernote.css') }}
        {{ stylesheet_link('font-awesome-4.1.0/css/font-awesome.min.css') }}
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
        <meta name="description" content="Learn to Code">
        <meta name="author" content="Nathan Hicks">
    </head>
    <body>
        {{ content() }}
        {{ javascript_include('js/jquery-1.11.1.min.js') }}
        {{ javascript_include('bootstrap/js/bootstrap.js') }}
        {{ javascript_include('js/utils.js') }}
        {{ javascript_include('js/summernote.min.js') }}
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
