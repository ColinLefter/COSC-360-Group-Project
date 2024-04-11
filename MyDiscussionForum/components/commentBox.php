<?php session_start();?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/commentBox.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="js/addComment.js"></script>
    <title>MyDiscussionForum</title>
  </head>
  <body>
 
  <section id="comment-box" class="container mt-4 px-4 py-3">
    <p class='reply-to mb-2'>Replying to <a href='#' class='link-info'></a></p>
    <form id='comment' class="d-flex flex-column">
      <textarea id='comment-text-area' name='comment-content' rows='5' class="form-control"></textarea>
      <div class="d-flex justify-content-start gap-2">
          <input type='submit' id='comment-submit-button' class='button-base primary-button' value='Comment'>
          <input type='button' id='comment-discard-button' class='button-base primary-button' value='Discard'>
      </div>
    </form>
  </section>

  <script src="js/functions.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</body>
</html>