// JavaScript function to redirect to login.php after 3 seconds
function redirectToLogin() {
  setTimeout(function () {
    window.location.href = "login.php";
  }, 5000); // 1000 milliseconds = 1 second
}

// Call the redirectToLogin function when the page loads
window.onload = redirectToLogin;

$(document).ready(function () {
  $("form").submit(function (event) {
    let password = $("input[name='password']").val();
    let confirmPassword = $("input[name='confirm_password']").val();

    if (password.length < 7) {
      alert("⚠️ Password must be at least 7 characters long.");
      event.preventDefault(); // Stop form submission
    } else if (password !== confirmPassword) {
      alert("⚠️ Password and Confirm Password do not match.");
      event.preventDefault(); // Stop form submission
    }
  });
});


