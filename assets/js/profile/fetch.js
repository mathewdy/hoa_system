$(document).ready(function() {
  $.ajax({
    url: "/hoa_system/core/profile/getProfile.php",
    type: "GET",
    dataType: "json",
    success: function(response) {
      if (response.status === "success" && response.data) {
        const user = response.data;

        $("#userName").text(user.first_name + ' ' + user.last_name);
        $("#userRole").text(user.role);
        $("#userAvatar").attr("src", user.avatar);

        $("#dropdownUserName").text(user.full_name);
        $("#dropdownUserEmail").text(user.email);
        $("#dropdownUserAvatar").attr("src", user.avatar);
      } else {
        console.warn("User not found or unauthorized:", response.message);
      }
    },
    error: function(xhr, status, error) {
      console.error("Error fetching user data:", error);
    }
  });
});
