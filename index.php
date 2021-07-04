<?php
  if($_SERVER['REQUEST_METHOD'] == 'POST'):

    // Getting the image data in variables
    $image = $_FILES['upload_file'];
    $image_name = $image['name'];
    $image_type = $image['type'];
    $image_temp = $image['tmp_name'];
    $image_size = $image['size'];
    $image_error = $image['error'];

    // Setting the allowed image extensions
    $allowed_extensions = ['jpg', 'gif', 'jpeg', 'png'];

    // Checking if there are files
    if ($image_error[0] == 4):

      echo '<div>No files were chosen.</div>';

    else:

      // Counting the uploaded images
      $images_count = count($image_name);

      // Looping through each image
      for ($i = 0; $i < $images_count; $i++) {
        
        // Setting the errors in an array
        $errors = [];

        // Getting the images types
        $image_extension[$i] = explode('.', $image_name[$i]);
        $refined_image_extension[$i] = strtolower(end($image_extension[$i]));
        
        // Checking the valid images types
        if (!in_array($refined_image_extension[$i], $allowed_extensions)):
          $errors[] = '<div>Allowed image types are jpg, gif, jpeg and png only</div>';
        endif;
  
        // Checking if the images size not greater thant 100k bytes
        if ($image_size[$i] > 10000000):
          $errors[] = '<div>The image size must not be more than 100k bytes</div>';
        endif;
  
        // Uploading the images if there are not any errors
        if(empty($errors)):
          
          // moving the uploaded images from the temporary directory to the project images's directory
          move_uploaded_file($image_temp[$i], $_SERVER['DOCUMENT_ROOT'] . '\uploadscript\images\\' . $image_name[$i]);
          
          echo '<div>Image ' . ($i + 1) . ' uploaded</div>';
  
          // If there are any errors, print them
          else:
  
            echo '<div>Image ' . ($i + 1) . ' error</div><div>';
  
            foreach($errors as $error):
              echo $error;
            endforeach;

            echo '</div>';
  
        endif;
      }

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
      <input type="file" name="upload_file[]" multiple="multiple"><br><br>
      <input type="submit" value="Upload" value="">
    </form>

    
  </body>
</html>