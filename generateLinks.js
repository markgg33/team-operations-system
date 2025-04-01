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
      `http://dotcom-test.uat.jetstar.com/sg/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/ph/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/jp/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/id/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/my/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/th/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/vn/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/lk/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/hk/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/us/en/${path}`,
      `http://dotcom-test.uat.jetstar.com/cn/zh/${path}`,
      `http://dotcom-test.uat.jetstar.com/sg/zh/${path}`,
      `http://dotcom-test.uat.jetstar.com/tw/zh/${path}`,
      `http://dotcom-test.uat.jetstar.com/hk/zh/${path}`,
      `http://dotcom-test.uat.jetstar.com/id/id/${path}`,
      `http://dotcom-test.uat.jetstar.com/th/th/${path}`,
      `http://dotcom-test.uat.jetstar.com/vn/vi/${path}`,
      `http://dotcom-test.uat.jetstar.com/kr/ko/${path}`,
      `http://dotcom-test.uat.jetstar.com/jp/ja/${path}`,

    ],
    CD: [
      `https://edge-jq-redev-prod-cm.jetstar.com/au/en/${path}`,
      `https://edge-jq-redev-prod-cm.jetstar.com/nz/en/${path}`,
      `https://edge-jq-redev-prod-cm.jetstar.com/sg/en/${path}`,
      `https://edge-jq-redev-prod-cm.jetstar.com/ph/en/${path}`,
      `https://edge-jq-redev-prod-cm.jetstar.com/jp/en/${path}`,
      `https://edge-jq-redev-prod-cm.jetstar.com/id/en/${path}`,
      `https://edge-jq-redev-prod-cm.jetstar.com/my/en/${path}`,
      `https://edge-jq-redev-prod-cm.jetstar.com/th/en/${path}`,
      `https://edge-jq-redev-prod-cm.jetstar.com/vn/en/${path}`,
      `https://edge-jq-redev-prod-cm.jetstar.com/lk/en/${path}`,
      `https://edge-jq-redev-prod-cm.jetstar.com/hk/en/${path}`,
      `https://edge-jq-redev-prod-cm.jetstar.com/us/en/${path}`,
      `https://edge-jq-redev-prod-cm.jetstar.com/cn/zh/${path}`,
      `https://edge-jq-redev-prod-cm.jetstar.com/sg/zh/${path}`,
      `https://edge-jq-redev-prod-cm.jetstar.com/tw/zh/${path}`,
      `https://edge-jq-redev-prod-cm.jetstar.com/hk/zh/${path}`,
      `https://edge-jq-redev-prod-cm.jetstar.com/id/id/${path}`,
      `https://edge-jq-redev-prod-cm.jetstar.com/th/th/${path}`,
      `https://edge-jq-redev-prod-cm.jetstar.com/vn/vi/${path}`,
      `https://edge-jq-redev-prod-cm.jetstar.com/kr/ko/${path}`,
      `https://edge-jq-redev-prod-cm.jetstar.com/jp/ja/${path}`,
    ],
    Live: [
      `https://www.jetstar.com/au/en/${path}`,
      `https://www.jetstar.com/nz/en/${path}`,
      `https://www.jetstar.com/sg/en/${path}`,
      `https://www.jetstar.com/ph/en/${path}`,
      `https://www.jetstar.com/jp/en/${path}`,
      `https://www.jetstar.com/id/en/${path}`,
      `https://www.jetstar.com/my/en/${path}`,
      `https://www.jetstar.com/th/en/${path}`,
      `https://www.jetstar.com/vn/en/${path}`,
      `https://www.jetstar.com/lk/en/${path}`,
      `https://www.jetstar.com/hk/en/${path}`,
      `https://www.jetstar.com/us/en/${path}`,
      `https://www.jetstar.com/cn/zh/${path}`,
      `https://www.jetstar.com/sg/zh/${path}`,
      `https://www.jetstar.com/tw/zh/${path}`,
      `https://www.jetstar.com/hk/zh/${path}`,
      `https://www.jetstar.com/id/id/${path}`,
      `https://www.jetstar.com/th/th/${path}`,
      `https://www.jetstar.com/vn/vi/${path}`,
      `https://www.jetstar.com/kr/ko/${path}`,
      `https://www.jetstar.com/jp/ja/${path}`,
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
