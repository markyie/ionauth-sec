<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
    </head>
    <body>
        <h1>Upload Multiple Files</h1>
        <?php echo form_open_multipart(); ?>
        <p>Upload file(s) :</p>
        <?php echo form_upload('uploadedimages[]','','multiple') ?>
        <br/>
        <br/>
        <?php echo form_submit('submit', 'Upload'); ?>
        <?php echo form_close(); ?>
    </body>
</html>
