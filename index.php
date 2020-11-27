<?php include("dbinfo.php"); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Quan Ly Hinh Anh</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="./css/styles.css">
</head>
<body>
	<h1>UNG DUNG QUAN LY CUA HANG</h1>
	<hr/>
	
	<?php
		$con = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);
		if (!$con) {
			die ("Can not connect to database!");
		}
		// mysqli_set_charset($con, "utf-8");

		$sql = "select * from loaihinh";
		$result = mysqli_query($con, $sql);
		$row = "";
		$html_left_area = "<ul>";
		#fetch data for left area
		while ($row = mysqli_fetch_assoc($result)) {
			$loaihinh = $row["loaiHinhAnh"];
			$html_left_area .= "<li class='left-area__item'><a href='index.php?control=$loaihinh'>$loaihinh</a><li/>";
		}
		$html_left_area .= "</ul>";
		
		$sql = "select tenHinh, url from dshinh";
		$result = mysqli_query($con, $sql);
		$row = "";
		$html_main_area = "";
		#fetch data for detail area
		while ($row = mysqli_fetch_assoc($result)) {
			$tenHinh = $row["tenHinh"];
			$url = $row["url"];
			$html_main_area .= "<div class='item'><img src='$url' alt='$tenHinh' class='detail-area__item'/><p>$tenHinh</p></div>";
		}
		$html_main_area .= "";

		$sql = "select tenHinh, url, soLanXem from dshinh order by soLanXem desc limit 3";
		$result = mysqli_query($con, $sql);
		$row = "";
		$html_bottom_area = "";
		#fetch data for bottom area
		while ($row = mysqli_fetch_assoc($result)) {
			$tenHinh = $row["tenHinh"];
			$url = $row["url"];
			$soLanXem = $row["soLanXem"];
			$html_bottom_area .= "<div class='item'><img src='$url' alt='$tenHinh' class='detail-area__item'/><p>$tenHinh, luot xem: $soLanXem</p></div>";
		}
		$html_bottom_area .= "";

		mysqli_close($con);


		$control = "";
		$data_session = "";

		if (isset($_GET["control"]) == true) {
			$control = $_GET["control"];

			$con = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);
			if (!$con) {
				die ("Can not connect to database!");
			}

			$sql = "select tenHinh, url from dshinh where maLoai in (select id from loaihinh where loaiHinhAnh = '$control')";
			$result = mysqli_query($con, $sql);
			$row = "";
			#fetch data for detail area
			while ($row = mysqli_fetch_assoc($result)) {
				$tenHinh = $row["tenHinh"];
				$url = $row["url"];
				$data_session .= "<div class='item'><img src='$url' alt='$tenHinh' class='detail-area__item'/><p>$tenHinh</p></div>";
			}
			$html_main_area = "";

			mysqli_close($con);
		}
	?>

	<div class="main-area">
		<dev class="left-area" style="border: 4px double black;">
			<?php echo $html_left_area; ?>
		</dev>

		<div class="right-area">
			<dev class="detail-area">
				<?php 
					echo $html_main_area;
					echo $data_session;
				?>
			</dev>

			<hr style="width: 100%;" />
			<dev class="bottom-area">
				<?php echo $html_bottom_area; ?>
			</dev>
		</div>
	</div>
</body>
</html>