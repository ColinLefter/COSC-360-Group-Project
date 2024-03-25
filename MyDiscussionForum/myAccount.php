<?php
session_start();

if (!isset($_SESSION['userLoggedIn']) || $_SESSION['userLoggedIn'] !== true) {
  // Redirect them to the login page
  header("Location: login.html");
  exit;
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="css/myAccount.css">
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
    <div class="col-md-6 center-container left-column">
      <!-- Account settings in the first column -->
      <form id="accountForm" action="backend/updateAccount.php" method="POST">
        <div class="row">
          <h2 class="minor-spacer">Basic Settings</h2>

          <div class="row row-margin-bottom">
            <div class="col">
              <h3 class="setting">First name: </h3>
            </div>
            <div class="col">
              <input type="text" name="firstName" class="form-control text-center" id="validationDefault01" value="<?php echo $_SESSION['firstName'] ?>">
            </div>
          </div>

          <div class="row row-margin-bottom">
            <div class="col">
              <h3 class="setting">Last name: </h3>
            </div>
            <div class="col">
              <input type="text" name="lastName" class="form-control text-center" id="validationDefault02" value="<?php echo $_SESSION['lastName'] ?>">
            </div>
          </div>

          <div class="row row-margin-bottom">
            <div class="col">
              <h3 class="setting">Username: </h3>
            </div>
            <div class="col">
              <input type="text" name="username" class="form-control text-center" id="validationDefault03" value="<?php echo $_SESSION['username'] ?>">
            </div>
          </div>

          <div class="row row-margin-bottom">
            <div class="col">
              <h3 class="setting">Email: </h3>
            </div>
            <div class="col">
              <input type="text"name="email" class="form-control text-center" id="validationDefault04" value="<?php echo $_SESSION['email'] ?>">
            </div>
          </div>

          <div class="row row-margin-bottom">
            <div class="col">
              <h3 class="setting">Password: </h3>
            </div>
            <div class="col">
              <div class="text-icon-wrapper text-accent">
                <a href="resetPassword.html">
                  <p class="text-center inline-text">Change password</p>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="inline-svg w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                  </svg>
                </a>
              </div>       
            </div>
          </div>

          <div class="row space-above">
            <button class="primary-button-highlight" type="submit">Save changes</button>
          </div>
          <div class="row space-above text-center">
            <p id="responseMessage"></p>
          </div>          
        </div>
      </form>
    </div>
    <div class="col-md-6 center-container right-column">
      <h1 class="large-heading">My Account</h1>
    </div>
    </div>
  </div>
</div>

<div id="footer-placeholder"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="js/updateAccount.js"></script>
<script>
  $(function(){
    $("#navbar-placeholder").load("components/navbarNoSearch.html");
  });
</script>
<script>
  $(function(){
    $("#footer-placeholder").load("components/footer.html");
  });
</script>
</body>
</html>