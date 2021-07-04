<?php
  if($_SERVER['REQUEST_METHOD'] == 'POST'):

    // Getting the image data in variables
    $image = $_FILES['upload_file'];
    $image_name = $image['name'];
    $image_type = $image['type'];
    $image_temp = $image['tmp_name'];
    $image_size = $image['size'];

    // Setting the errors in an array
    $errors = [];

    // Checking if the image size not greater thant 100k bytes
    if ($image_size > 100000):
      $errors[] = '<div>The image size must not be more than 100k bytes</div>';
    endif;

    // Uploading the image if there are not any errors
    if(empty($errors)):
      
      // moving the uploaded image from the temporary directory to the project image's directory
      move_uploaded_file($image_temp, $_SERVER['DOCUMENT_ROOT'] . '\uploadscript\images\\' . $image_name);
      
      echo 'Image uploaded';

      // If there are any errors, print them
      else:

        foreach($errors as $error):
          echo $error;
        endforeach;

    endif;

  endif;
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload script</title>

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
      <input type="file" name="upload_file" value=""><br><br>
      <input type="submit" value="Upload" value="">
    </form>

    
  </body>
</html>