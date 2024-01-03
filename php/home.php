<?php
include 'connPDO.php';
session_start();
//Tìm kiếm
if (isset($_GET['search'])) {
  $search = $_GET['search'];
  $sql = "SELECT * FROM posts INNER JOIN typeof ON posts.typeOfid = typeof.id
  INNER JOIN users ON posts.userId = users.id
  WHERE title = '$search'";
  $stmt = $conn->query($sql);
  $rs = $stmt->fetchAll();
  if ($stmt->rowCount() > 0) {
    $searchResult = $rs;
  }
  if ($stmt->rowCount() == 0 && $_GET['search'] != "") {
    $searchResult = "None";
   }
   ;
}

#Tìm kiếm lọc
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitFilter'])) {


    $fCity = ($_POST['filterCity'] == "Tỉnh/Thành phố") ? '' : ''.$_POST['filterCity'].'';
    $fType = ($_POST['filterType'] == "Loại hình") ? '' : ''.$_POST['filterType'].'';
    $fPrice = ($_POST['filterPrice'] == "Giá") ? '' : ''.$_POST['filterPrice'].'';
    $fTime = ($_POST['filterTime'] == "Thời gian") ? '' : ''.$_POST['filterTime'].'';
    if(!empty($fCity) && !empty($fType) && !empty($fPrice) && !empty($fTime)){
        $sql_filter = "SELECT * FROM posts INNER JOIN typeof ON posts.typeOfid = typeof.id
                                    INNER JOIN users ON posts.userId = users.id
                                    INNER JOIN price ON posts.priceId = price.id
                                    INNER JOIN times ON posts.timesId = times.id
                WHERE cityId = '$fCity' AND typeOfId = '$fType' AND priceId = '$fPrice' AND timesId = '$fTime'";
  }

    if(!empty($fCity) && empty($fType) && empty($fPrice) && empty($fTime)){
        $sql_filter = "SELECT * FROM posts INNER JOIN typeof ON posts.typeOfId = typeof.id
                                    INNER JOIN users ON posts.userId = users.id
    WHERE cityId = $fCity";
  }

    if(empty($fCity) && !empty($fType) && empty($fPrice) && empty($fTime)){
        $sql_filter = "SELECT * FROM posts INNER JOIN typeof ON posts.typeOfid = typeof.id
                                    INNER JOIN users ON posts.userId = users.id
    WHERE typeOfId = $fType";
    }
    if(empty($fCity) && empty($fType) && !empty($fPrice) && empty($fTime)){
      if ($fPrice == "asc"){
        $sql_filter = "SELECT * FROM posts INNER JOIN price ON posts.priceId = price.id
                                           INNER JOIN users ON posts.userId = users.id
                ORDER BY price2 ASC";
      }
      if ($fPrice == "desc"){
        $sql_filter = "SELECT * FROM posts INNER JOIN price ON posts.priceId = price.id
                                           INNER JOIN users ON posts.userId = users.id
                                                               ORDER BY price.price2 DESC";
      }
    

    }
    if(empty($fCity) && empty($fType) && empty($fPrice) && !empty($fTime)){
        if ($fPrice == "asc"){
          $sql_filter = "SELECT * FROM posts INNER JOIN price ON posts.priceId = price.id
                                             INNER JOIN users ON posts.userId = users.id
                  ORDER BY price2 ASC";
        }
        if ($fPrice == "desc"){
          $sql_filter = "SELECT * FROM posts INNER JOIN price ON posts.priceId = price.id
                                             INNER JOIN users ON posts.userId = users.id
                                                                 ORDER BY price.price2 DESC";
        }
      
  
      }

    $stmt = $conn->query($sql_filter);
    $rs = $stmt->fetchAll();
     if ($stmt->rowCount() >0){
        $filterResult = $rs;
     };
}

//Lọc loại hình dịch vụ
$sql_type = "SELECT * FROM typeof";
$stmt_type = $conn->query($sql_type);
$typeof = $stmt_type->fetchAll();
//Lọc khu vực
$sql_city = "SELECT * FROM city";
$stmt_city = $conn->query($sql_city);
$cities = $stmt_city->fetchAll();
//Tất cả bài viết
$sql_posts = "SELECT * FROM posts INNER JOIN typeof ON posts.typeOfid = typeof.id
                                  INNER JOIN users ON posts.userId = users.id ORDER BY posts.id DESC";
