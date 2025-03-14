$(document).ready(function () {
  $.ajax({
    url: "fetch_master_table.php",
    type: "GET",
    dataType: "json",
    success: function (response) {
      console.log(response);
      displayTickets(response.tickets);
      displayUsers(response.users);
      displaySessions(response.sessions);
    },
    error: function (xhr, status, error) {
      console.error("AJAX error:", status, error);
    },
  });

  //<td>${ticket.ticket_desc}</td> ticket description

  // Function to display ticket table
  function displayTickets(tickets) {
    let table = $("#ticketsTable");
    table.empty();
    tickets.forEach((ticket) => {
      let row = `<tr>
      <td><span class="badge bg-${getPriorityColor(ticket.priority)}">
                ${getPriorityLabel(ticket.priority)}
            </span></td>
           <td><strong>${ticket.ticket_number}</strong></td>
            <td>${ticket.ticket_title}</td>
            <td>${ticket.first_name} ${ticket.surname}</td>
            <td><span class="badge bg-${getStatusColor(ticket.ticket_status)}">
                ${ticket.ticket_status}
            </span></td>
          <td style="text-align: center;">
              <button class="btn btn-edit btn-sm updateTicketBtn"
                  style="background-color: #242424; color: white; border: none;"
                  data-bs-toggle="modal" data-bs-target="#updateTicketModal"
                  data-id="${ticket.ticket_id}"
                  data-title="${ticket.ticket_title}"
                  data-assigned="${ticket.assigned_to}"
                  data-status="${ticket.ticket_status}">
                  <i class="fa-solid fa-pen"></i> Edit
              </button>
              <button class="btn btn-danger btn-sm deleteTicketBtn"
                  data-bs-toggle="modal" data-bs-target="#deleteTicketModal"
                  data-id="${ticket.ticket_id}">
                  <i class="fa-solid fa-trash"></i> Delete
              </button>
          </td>
      </tr>`;
      table.append(row);
    });
  }

  // ✅ Get Priority Color
  function getPriorityColor(priority) {
    switch (priority) {
      case "1":
        return "danger"; // Red (Critical)
      case "2":
        return "warning"; // Yellow (Medium)
      case "3":
        return "primary"; // Blue (Low)
      default:
        return "secondary"; // Default color
    }
  }

  function getPriorityLabel(priority) {
    switch (parseInt(priority)) {
      case 1:
        return "Critical";
      case 2:
        return "Medium";
      case 3:
        return "Low";
      default:
        return "Unknown";
    }
  }
  // Function to get status color
  function getStatusColor(status) {
    switch (status.toUpperCase()) {
      case "IN PROGRESS":
        return "primary"; // Blue
      case "ON HOLD":
        return "warning"; // Yellow
      case "DONE":
        return "success"; // Green
      case "OPEN":
        return "danger"; // Red
      case "FOR REVIEW":
        return "info"; // Light Blue
      default:
        return "secondary"; // Grey (Default)
    }
  }

  //DISPLAY USERS TABLE TO FRONT END
  function displayUsers(users) {
    let table = $("#usersTable");
    table.empty();
    users.forEach((user) => {
      let row = `<tr>
                <td>${user.first_name} ${user.middle_name} ${user.surname}</td>
                <td>${user.username}</td>
                <td>${user.email}</td>
                <td>${user.gender}</td>
                <td>${user.dob}</td>
                <td><span class="badge bg-${getUserTypeColor(user.usertype)}">${
        user.usertype
      }</span></td>
            </tr>`;
      table.append(row);
    });
  }

  //DISPLAY SESSIONS TABLE TO FRONT END
  function displaySessions(sessions) {
    let table = $("#sessionsTable");
    table.empty();
    sessions.forEach((session) => {
      let row = `<tr>
                  <td>${session.session_title}</td>
                  <td>${session.session_desc}</td>
                  <td style="text-align: center;">
                      <!-- Edit Button -->
                      <button class="btn btn-sm btn-primary editVideoBtn"
                      style="background-color: #242424; color: white; border: none;"
                          data-bs-toggle="modal"
                          data-bs-target="#editVideoModal"
                          data-id="${session.session_id}"
                          data-title="${session.session_title}"
                          data-desc="${session.session_desc}">
                          <i class="fa-solid fa-pen"></i> Edit
                      </button>
  
                      <!-- Delete Button -->
                      <button class="btn btn-sm btn-danger deleteVideoBtn"
                          data-bs-toggle="modal"
                          data-bs-target="#deleteVideoModal"
                          data-id="${session.session_id}">
                          <i class="fa-solid fa-trash"></i> Delete
                      </button>
                  </td>
              </tr>`;
      table.append(row);
    });
  }

  // ✅ Handle Update Button Click (Load Data into Modal)
  $(document).on("click", ".updateTicketBtn", function () {
    let ticketId = $(this).data("id");
    let ticketTitle = $(this).data("title");
    let assignedTo = $(this).data("assigned");
    let ticketStatus = $(this).data("status");
    let ticketPriority = $(this).data("priority"); // Load priority

    $("#updateTicketId").val(ticketId);
    $("#updateTitle").val(ticketTitle);
    $("#updateAssignedTo").val(assignedTo);
    $("#updateStatus").val(ticketStatus);
    $("#updatePriority").val(ticketPriority); // Set priority in modal
    $("#updateAlert").hide(); // Hide alert when opening
  });

  // ✅ Handle Update Ticket Form Submission (Alert inside Modal)
  $("#updateTicketForm").submit(function (event) {
    event.preventDefault();

    $.ajax({
      url: "update_ticket.php",
      type: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function (response) {
        $("#updateAlert").text(response.message).show(); // Show alert inside modal
        setTimeout(() => {
          $("#updateTicketModal").modal("hide"); // CLOSE MODAL FOR 1 SEC
          location.reload();
        }, 1000);
      },
      error: function () {
        $("#updateAlert").text("❌ Error updating ticket.").show(); // SHOW ERROR MODAL
      },
    });
  });

  // ✅ Handle Delete Button Click (Load Data into Modal)
  $(document).on("click", ".deleteTicketBtn", function () {
    let ticketId = $(this).data("id");
    $("#deleteTicketId").val(ticketId);
    $("#deleteAlert").hide(); // Hide alert when opening modal
  });

  // ✅ Handle Delete Ticket Form Submission (Alert inside Modal)
  $("#confirmDeleteTicket").click(function () {
    let ticketId = $("#deleteTicketId").val();

    $.ajax({
      url: "delete_ticket.php",
      type: "POST",
      data: { ticket_id: ticketId },
      dataType: "json",
      success: function (response) {
        $("#deleteAlert").text(response.message).show(); // Show alert inside modal
        setTimeout(() => {
          $("#deleteTicketModal").modal("hide"); // CLOSE MODAL FOR 1 SEC
          location.reload();
        }, 1000);
      },
      error: function () {
        $("#deleteAlert").text("❌ Error deleting ticket.").show(); // SHOW ERROR MODAL
      },
    });
  });

  $(document).ready(function () {
    // ✅ Handle Delete Announcement Button Click (Load Data into Modal)
    $(document).on("click", ".deleteAnnouncementBtn", function () {
      let announceId = $(this).data("id");
      $("#deleteAnnouncementId").val(announceId);
      $("#deleteAnnounceAlert").hide(); // Hide alert when opening modal
    });

    // ✅ Handle Delete Announcement Form Submission (Alert inside Modal)
    $("#confirmDeleteAnnouncement").click(function () {
      let announceId = $("#deleteAnnouncementId").val();

      $.ajax({
        url: "delete_announcement.php",
        type: "POST",
        data: { announce_id: announceId },
        dataType: "json",
        success: function (response) {
          // Show success message inside modal
          $("#deleteAnnounceAlert").text(response.message).show();

          // Delay closing the modal and refreshing the page
          setTimeout(() => {
            $("#deleteAnnouncementModal").modal("hide"); // Close modal after 1 second
            location.reload();
          }, 1000);
        },
        error: function () {
          // Show error message inside modal
          $("#deleteAlert")
            .text("❌ Error deleting announcement.")
            .removeClass("text-success")
            .addClass("text-danger")
            .show();
        },
      });
    });
  });

  $(document).ready(function () {
    // ✅ Open the Update Ticket Status Modal & Load Data
    $(document).on("click", ".editUserTicketBtn", function () {
      let ticketId = $(this).data("id");
      let ticketStatus = $(this).data("status");

      $("#userTicketId").val(ticketId);
      $("#userTicketStatus").val(ticketStatus);
      $("#updateAlert").hide(); // Hide alert when opening the modal
    });

    // ✅ Handle Form Submission (Show Alert in Modal)
    $("#updateUserTicketForm").submit(function (event) {
      event.preventDefault(); // Prevent default form submission

      $.ajax({
        url: "update_user_ticket.php",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json",
        success: function (response) {
          $("#updateAlert")
            .text(response.message) // Set alert text
            .removeClass("alert-danger") // Remove error styling
            .addClass("alert-success") // Add success styling
            .fadeIn(); // Show alert smoothly

          setTimeout(() => {
            $("#editUserTicketModal").modal("hide"); // Close modal after 1 second
            location.reload(); // Refresh to update UI
          }, 1000);
        },
        error: function () {
          $("#updateAlert")
            .text("❌ Error updating ticket.")
            .removeClass("alert-success") // Remove success styling
            .addClass("alert-danger") // Add error styling
            .fadeIn(); // Show alert
        },
      });
    });
  });

  $(document).ready(function () {
    // ✅ Open the Edit Video Modal & Load Data
    $(document).on("click", ".editVideoBtn", function () {
      let videoId = $(this).data("id");
      let videoTitle = $(this).data("title");
      let videoDesc = $(this).data("desc");

      // Populate modal inputs with data
      $("#editVideoId").val(videoId);
      $("#editVideoTitle").val(videoTitle);
      $("#editVideoDesc").val(videoDesc);

      $("#updateVideoAlert").hide(); // Hide alert when opening the modal
      $("#editVideoModal").modal("show"); // ✅ Ensure modal shows up
    });

    // ✅ Handle Video Update Form Submission (Alert Inside Modal)
    $("#updateVideoForm").submit(function (event) {
      event.preventDefault(); // Prevent default form submission
      let formData = new FormData(this);

      $.ajax({
        url: "update_video.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function (response) {
          if (response.success) {
            $("#updateVideoAlert")
              .text(response.message) // Set alert text
              .removeClass("alert-danger")
              .addClass("alert-success")
              .fadeIn(); // Show alert smoothly

            setTimeout(() => {
              $("#editVideoModal").modal("hide"); // Close modal after 1 second
              location.reload(); // Refresh to update UI
            }, 1000);
          } else {
            $("#updateVideoAlert")
              .text("❌ Error updating video.")
              .removeClass("alert-success")
              .addClass("alert-danger")
              .fadeIn();
          }
        },
        error: function () {
          $("#updateVideoAlert")
            .text("❌ Error updating video.")
            .removeClass("alert-success")
            .addClass("alert-danger")
            .fadeIn();
        },
      });
    });

    $(document).ready(function () {
      // ✅ Open Delete Video Modal & Store Video ID
      $(document).on("click", ".deleteVideoBtn", function () {
        let videoId = $(this).data("id");
        $("#deleteVideoId").val(videoId);
        $("#deleteVideoAlert").hide(); // Hide previous alerts
      });

      // ✅ Handle Delete Video Form Submission (Alert inside Modal)
      $("#confirmDeleteVideo").click(function () {
        let videoId = $("#deleteVideoId").val();

        $.ajax({
          url: "delete_video.php",
          type: "POST",
          data: { session_id: videoId },
          dataType: "json",
          success: function (response) {
            if (response.success) {
              $("#deleteVideoAlert")
                .text(response.message)
                .removeClass("text-danger")
                .addClass("text-success")
                .show();

              // Delay closing the modal and refreshing the page
              setTimeout(() => {
                $("#deleteVideoModal").modal("hide"); // Close modal
                location.reload(); // Refresh to update UI
              }, 1500);
            } else {
              $("#deleteVideoAlert")
                .text("❌ Error deleting video.")
                .removeClass("text-success")
                .addClass("text-danger")
                .show();
            }
          },
          error: function () {
            $("#deleteVideoAlert")
              .text("❌ Error deleting video.")
              .removeClass("text-success")
              .addClass("text-danger")
              .show();
          },
        });
      });
    });

    // Handle Change Password Form Submission
    $("#changePasswordForm").submit(function (event) {
      event.preventDefault(); // Prevent default form submission

      $.ajax({
        url: "change_password.php",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json",
        success: function (response) {
          $("#changePasswordAlert")
            .text(response.message)
            .removeClass("alert-danger")
            .addClass("alert-success")
            .fadeIn();

          setTimeout(() => {
            $("#changePasswordModal").modal("hide");
            window.location.href = "index.php"; // Redirect after success
          }, 2000);
        },
        error: function () {
          $("#changePasswordAlert")
            .text("❌ Error updating password.")
            .removeClass("alert-success")
            .addClass("alert-danger")
            .fadeIn();
        },
      });
    });
  });

  function getUserTypeColor(type) {
    return type === "admin" ? "danger" : "info";
  }
});
