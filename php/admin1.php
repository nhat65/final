<?php
$conn = new PDO("mysql:host=127.0.0.1;dbname=travelweb2", "root", "");

//Tìm kiếm
if (isset($_GET['search'])) {
	$search = $_GET['search'];
	print_r($search);
	$sql = "SELECT * FROM posts WHERE title = '" . $search . "'";
	$stmt = $conn->query($sql);
	$rs = $stmt->fetch(PDO::FETCH_ASSOC);
}

//Lọc loại hình dịch vụ
$sql_type = "SELECT typeOf FROM typeof";
$stmt_type = $conn->query($sql_type);
$typeof = $stmt_type->fetchAll();

//Lọc khu vực
$sql_city = "SELECT city FROM city";
$stmt_city = $conn->query($sql_city);
$cities = $stmt_city->fetchAll();

//Tất cả bài viết
$sql_posts = "SELECT * FROM posts INNER JOIN typeof ON posts.typeOfid = typeof.id INNER JOIN users ON posts.userId = users.id";
$stmt_posts = $conn->query($sql_posts);
$posts = $stmt_posts->fetchAll();

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
				<a href="" class="logo-header">
					<img src="../assets/Logo/logo.png" alt="" />
				</a>

				<nav class="nav-icon-left">
					<button>Trang chủ</button>
					<button class="btnCreate">Tạo</button>
				</nav>
			</div>

			<!-- nav-middle -->
			<form action="#" method="get">
				<nav class="nav-search">
					<input type="text" name="search" placeholder="Tìm kiếm..." />
				</nav>
				<span><input type="submit" value="Tìm kiếm"></span>

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
				<img src="../assets/pic/banner/travel.png" alt="" />
			</div>
		</div>

		<!-- cart-section -->
		<section class="cart-box">
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
						<div class="select-name">
							<span></span>
							<h3 data-holder="Loại hình">Loại hình</h3>
						</div>

						<div class="select-box">
							<form action="#" method="post">
								<ul id="typeList">
									<?php foreach ($typeof as $type) : ?>
										<li>
											<h3><?php echo $type['typeOf']; ?></h3>
										</li>
									<?php endforeach; ?>
								</ul>
							</form>
						</div>
					</div>

					<div class="select-list" data-cate="place">
						<div class="select-name">
							<span></span>
							<h3 data-holder="Địa điểm">Tỉnh/Thành phố</h3>
						</div>

						<div class="select-box">
							<ul>
								<?php foreach ($cities as $city) : ?>
									<li>
										<h3><?php echo $city['city']; ?></h3>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>

					<div class="select-list" data-cate="time">
						<div class="select-name">
							<span></span>
							<h3 data-holder="Thời gian">Thời gian</h3>
						</div>

						<div class="select-box"></div>
					</div>

					<div class="select-list" data-cate="price">
						<div class="select-name">
							<span></span>
							<h3 data-holder="Mức giá">Mức giá</h3>
						</div>

						<div class="select-box"></div>
					</div>
				</div>
			</div>
		</section>

		<!-- display result -->
		<section class="result-box">
			<div class="wrap-result">
				<?php foreach ($posts as $post) : ?>
					<div class="card-box">
						<div class="img-box">
							<img src="../assets/pic/<?php echo $post['image'] ?>" alt="">
						</div>

						<div class="title-box">
							<p><?php echo $post['title'] ?></p>
							<div class="user-title-box">
								<i class="fa-solid fa-circle-user"></i>
								<span><?php echo $post['lastName'] . $post['firstName'] ?></span>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
		</section>

		<!--  -->
	</div>

	<!-- modal display image -->
	<div class="modal-img">
		<div class="wrapper-img"></div>
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

				<div class="form-box">
					<div class="form-container">
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

								<input aria-label="Tải tập tin lên" type="file" id="upload-img" class="upload-file" accept="image/bmp,image/jpeg,image/png,image/tiff,image/webp,video/mp4,video/x-m4v,video/quicktime" multiple tabindex="0">

							</div>
						</div>

						<!--  -->
						<div class="form-details">
							<div class="details-container">
								<div class="input-box">
									<label for="addHeader">Tiêu đề</label>
									<input type="text" id="addHeader" placeholder="Thêm tiêu đề" required>
								</div>

								<div class="input-box">
									<label for="addDetail">Mô tả</label>
									<input type="text" id="addDetail" placeholder="Thêm mô tả chi tiết" required>
								</div>

								<div class="input-box">
									<label for="addType">Loại dịch vụ</label>
									<select name="" id="addType">
										<?php foreach ($typeof as $type) : ?>
											<option value=""><?php echo $type['typeOf']; ?></option>
										<?php endforeach; ?>
									</select>
								</div>

								<div class="input-box">
									<label for="addLocation">Khu vực</label>
									<select name="" id="addLocation">
										<option value="">choose</option>
									</select>
								</div>

								<div class="input-box">
									<label for="addAddress">Địa chỉ</label>
									<input type="text" id="addAddress" placeholder="Thêm địa chỉ" required>
								</div>

								<div class="input-box">
									<label for="addPrice">Mức giá</label>

									<div class="price-box">
										<span>Từ: </span>
										<input type="num" id="addPrice" required>
										<span class="dvt">(VNĐ)</span>
										<span>Đến: </span>
										<input type="num" id="addPrice">
										<span class="dvt">(VNĐ)</span>
									</div>
								</div>

								<div class="input-box">
									<label for="addTime">Thời gian hoạt động</label>

									<div class="time-box">
										<span>Từ: </span>
										<input type="time" id="addTime" required>
										<span>Đến: </span>
										<input type="time" id="addTime">
									</div>
								</div>

								<div class="submit-input">
									<button type="submit">Đăng</button>
								</div>
							</div>
						</div>
					</div>
				</div>


			</div>
		</div>
	</div>

	<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

	<script src="../js/home.js"></script>
</body>

</html>