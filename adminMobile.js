document.addEventListener("DOMContentLoaded", function () {
    const hamburger = document.querySelector(".hamburger");
    const sidebar = document.getElementById("team-sidebar");
    const body = document.body;
  
    hamburger.addEventListener("click", function () {
      body.classList.toggle("sidebar-open");
    });
  
    // Close sidebar when clicking outside
    document.addEventListener("click", function (event) {
      if (!sidebar.contains(event.target) && !hamburger.contains(event.target)) {
        body.classList.remove("sidebar-open");
      }
    });
  });
  