$stmt_posts = $conn->query($sql_posts);
$posts = $stmt_posts->fetchAll();

//Tạo bài
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitCreate'])) {
  $img = $_FILES['image']['name'];
  $img_tmp = $_FILES['image']['tmp_name'];
  //-------------------------------------------------------------------------
  $title = $_POST['title'];
  $desc = $_POST['description'];
  $address = $_POST['address'];
  //-------------------------------------------------------------------------
  $type = $_POST['type'];
  $checkType = "SELECT * FROM typeof WHERE typeOf = '" . $type . "'";
  $stmt_checkType = $conn->query($checkType);
  $typeId = $stmt_checkType->fetch(PDO::FETCH_ASSOC);
  //-------------------------------------------------------------------------
  $city = $_POST['city'];
  $checkCity = "SELECT * FROM city WHERE city = '$city'";
  $stmt_checkCity = $conn->query($checkCity);
  $cityId = $stmt_checkCity->fetch(PDO::FETCH_ASSOC);
  //-------------------------------------------------------------------------
  $price1 = $_POST['price1'];
  $price2 = $_POST['price2'];
  $stmt_price = $conn->query("INSERT INTO price (price1, price2) VALUES ($price1, $price2)");
  $checkPrice = "SELECT * FROM price WHERE price1 = '$price1' AND price2 = '$price2'";
  $stmt_checkPrice = $conn->query($checkPrice);
  $priceId = $stmt_checkPrice->fetch(PDO::FETCH_ASSOC);
  //-------------------------------------------------------------------------
  $timeO = $_POST['timeOpen'];
  $timeC = $_POST['timeClose'];
  $stmt_time = $conn->query("INSERT INTO times (timeOpen, timeClose) VALUES ('$timeO', '$timeC')");
  $checkTime = "SELECT * FROM times WHERE timeOpen = '$timeO' AND timeClose = '$timeC'";
  $stmt_checkTime = $conn->query($checkTime);
  $timeId = $stmt_checkTime->fetch(PDO::FETCH_ASSOC);
  //-------------------------------------------------------------------------

  $currentDateTime = new DateTime();
  $datetime = $currentDateTime->format('Y-m-d H:i:s');

  $user_id = $_SESSION['user_id'];

  $sqlpost = "INSERT INTO posts (userId, title, description, address, cityId, typeOfId, priceId, timesId, image, createAt)
               VALUES (" . $user_id . ", '$title', '$desc', '$address'," . $cityId['id'] . "," . $typeId['id'] . ", " . $priceId['id'] . "," . $timeId['id'] . ", '$img', '$datetime')";
  if ($conn->query($sqlpost)) {
    echo '<script>alert("Tạo bài thành công");</script>';
  } else {
    // Hiển thị thông báo khi xảy ra lỗi
    echo '<script>alert("Lỗi khi tạo bài");</script>';
  }
  move_uploaded_file($img_tmp, '../assets/pic/' . $img);
  header('location: home.php');
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
  <link rel="stylesheet" href="../css/home.css" />
  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/all.css" />
</head>

