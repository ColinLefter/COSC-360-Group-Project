$(document).ready(function() {
    $.ajax({
        url: 'backend/getUserAuthority.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            const dropdownMenu = $(".dropdown-menu.custom-dropdown");
  
            if (data.authority >= 1) { // Moderator or higher
                dropdownMenu.append('<li><a class="dropdown-item custom-dropdown" href="moderatorDashboard.php">Moderator Dashboard</a></li>');
            }
            if (data.authority == 2) { // Admin only
                dropdownMenu.append('<li><a class="dropdown-item custom-dropdown" href="adminDashboard.php">Admin Dashboard</a></li>');
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX error:", status, error);
        }
    });
  });
  