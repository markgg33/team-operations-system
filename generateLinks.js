function generateLinks() {
  let path = document.getElementById("urlPath").value.trim();
  if (path === "") {
    clearTables();
    return;
  }

  let environments = {
    "New Preview": [
      `http://dotcom-test.uat.jetstar.com/au/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/nz/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/nz/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/nz/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/nz/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/nz/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/nz/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/nz/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/nz/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/nz/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/nz/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/nz/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/nz/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/nz/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/nz/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/nz/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/nz/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/nz/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/nz/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/nz/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/nz/en/${path}`,

    ],
    CD: [
      `http://jq-redev-prod-cd.jetstar.com/au/en/${path}`,
      `http://jq-redev-prod-cd.jetstar.com/nz/en/${path}`,
      `http://jq-redev-prod-cd.jetstar.com/nz/en/${path}`,
      `http://jq-redev-prod-cd.jetstar.com/nz/en/${path}`,
      `http://jq-redev-prod-cd.jetstar.com/nz/en/${path}`,
      `http://jq-redev-prod-cd.jetstar.com/nz/en/${path}`,
      `http://jq-redev-prod-cd.jetstar.com/nz/en/${path}`,
      `http://jq-redev-prod-cd.jetstar.com/nz/en/${path}`,
      `http://jq-redev-prod-cd.jetstar.com/nz/en/${path}`,
      `http://jq-redev-prod-cd.jetstar.com/nz/en/${path}`,
      `http://jq-redev-prod-cd.jetstar.com/nz/en/${path}`,
      `http://jq-redev-prod-cd.jetstar.com/nz/en/${path}`,
      `http://jq-redev-prod-cd.jetstar.com/nz/en/${path}`,
      `http://jq-redev-prod-cd.jetstar.com/nz/en/${path}`,
      `http://jq-redev-prod-cd.jetstar.com/nz/en/${path}`,
      `http://jq-redev-prod-cd.jetstar.com/nz/en/${path}`,
      `http://jq-redev-prod-cd.jetstar.com/nz/en/${path}`,
      `http://jq-redev-prod-cd.jetstar.com/nz/en/${path}`,
      `http://jq-redev-prod-cd.jetstar.com/nz/en/${path}`,
      `http://jq-redev-prod-cd.jetstar.com/nz/en/${path}`,
      `http://jq-redev-prod-cd.jetstar.com/nz/en/${path}`,
    ],
    Live: [
      `https://www.jetstar.com/au/en/${path}`,
      `https://www.jetstar.com/nz/en/${path}`,
      `https://www.jetstar.com/nz/en/${path}`,
      `https://www.jetstar.com/nz/en/${path}`,
      `https://www.jetstar.com/nz/en/${path}`,
      `https://www.jetstar.com/nz/en/${path}`,
      `https://www.jetstar.com/nz/en/${path}`,
      `https://www.jetstar.com/nz/en/${path}`,
      `https://www.jetstar.com/nz/en/${path}`,
      `https://www.jetstar.com/nz/en/${path}`,
      `https://www.jetstar.com/nz/en/${path}`,
      `https://www.jetstar.com/nz/en/${path}`,
      `https://www.jetstar.com/nz/en/${path}`,
      `https://www.jetstar.com/nz/en/${path}`,
      `https://www.jetstar.com/nz/en/${path}`,
      `https://www.jetstar.com/nz/en/${path}`,
      `https://www.jetstar.com/nz/en/${path}`,
      `https://www.jetstar.com/nz/en/${path}`,
      `https://www.jetstar.com/nz/en/${path}`,
      `https://www.jetstar.com/nz/en/${path}`,
      `https://www.jetstar.com/nz/en/${path}`,
    ],
  };

  populateTable("newPreviewTable", environments["New Preview"]);
  populateTable("cdTable", environments["CD"]);
  populateTable("liveTable", environments["Live"]);
}

function populateTable(tableId, links) {
  let table = document.getElementById(tableId);
  table.innerHTML = ""; // Clear existing content

  links.forEach((link) => {
    let row = document.createElement("tr");
    let cell = document.createElement("td");
    let anchor = document.createElement("a");

    anchor.href = link;
    anchor.textContent = link;
    anchor.target = "_blank"; // Open in new tab

    cell.appendChild(anchor);
    row.appendChild(cell);
    table.appendChild(row);
  });
}

function clearTables() {
  document.getElementById("newPreviewTable").innerHTML = "";
  document.getElementById("cdTable").innerHTML = "";
  document.getElementById("liveTable").innerHTML = "";
}
