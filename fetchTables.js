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
    let table = $("#ticketsTable");
    table.empty();
    tickets.forEach((ticket) => {
      let row = `<tr>
      <td><strong>${ticket.ticket_number}</strong></td>
      <td>${ticket.ticket_id}</td>
      <td>${ticket.ticket_title}</td>
      <td>${ticket.first_name} ${ticket.surname}</td>
      <td><span class="badge bg-${getStatusColor(ticket.ticket_status)}">
          ${ticket.ticket_status}
      </span></td>
      <td>
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

  function displayUsers(users) {
    let table = $("#usersTable");
    table.empty();
    users.forEach((user) => {
      let row = `<tr>
                <td>${user.team_id}</td>
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

  function displaySessions(sessions) {
    let table = $("#sessionsTable");
    table.empty();
    sessions.forEach((session) => {
      let row = `<tr>
                <td>${session.session_id}</td>
                <td>${session.session_title}</td>
                <td>${session.session_desc}</td>
            </tr>`;
      table.append(row);
    });
  }

  function getStatusColor(status) {
    switch (status) {
      case "In Progress":
        return "primary";
      case "On Hold":
        return "warning";
      case "Done":
        return "success";
      default:
        return "primary";
    }
  }

  // ✅ Handle Update Button Click (Load Data into Modal)
  $(document).on("click", ".updateTicketBtn", function () {
    let ticketId = $(this).data("id");
    let ticketTitle = $(this).data("title");
    let assignedTo = $(this).data("assigned");
    let ticketStatus = $(this).data("status");

    $("#updateTicketId").val(ticketId);
    $("#updateTitle").val(ticketTitle);
    $("#updateAssignedTo").val(assignedTo);
    $("#updateStatus").val(ticketStatus);
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
          $("#updateTicketModal").modal("hide"); // Close modal after 1.5 sec
          location.reload();
        }, 1500);
      },
      error: function () {
        $("#updateAlert").text("❌ Error updating ticket.").show(); // Show error inside modal
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
          $("#deleteTicketModal").modal("hide"); // Close modal after 1.5 sec
          location.reload();
        }, 1500);
      },
      error: function () {
        $("#deleteAlert").text("❌ Error deleting ticket.").show(); // Show error inside modal
      },
    });
  });

  function getUserTypeColor(type) {
    return type === "admin" ? "danger" : "info";
  }
});
