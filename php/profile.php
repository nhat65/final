<?php
session_start();
include 'connPDO.php';
if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] != "")){
  $userId = $_SESSION['user_id'];
  $sql_all = "SELECT * FROM posts INNER JOIN typeof ON posts.typeOfId = typeof.id 
  INNER JOIN users ON posts.userId = users.id INNER JOIN city ON posts.cityId = city.id
  WHERE userId = '$userId'";
  $stmt_all = $conn->query($sql_all);
  $all = $stmt_all->fetchAll();
}

//Chỉnh sửa thông tin 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitSave'])){
  $lName = $_POST['lastName'];
  print_r($lName);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lota</title>
  <link rel="icon" href="../assets/Logo/favicon.png" type="image/x-icon" />
  <link rel="stylesheet" href="../css/reset.css" />
  <link rel="stylesheet" href="../css/profile.css" />
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
          <img src="../assets/Logo/logo.png" alt="" />
        </a>

        <nav class="nav-icon-left">
          <a href="./home.php">
            <button>Trang chủ</button>
          </a>
          <button class="btnCreate">Tạo</button>
        </nav>
      </div>


      <!-- nav-right -->
      <nav class="nav-right">
        <div class="icon-notifi">
          <i class="fa-solid fa-bell"></i>
        </div>

        <div class="icon-chat">
          <i class="fa-solid fa-comment-dots"></i>
        </div>

        <div class="icon-person ">
          <i class="fa-solid fa-user js-icon-person"></i>

          <div class="subnav-user">
            <div class="subnav-wrap">
              <div class="subnav-name">
                <i class="fa-solid fa-circle-user"></i>

                <span>
                  <?php
                  if (isset($_SESSION['username'])) {
                    $ten_nguoi_dung = $_SESSION['lName'] . " " . $_SESSION['fName'];
                    echo $ten_nguoi_dung;
                  } else {
                    echo "chua dang nhap";
                    header('Location: login.php');
                    exit();
                  }
                  ?>
                </span>
              </div>


              <div class="subnav-list">
                <ul>
                  <li><a href="profile.php">Thông tin cá nhân</a></li>
                  <li><a href="">Cài đặt</a></li>
                  <li><a href="">Trợ giúp & hỗ trợ</a></li>
                  <li><a href="logOut.php">Đăng xuất</a></li>
                </ul>
              </div>

            </div>
          </div>
        </div>
      </nav>

    </header>

    <!-- body-content -->
    <div class="body-content">

      <div class="infor-user">

        <div class="name-user-wrap">
          <div class="ava-user">
            <img src="../assets/pic/avatar.png" alt="">
          </div>

          <div class="name-user">
            <div class="name-wrap">
              <a href="">
                <h4><?php echo $_SESSION['lName'] . " " . $_SESSION['fName'] ?></h4>
              </a>

              <h5>_tobyy_</h5>

              <button class="edit-btn">
                <i class="fa-solid fa-pen-to-square"></i>
                Chỉnh sửa thông tin
              </button>
            </div>
          </div>
        </div>

        <div class="social-user-wrap">
          <div class="post-user-wrap">
            <p>
              <span><?php echo $stmt_all->rowCount(); ?></span> post
            </p>
          </div>

          <div class="followers-user-wrap">
            <p>
              <span>300</span>
              <a href="">followers</a>
            </p>
          </div>

          <div class="following-user-wrap">
            <p>
              <span>2</span>
              <a href="">following</a>
            </p>
          </div>
        </div>

        <div class="infor-user-line"></div>
      </div>

    </div>

    <!-- display result -->
    <section class="result-box">
      <div class="wrap-result">
        <?php foreach ($all as $post) : ?>
          <div class="card-box">
            <div class="img-box">
              <img src="../assets/pic/<?php echo $post['image'] ?>" alt="">
            </div>
            <div class="title-box">
              <p><?php echo $post['title'] ?></p>
              <div class="user-title-box">
                <i class="fa-solid fa-circle-user"></i>
                <span><?php echo $post['lastName'] . " ".$post['firstName'] ?></span>
              </div>
            </div>
            <div class="action-box">
              <?php if ($post['hideButton'] !== true) : ?>
                <button class="open-modal" data-postid="<?php echo $post['id'] ?>">Open Modal</button>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
    </section>

  </div>

  <!-- modal create post -->
  <div class="modal-create">
    <div class="wrapper-create">
      <!-- icon-close -->
      <span class="icon-close icon-close-create">
        <ion-icon name="close"></ion-icon>
      </span>

      <!-- create-box -->
      <div class="create-form">
        <!-- heading -->
        <div class="heading-box">
          <h3> Tạo bài đăng</h3>
        </div>

        <form action="#" method="post" enctype="multipart/form-data">
          <div class="form-box">
            <div class="form-container">

              <!--  -->
              <div class="form-img">
                <div class="input-file">
                  <div class="drag-container">
                    <div class="drag-wrap">
                      <span><i class="fa-solid fa-arrow-up"></i></span>
                      <div class="text-upload-img">
                        <span>Chọn một tệp hoặc kéo và thả tệp ở đây</span>
                      </div>
                    </div>
                  </div>
                  <input aria-label="Tải tập tin lên" type="file" class="upload-file" id="image" name="image" require>
                </div>
              </div>

              <!--  -->
              <div class="form-details">
                <div class="details-container">
                  <div class="input-box">
                    <label for="addHeader">Tiêu đề</label>
                    <input type="text" id="addHeader" name="title" placeholder="Thêm tiêu đề" required>
                  </div>
                  <div class="input-box">
                    <label for="addDetail">Mô tả</label>
                    <input type="text" id="addDetail" name="description" placeholder="Thêm mô tả chi tiết" required>
                  </div>
                  <div class="input-box">
                    <label for="addType">Loại dịch vụ</label>
                    <select name="type" id="addType">
                      <?php foreach ($typeof as $type) : ?>
                        <option value="<?php echo $type['typeOf']; ?>"><?php echo $type['typeOf']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="input-box">
                    <label for="city">Khu vực</label>
                    <select name="city" id="city">
                      <?php foreach ($cities as $city) : ?>
                        <option value="<?php echo $city['city']; ?>"><?php echo $city['city']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="input-box">
                    <label for="addAddress">Địa chỉ</label>
                    <input type="text" id="addAddress" name="address" placeholder="Thêm địa chỉ" required>
                  </div>
                  <div class="input-box">
                    <label for="addPrice">Mức giá</label>
                    <div class="price-box">
                      <span>Từ: </span>
                      <input type="num" id="addPrice" name="price1" required>
                      <span class="dvt">(VNĐ)</span>
                      <span>Đến: </span>
                      <input type="num" id="addPrice" name="price2">
                      <span class="dvt">(VNĐ)</span>
                    </div>
                  </div>
                  <div class="input-box">
                    <label for="addTime">Thời gian hoạt động</label>
                    <div class="time-box">
                      <span>Từ: </span>
                      <input type="time" id="addTime" name="timeOpen" required>
                      <span>Đến: </span>
                      <input type="time" id="addTime" name="timeClose">
                    </div>
                  </div>
                  <div class="submit-input">
                    <button type="submit" name="submit">Đăng</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- modal edit profile -->
 <form action="" method="post">
 <div class="modal-edit">
    <div class="wrapper-edit">
      <div class="box-heading">
        <div class="heading-wrap">
          <h3>Chỉnh sửa thông tin</h3>
        </div>

        <span class="icon-close icon-close-edit">
          <ion-icon name="close"></ion-icon>
        </span>
      </div>

      <div class="edit-form">
        <div class="form-wrap">

          <!-- profile -->
          <div class="profile-photo">
            <h5>Ảnh đại diện</h5>

            <div class="photo-box">
              <img src="../assets/pic/avatar.png" alt="">

              <div class="icon-pen">
                <i class="fa-light fa-pen-line"></i>
              </div>
            </div>
          </div>
          <div class="line-bottom"></div>

          <!-- fullname -->
          <div class="fullname-box">
            <div class="lastname-box name-box">
              <h5>Họ</h5>

              <div class="input-wrap">
                <input type="text" name="lastName" class="name-box-text" id="" value="haha">
              </div>
            </div>

            <div class="firstname-box name-box">
              <h5>Tên</h5>

              <div class="input-wrap">
                <input type="text" name="firstName" class="name-box-text" id="">
              </div>
            </div>
          </div>
          <div class="line-bottom"></div>

          <!-- gender -->
          <div class="gender-box">
            <h5>Giới tính</h5>

            <div class="gender-box-wrap">
              <div class="male-box">
                <input type="radio" name="gender1" class="name-box-text" id="male" value="0">
                <label for="male">Nam</label>
              </div>

              <div class="female-box">
                <input type="radio" name="gender2" class="name-box-text" id="female" value="1">
                <label for="female">Nữ</label>
              </div>
            </div>
          </div>
          <div class="line-bottom"></div>

          <!-- account -->
          <div class="account-box">
            <div class="email-box name-box">
              <h5>Email</h5>

              <div class="input-wrap">
                <input type="email" name="" class="name-box-text" id="">
              </div>
            </div>

            <div class="email-box name-box">
              <h5>Mật khẩu</h5>

              <div class="input-wrap">
                <input type="password" name="" class="name-box-text" id="">
              </div>
            </div>

            <div class="email-box name-box">
              <h5>Nhập lại</h5>

              <div class="input-wrap">
                <input type="password" name="" class="name-box-text" id="">
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="box-footer">
        <div class="box-footer-wrap">
          <button class="cancel-box">Huỷ</button>
          <button class="save-box" name="submitSave">Lưu</button>
        </div>
      </div>

    </div>
  </div>
 </form>

  <!-- modal display img -->
  <div class="modal-display">
    <div class="wrapper-display">
      <span class="icon-close icon-close-display">
        <ion-icon name="close"></ion-icon>
      </span>

      <!-- heading -->
      <div class="heading-box">
        <h3> Bài đăng của Đăng Huy </h3>
      </div>

      <!-- display-box -->
      <div class="display-form">
        <div class="content-form">
          <div class="img-form">
            <img src="../assets/pic/ruongbacthang4k.png" alt="">
          </div>

          <div class="descrip-form">
            <h4>Ruộng bậc thang 4k tại thành phố Đà Nẵng</h4>
            <h5>Ruộng bậc thang 4K không thể tìm thấy một nơi nào khác đẹp hơn. Với chất lượng hình ảnh siêu cấp VIP và độ phân giải 4K, nó mang đến trải nghiệm tuyệt vời cho mắt người xem. Khung cảnh của ruộng bậc thang được tái hiện rõ nét và sống động, tạo nên một hình ảnh tuyệt đẹp và hấp dẫn không thể sánh bằng.</h5>
            <p>Loại hình dịch vụ: <span>Khách sạn</span></p>
            <p>Tỉnh/Thành phố: <span>Đà nẵng</span></p>
            <p>Thời gian hoạt động: từ <span> 8h00</span> đến <span>23h00</span></p>
            <p>Giá cả: từ <span> 10.000</span> đến <span>20.000</span> (VNĐ)</p>
          </div>
        </div>

        <div class="reaction-box">
          <div class="icon-viewer">
            <i class="fa-solid fa-eye"></i>
            <span>8000</span>
          </div>
          <div class="icon-bookmark">
            <i class="fa-regular fa-bookmark"></i>
            <span>2000</span>
          </div>
          <div class="icon-heart">
            <i class="fa-regular fa-heart"></i>
            <span>6000</span>
          </div>
        </div>

        <div class="comment-box">
          <div class="comment-wrap">
            <div class="ava-user">
              <i class="fa-solid fa-circle-user"></i>
            </div>
            <div class="comment-user">
              <div class="name-wrap">
                <a href="">Phan Ngọc Đăng Huy</a>
              </div>
              <div class="comment-detail">
                <p>
                  Comment này hay quá, tuỵt vời quá, 10đ.Comment này hay quá, tuỵt vời quá, 10đ.Comment này hay quá, tuỵt vời quá, 10đ.Comment này hay quá, tuỵt vời quá, 10đ.
                </p>
              </div>
            </div>
          </div>
          <div class="comment-wrap">
            <div class="ava-user">
              <i class="fa-solid fa-circle-user"></i>
            </div>
            <div class="comment-user">
              <div class="name-wrap">
                <a href="">Phan Ngọc Đăng Huy</a>
              </div>
              <div class="comment-detail">
                <p>
                  Comment này hay quá, tuỵt vời quá, 10đ.Comment này hay quá, tuỵt vời quá, 10đ.Comment này hay quá, tuỵt vời quá, 10đ.Comment này hay quá, tuỵt vời quá, 10đ.
                </p>
              </div>
            </div>
          </div>
          <div class="comment-wrap">
            <div class="ava-user">
              <i class="fa-solid fa-circle-user"></i>
            </div>
            <div class="comment-user">
              <div class="name-wrap">
                <a href="">Phan Ngọc Đăng Huy</a>
              </div>
              <div class="comment-detail">
                <p>
                  Comment này hay quá, tuỵt vời quá, 10đ.
                </p>
              </div>
            </div>
          </div>
          <div class="comment-wrap">
            <div class="ava-user">
              <i class="fa-solid fa-circle-user"></i>
            </div>
            <div class="comment-user">
              <div class="name-wrap">
                <a href="">Phan Ngọc Đăng Huy</a>
              </div>
              <div class="comment-detail">
                <p>
                  Comment này hay quá, tuỵt vời quá, 10đ.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- comment-box -->
      <div class="comment-footer-box">
        <div class="comment-footer-wrap">
          <div class="ava-user ava-user-comment-footer">
            <i class="fa-solid fa-circle-user"></i>
          </div>

          <div class="comment-user-footer">
            <input type="text" placeholder="Viết đánh giá ...">
            <div class="line-right"></div>
            <div class="icon-send">
              <i class="fa-regular fa-paper-plane"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>




  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="../js/home.js"></script>
  <script src="../js/profile.js"></script>
</body>

</html>