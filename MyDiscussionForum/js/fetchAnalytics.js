$(document).ready(function () {
  // Fetch Number of Accounts
  fetchDashboardData('backend/fetchNumberOfAccounts.php', function(data) {
    $('.number-of-accounts').text(data.totalUsers);
  });

  // Fetch Daily Active Users
  fetchDashboardData('backend/fetchDailyActiveUsers.php', function(data) {
    $('.daily-active-users').text(data.dailyActiveUsers);
  });

  // Fetch Monthly Active Users
  fetchDashboardData('backend/fetchMonthlyActiveUsers.php', function(data) {
    $('.monthly-active-users').text(data.monthlyActiveUsers);
  });

  function fetchDashboardData(url, successCallback) {
    $.ajax({
      url: url,
      type: 'GET', // Safe to use GET here since this is not sensitive data
      dataType: 'json',
      success: function (data) {
        if(data.result == "SUCCESS") {
          successCallback(data);
        } else {
          console.error('Failed to fetch data:', data.msg);
        }
      },
      error: function (xhr, status, error) {
        console.error('Error fetching dashboard data:', error);
      }
    });
  }
});
