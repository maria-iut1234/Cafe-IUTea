<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8" />

    <link rel="stylesheet" href="emp-man.css" />
    <link
      href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
      rel="stylesheet"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  </head>
  <body>
    
    <div class="sidebar">
      <div class="logo-details">
        <img class="bx icon" src="logo.png" />
        <div class="logo_name">IUTea</div>
        <i class="bx bx-menu" id="btn"></i>
      </div>
      <ul class="nav-list">
        <li>
          <i class="bx bx-search"></i>
          <input type="text" placeholder="Search..." />
          <span class="tooltip">Search</span>
        </li>
        <li>
          <a href="#">
            <i class="bx bx-grid-alt"></i>
            <span class="links_name">Employee<br>Management</span>
          </a>
          <span class="tooltip">Employee Management</span>
        </li>
        <li>
          <a href="#">
            <i class="bx bx-user"></i>
            <span class="links_name">Menu<br>Management</span>
          </a>
          <span class="tooltip">Menu Management</span>
        </li>
        <li>
          <a href="#">
            <i class="bx bx-chat"></i>
            <span class="links_name">Inventory<br>Management</span>
          </a>
          <span class="tooltip">Inventory Management</span>
        </li>
        <li>
          <a href="#">
            <i class="bx bx-pie-chart-alt-2"></i>
            <span class="links_name">Analytics</span>
          </a>
          <span class="tooltip">Analytics</span>
        </li>
        <li>
          <a href="#">
            <i class="bx bx-cog"></i>
            <span class="links_name">Setting</span>
          </a>
          <span class="tooltip">Setting</span>
        </li>
        <li class="profile">
          <div class="profile-details">
            <!--<img src="profile.jpg" alt="profileImg">-->
            <div class="name_job">
              <div class="name">Prem Shahi</div>
              <div class="job">Web designer</div>
            </div>
          </div>
          <i class="bx bx-log-out" id="log_out"></i>
        </li>
      </ul>
    </div>

    <section class="home-section">
      <div class="text">Dashboard</div>
      <button type="button" class="btn click-me">Click Me!</button>
    </section>

    <script src="sidebar.js"></script>
  </body>
</html>
