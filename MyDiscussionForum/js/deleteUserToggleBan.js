$(document).ready(function() {
    $("button#delete-user").on("click", function(e) {
        e.preventDefault();
        var user = $("h6.user-username").html();
        if (user === "" || user === "N/A") {
            $(this).after("<p class='login-feedback' style='text-align: center; color: red;'>No user selected.</p>");
            return;
        }
        $(this).next('.login-feedback').remove(); // Remove existing feedback messages

        if (!confirm("Permanently delete user?")) return;

        $.ajax({
            url: 'backend/deleteUser.php',
            type: 'POST',
            data: { userName: user },
            dataType: 'json',
            success: function(data) {
                if (data.result === "FAIL") {
                    alert("User " + user + " no longer exists.");
                } else if (data.result === "SUCCESS") {
                    alert("User " + user + " successfully deleted.");
                    // Important: we are now triggering a page refresh to update the UI and remove stale data
                    window.location.reload();
                } else {
                    console.log("Unreachable Error, debug php.");
                }
            },
            error: function(xhr, status, error) {
                alert("Error deleting user.");
            }
        });
    });

    // Toggle ban button event
    $("button#ban-user").on("click", function(e) {
        e.preventDefault();
        var user = $("h6.user-username").html();
        if (user === "" || user === "N/A") {
            $(this).after("<p class='login-feedback' style='text-align: center; color: red;'>No user selected.</p>");
            return;
        }
        $(this).next('.login-feedback').remove(); // Remove existing feedback messages

        $.ajax({
            url: 'backend/toggleBan.php',
            type: 'POST',
            data: { userName: user },
            dataType: 'json',
            success: function(data) {
                if (data.result === "FAIL") {
                    alert("User " + user + " no longer exists.");
                } else if (data.result === "SUCCESS") {
                    alert("User " + user + " ban toggled.");
                    // Updating the ban badge based on the toggle status
                    if ($('.user-is-banned').html().includes('Account active')) {
                        $('.user-is-banned').html('<span class="badge bg-danger">Account banned</span>');
                    } else {
                        $('.user-is-banned').html('<span class="badge bg-success">Account active</span>');
                    }
                } else {
                    console.log("Unreachable Error, debug php.");
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert("Error toggling ban.");
            }
        });
    });
});
