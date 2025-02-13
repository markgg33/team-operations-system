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
            <td><span class="badge bg-${getStatusColor(
              ticket.ticket_status
            )}">${ticket.ticket_status}</span></td>
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

  function getUserTypeColor(type) {
    return type === "admin" ? "danger" : "info";
  }
});
