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

  function displayTickets(tickets) {
    let container = $("#ticketsContainer");
    container.empty();

    let row = $("<div class='row'></div>"); // Create a row for the grid layout

    tickets.forEach((ticket, index) => {
      let maxLength = 100; // Maximum character length before truncation
      let fullDesc = ticket.ticket_desc
        ? ticket.ticket_desc
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/\n/g, "<br>")
        : "";
      let shortDesc =
        fullDesc.length > maxLength
          ? fullDesc.substring(0, maxLength) + "..."
          : fullDesc;
      let hasMore = fullDesc.length > maxLength; // Check if "Read More" is needed

      let card = `
        <div class="col-lg-4 col-md-15 mb-3">
            <div class="card h-100 shadow-sm border d-flex flex-column">
                <div class="card-body flex-grow-1 d-flex flex-column">
                    <div class="flex-grow-1">
                        <p class="card-text"><strong>Ticket No:</strong> ${
                          ticket.ticket_number
                        }</p>
                        <h5 class="card-title text-uppercase fw-bold">${
                          ticket.ticket_title
                        }</h5>
                        <br>
                        <p class="card-text"><strong>Description:</strong></p>
                        <p class="ticket-description d-flex flex-column text-white">
                            <span class="short-text">${shortDesc}</span>
                            <span class="full-text d-none">${fullDesc}</span>
                            <br>
                            <span class="read-more-container">
                             ${
                               hasMore
                                 ? `<button class="read-more-btn btn btn-sm mt-2" style="border: none; padding: 10px; background-color:rgb(141, 141, 141); color: white;">Read More</button>`
                                 : ""
                             }
                            </span>
                        </p>
                        

                        <h5 class="card-title">
                            <span class="badge bg-${getPriorityColor(
                              ticket.priority
                            )}">
                                ${getPriorityLabel(ticket.priority)}
                            </span>
                        </h5>
                        <span class="badge bg-${getStatusColor(
                          ticket.ticket_status
                        )}">
                            ${ticket.ticket_status}
                        </span>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <p class="card-text mt-2"><strong>Assigned To:</strong> ${
                      ticket.first_name
                    } ${ticket.surname}</p>
                    <div class="buttons-container">
                        <button class="updateTicketBtn"
                            data-bs-toggle="modal" data-bs-target="#updateTicketModal"
                            data-id="${ticket.ticket_id}"
                            data-title="${ticket.ticket_title}"
                            data-desc="${ticket.ticket_desc}" 
                            data-assigned="${ticket.assigned_to}"
                            data-status="${ticket.ticket_status}"
                            data-priority="${ticket.priority}">
                            <div class="btn-content">
                                <i class="fa-solid fa-pen me-1"></i>
                                <p>EDIT</p>
                            </div>
                        </button>
                        <button class="deleteTicketBtn mt-3"
                            data-bs-toggle="modal" data-bs-target="#deleteTicketModal"
                            data-id="${ticket.ticket_id}">
                            <div class="btn-content">
                                <i class="fa-solid fa-trash me-1"></i>
                                <p>DELETE</p>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>`;

      row.append(card);

      // Append row after every 3 items (for better alignment)
      if ((index + 1) % 3 === 0 || index === tickets.length - 1) {
        container.append(row);
        row = $("<div class='row'></div>"); // Start a new row
      }
    });
  }

  // ✅ Properly Handle "Read More" Click Events
  $(document).on("click", ".read-more-btn", function () {
    let parent = $(this).closest(".ticket-description");
    let shortText = parent.find(".short-text");
    let fullText = parent.find(".full-text");

    if (fullText.hasClass("d-none")) {
      fullText.removeClass("d-none");
      shortText.addClass("d-none");
      $(this).text("Read Less");
    } else {
      fullText.addClass("d-none");
      shortText.removeClass("d-none");
      $(this).text("Read More");
    }
  });

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
    let ticketDesc = $(this).data("desc");
    let assignedTo = $(this).data("assigned");
    let ticketStatus = $(this).data("status");
    let ticketPriority = $(this).data("priority");

    // ✅ Populate modal inputs
    console.log("Ticket Data:", {
      ticketId,
      ticketTitle,
      ticketDesc,
      assignedTo,
      ticketStatus,
      ticketPriority,
    });

    $("#updateTicketId").val(ticketId);
    $("#updateTitle").val(ticketTitle).prop("disabled", true);
    $("#updateDesc").val(ticketDesc);
    $("#updateAssignedTo").val(assignedTo);
    $("#updateStatus").val(ticketStatus);
    $("#updatePriority").val(ticketPriority);

    $("#updateAlert").hide();
  });

  // ✅ Handle Update Ticket Form Submission
  $("#updateTicketForm").submit(function (event) {
    event.preventDefault();

    $.ajax({
      url: "update_ticket.php",
      type: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function (response) {
        $("#updateAlert").text(response.message).show();
        setTimeout(() => {
          $("#updateTicketModal").modal("hide");
          location.reload();
        }, 1000);
      },
      error: function () {
        $("#updateAlert").text("❌ Error updating ticket.").show();
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
      let ticketDesc = $(this).attr("data-desc"); // Use attr() instead of data()
      let ticketStatus = $(this).data("status");

      $("#userTicketId").val(ticketId);
      $("#userTicketDesc").val(ticketDesc); // Populate textarea
      $("#userTicketStatus").val(ticketStatus);
      $("#updateAlert").hide();
    });

    // ✅ Handle Form Submission (Show Alert in Modal).
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
            $("#deleteVideoAlert")
              .removeClass("text-danger text-success")
              .show();

            if (response.success) {
              $("#deleteVideoAlert")
                .text(response.message)
                .addClass("text-success");

              // Delay closing the modal and refreshing the page
              setTimeout(() => {
                $("#deleteVideoModal").modal("hide");
                location.reload();
              }, 1500);
            } else {
              $("#deleteVideoAlert")
                .text(response.message)
                .addClass("text-danger");
            }
          },
          error: function () {
            $("#deleteVideoAlert")
              .text("❌ Error deleting video. Please try again.")
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
