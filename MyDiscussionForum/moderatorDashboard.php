<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="css/moderatorDashboard.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>MyDiscussionForum</title>
  </head>
<body>
<header class="header">
    <div id="navbar-placeholder"></div>
</header>

<div class="container my-5">
  <div class="row row-spacing">
    <h1>Moderator Dashboard</h1>
  </div>

  <div class="row row-spacing">
    <div class="col">
      <h2>User Lookup</h2>
    </div>

    <div class="col right-align">
      <h2>Announcements</h2>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <div>
        <input type="text" name="username" id="userLookupInput" class="form-control text-center my-4" required>
      </div>

      <h2>User data</h2>
      <div class="row row-spacing">
        <div class="col">
          <h6>Username:</h6>
        </div>

        <div class="col">
          <h6 class="right-align user-username"></h6>
        </div>
      </div>

      <div class="row row-spacing">
        <div class="col">
          <h6>Email:</h6>
        </div>

        <div class="col">
          <h6 class="right-align user-email"></h6>
        </div>
      </div>

      <div class="row row-spacing">
        <div class="col">
          <h6>Account age:</h6>
        </div>

        <div class="col">
          <h6 class="right-align user-account-age"></h6>
        </div>
      </div>

      <div class="row row-spacing">
        <div class="col">
          <h6>Frequent communities:</h6>
        </div>
        <div class="col right-align user-communities"></div>
      </div>

      <h2 class="my-3">Actions</h2>
      <div class="row">
        <div class="col pe-1">
          <button class="primary-button-highlight" type="submit" style="align-self: center;">Temporary ban</button>
        </div>
        <div class="col ps-1">
          <button class="primary-button-highlight" type="submit" style="align-self: center;">Delete user</button>
        </div>
      </div>
    </div>

    <div class="col right-align announcements-container">
      <div class="card">
        <div class="announcement">
          <h6>
            Announcement 1
            <span class="bullet-point"></span> 
            Date
            <span class="bullet-point"></span> 
            Author
          </h6>
          <p class="mb-0">
            Description.
          </p>
        </div>
      </div>      
    </div>
  </div>
</div>

</div>

<div id="footer-placeholder"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="js/handleAnnouncements.js"></script>
<script src="js/userLookup.js"></script>
<script>
  $(function(){
    $("#navbar-placeholder").load("components/navbarNoSearch.php");
  });
</script>
<script>
  $(function(){
    $("#footer-placeholder").load("components/footer.php");
  });
</script>
</body>
</html>