<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="css/adminDashboard.css">
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
  <div class="row">
    <h1 class="my-3">Admin Dashboard</h1>
  </div>

  <div class="row my-5">
    <div class="col">
      <div class="card">
        <div class="container">
          <div class="row">
            <div class="col-8">
              <h2 class="card-title">Number of Accounts</h2>
            </div>
            <div class="col-4 unit">
              <h2>#</h2>
            </div>
          </div>
          <div class="row analytic">
            <h2 class="number-of-accounts"></h2>
          </div>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card">
        <div class="container">
          <div class="row">
            <div class="col-8">
              <h2 class="card-title">Daily Active Users</h2>
            </div>
            <div class="col-4 unit">
              <h2>#</h2>
            </div>
          </div>
          <div class="row analytic">
            <h2 class="daily-active-users"></h2>
          </div>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card">
        <div class="container">
          <div class="row">
            <div class="col-8">
              <h2 class="card-title">Monthly Active Users</h2>
            </div>
            <div class="col-4 unit">
              <h2>#</h2>
            </div>
          </div>
          <div class="row analytic">
            <h2 class="monthly-active-users"></h2>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <h2>New Announcement</h2>
    </div>
  
    <div class="col">
      <h2>Latest Announcements</h>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <input type="text" name="announcement-title" class="form-control text-center my-4" id="validationDefault04" placeholder="Title" required>
      <textarea class="form-control text-center my-4" name="announcement-content" id="announcementContent" placeholder="Content" required></textarea>
      <button id="postAnnouncementBtn" class="primary-button-highlight" type="button">Post announcement</button>
    </div>
    <div class="col announcements my-4"></div>
  </div>
</div>

<div id="footer-placeholder"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="js/fetchAnalytics.js"></script>
<script src="js/handleAnnouncements.js"></script>
<script>
  $(function() {
    $("#navbar-placeholder").load("components/navbarNoSearch.php", function() {
      $(document).trigger('contentLoaded');
    });
  });
</script>
<script>
  $(function(){
    $("#footer-placeholder").load("components/footer.php");
  });
</script>
</body>
</html>