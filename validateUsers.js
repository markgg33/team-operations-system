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

//FOR PASSWORD
function togglePassword(fieldId) {
  let field = document.getElementById(fieldId);
  let icon = field.parentElement.querySelector(".toggle-password i"); // Select icon inside the span

  if (field.type === "password") {
    field.type = "text";
    icon.classList.replace("fa-eye", "fa-eye-slash");
  } else {
    field.type = "password";
    icon.classList.replace("fa-eye-slash", "fa-eye");
  }
}