<body>
    <!-- main content web -->
    <div class="main">
        <!-- header -->
        <header class="header">
            <!-- nav-left -->
            <div class="nav-left">
                <a href="index.php" class="logo-header">
                    <img src="../assets/Logo/logo.png" alt="" />
                </a>
                <nav class="nav-icon-left">
                    <a href="home.php">
                        <button>Trang chủ</button>
                    </a>
                    <button class="btnCreate">Tạo</button>
                </nav>
            </div>

      <!-- nav-middle -->
      <form action="#" method="get">
        <nav class="nav-search">
          <input type="text" name="search" placeholder="Tìm kiếm..." />

          <div class="icon-search">
            <i class="fa-regular fa-magnifying-glass"></i>
          </div>

          <span><input type="submit" name="submitSearch" value="Tìm kiếm"></span>
        </nav>
      </form>

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
                <span>
                  <?php
                  if (isset($_SESSION['user_id'])) {
                    $ten_nguoi_dung = $_SESSION['lName'] . " " . $_SESSION['fName'];
                    echo $ten_nguoi_dung;
                  } else {
                    echo "Chưa đăng nhập";
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

    <!-- slider -->
    <div class="slider">
      <div class="slider-img">
        <img src="../assets/pic/banner/travel.png" alt="" />
      </div>
    </div>

    <!-- cart-section -->
    <section class="cart-box">
      <form action="#" method="post">
        <div class="cart-wrap">


          <div class="cart-title">
            <h2>
              Trải nghiệm
              <br />
              <span>Du lịch Việt</span>
            </h2>
          </div>
          <div class="cart-list">
            <div class="select-list" data-cate="type">
              <select class="select-name" name="filterType">

                <option value="">Loại hình</option>
                <?php foreach ($typeof as $type) : ?>
                  <option value="<?php echo $type['id']; ?>"><?php echo $type['typeOf']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="select-list" data-cate="place">
              <select class="select-name" name="filterCity" id="">
                <option value="">Tỉnh/Thành phố</option>
                <?php foreach ($cities as $city) : ?>
                  <option value="<?php echo $city['id']; ?>"><?php echo $city['city']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="select-list" data-cate="time">
              <select class="select-name" name="filterTime" id="">
                <option value="">Thời gian</option>
                <option value="morning">Sáng</option>
                <option value="afternoon">Chiều</option>
                <option value="night">Tối</option>
              </select>
            </div>

                        <div class="select-list" data-cate="price">
                            <select class="select-name" name="filterPrice" id="">
                                <option value="">Giá</option>
                                <option value="asc">Tăng dần</option>
                                <option value="desc">Giảm dần</option>
                            </select>
                        </div>

          </div>
          <button type="submit" name="submitFilter" class="btn">Tìm</button>

        </div>
      </form>
    </section>

    <!-- display result -->
    <section class="result-box">
      <?php if (isset($searchResult) && $searchResult == "None") :
        echo "Không có bài viết";
      else :
        if (isset($searchResult) && ($searchResult != "")) {
          $allPosts = $searchResult;
        } else if (isset($filterResult) && ($filterResult != "")) {
          $allPosts = $filterResult;
        } else {
          $allPosts = $posts;
        } ?>

        <div class="wrap-result">
          <div class="wrapper-content">
            <?php foreach ($allPosts as $post) : ?>
              <div class="card-box">
                <div class="img-box">
                  <img src="../assets/pic/<?php echo $post['image'] ?>" alt="">
                </div>

                <div class="title-box">
                  <p><?php echo $post['title'] ?></p>
                  <div class="user-title-box">
                    <i class="fa-solid fa-circle-user"></i>
                    <span><?php echo $post['lastName'] . " " . $post['firstName'] ?></span>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

      <?php endif; ?>
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
                <div class="input-file" id="imageContainer">
                  <div class="drag-container" id="none-div">
                    <div class="drag-wrap">
                      <span><i class="fa-solid fa-arrow-up"></i></span>

                      <div class="text-upload-img">
                        <span>Chọn một tệp hoặc kéo và thả tệp ở đây</span>
                      </div>
                    </div>
                  </div>
                  <!-- upload-img  -->
                  <input name="inputImg" aria-label="Tải tập tin lên" type="file" id="imageInput" class="upload-file" accept="image/bmp,image/jpeg,image/png,image/tiff,image/webp,video/mp4,video/x-m4v,video/quicktime" multiple tabindex="0">
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
                        <option value="<?php echo $type['typeOf']; ?>">
                          <?php echo $type['typeOf']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="input-box">
                    <label for="city">Khu vực</label>
                    <select name="city" id="city">
                      <?php foreach ($cities as $city) : ?>
                        <option value="<?php echo $city['city']; ?>"><?php echo $city['city']; ?>
                        </option>
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
            <h5>Ruộng bậc thang 4K không thể tìm thấy một nơi nào khác đẹp hơn. Với chất lượng hình ảnh siêu
              cấp VIP và độ phân giải 4K, nó mang đến trải nghiệm tuyệt vời cho mắt người xem. Khung cảnh
              của ruộng bậc thang được tái hiện rõ nét và sống động, tạo nên một hình ảnh tuyệt đẹp và hấp
              dẫn không thể sánh bằng.</h5>
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
                  Comment này hay quá, tuỵt vời quá, 10đ.Comment này hay quá, tuỵt vời quá,
                  10đ.Comment này hay quá, tuỵt vời quá, 10đ.Comment này hay quá, tuỵt vời quá, 10đ.
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
                  Comment này hay quá, tuỵt vời quá, 10đ.Comment này hay quá, tuỵt vời quá,
                  10đ.Comment này hay quá, tuỵt vời quá, 10đ.Comment này hay quá, tuỵt vời quá, 10đ.
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>