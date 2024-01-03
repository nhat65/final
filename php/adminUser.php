<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lota</title>
  <link rel="icon" href="/assets/Logo/favicon.png" type="image/x-icon" />
  <link rel="stylesheet" href="/css/reset.css" />
  <link rel="stylesheet" href="/css/home.css" />
  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/all.css" />
</head>

<body>

  <!-- main content web -->

  <div class="main">
    <!-- header -->
    <header class="header">
      <!-- nav-left -->
      <div class="nav-left">
        <a href="" class="logo-header">
          <img src="/assets/Logo/logo.png" alt="" />
        </a>

        <nav class="nav-icon-left">
          <button>Trang chủ</button>
          <button class="btnCreate">Tạo</button>
        </nav>
      </div>

      <!-- nav-middle -->
      <nav class="nav-search">
        <input type="text" placeholder="Tìm kiếm..." />
      </nav>

      <!-- nav-right -->
      <nav class="nav-right">
        <div class="icon-notifi"><i class="fa-solid fa-bell"></i></div>

        <div class="icon-chat"><i class="fa-solid fa-comment-dots"></i></div>

        <div class="icon-person ">
          <i class="fa-solid fa-user js-icon-person"></i>

          <div class="subnav-user">
            <div class="subnav-wrap">
              <div class="subnav-name">
                <i class="fa-solid fa-circle-user"></i>
                <span>Phan Ngọc Đăng Huy</span>
              </div>


              <div class="subnav-list">
                <ul>
                  <li><a href="./profile.php">Thông tin cá nhân</a></li>
                  <li><a href="">Quản lý</a></li>
                  <li><a href="">Cài đặt</a></li>
                  <li><a href="">Trợ giúp & hỗ trợ</a></li>
                  <li><a href="">Đăng xuất</a></li>
                </ul>
              </div>
            </div>
          </div>

        </div>
      </nav>
    </header>

    <!-- slider -->
    <div class="slider">
      <div class="slider-img">
        <img src="/assets/pic/banner/travel.png" alt="" />
      </div>
    </div>

    <!-- table  -->
    <div class="table-box">
      <div class="table-wrap">
        <h3>Quan ly Khach hang</h3>

        <table align="center" border="1px" cellspacing="0px" class="customer__table">

          <tr class="customer__table--navbar">
          <td class="customer__table--item" >STT</td>
					<td class="customer__table--item" >Tên KH </td>
					<td class="customer__table--item" >Email</td>
					<td class="customer__table--item" >Mật khẩu</td>
					<td class="customer__table--item" >Giới tính</td>
          <td class="customer__table--item" >Ngày đăng </td>
          <td class="customer__table--item" >Ngày sửa </td>
          <td class="customer__table--item" >Hành Động</td>
          </tr>
          <?php
          $conn = mysqli_connect("127.0.0.1", "root", "", "travelweb2");
          $sql = " SELECT * FROM  users ";
          $result = mysqli_query($conn, $sql);
          while ($row = mysqli_fetch_array($result)) {
          ?>
            <tr class="customer__table--body">
              <td class="customer__table--body-item"><?php echo $row['id'] ?></td>
              <td class="customer__table--body-item"><?php echo $row['username'] ?></td>
              <td class="customer__table--body-item"><?php echo $row['email'] ?></td>
              <td class="customer__table--body-item"><?php echo $row['password'] ?></td>
              <td class="customer__table--body-item"><?php echo $row['gender'] ?></td>
              <td class="customer__table--body-item"><?php echo $row['createAt'] ?></td>
              <td class="customer__table--body-item"><?php echo $row['updateAt'] ?></td>


              <td class="customer__table--body-item">
                <a href="<?php echo $row['id'] ?>" class="customer__table--body-btn-upd">Sửa</a>
                <a href="<?php echo $row['id'] ?>" class="customer__table--body-btn-del">Xóa</a>
              </td>
            </tr>
          <?php
          }
          ?>
        </table>

      </div>
    </div>


  </div>




  <style>
    .customer__table {
      margin: 0 auto;
      width: 80%;
    }


    .customer__table--item {
      padding: 8px;
      text-align: center;

    }

    h3 {
      text-align: center;
      margin-top: 20px;
      margin-bottom: 20px;

    }
  </style>

  </div>
  </div>
  </div>

  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

  <script src="/js/home.js"></script>
</body>

</html>