<?php session_start(); ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <title>MyDiscussionForum</title>
  </head>
  <body>
 
    <section id="forum-body">
        <div class="threadview">
          <h2 style="display: flex" class="threadview-category"><strong>Recent Posts</strong>
            <?php if(isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] === true): ?>
              <input action="action" onclick="window.location.assign('createPost.html');" style="display: inline-block; margin: 0em 0em 0.1em auto; font-size: initial; justify-content: right;" type="submit" class="button-base primary-button" value="Create a post">
            <?php endif; ?>
          </h2>
            <!-- Recent Posts are loaded here -->
        </div>
  
        <div class="threadview-more">
          <p class="load-posts">Load More</p>
        </div>
      </section>

  <script src="js/recentPosts.js"></script>
</body>
</html>