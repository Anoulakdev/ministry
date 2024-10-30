<?php
session_start();
ob_start();
include '../config.php';
include '../style/sweetalert.php';
include 'status.php';


$update = false;
$nsc_id = "";
$m_id = "";
$nc_id = "";
$nsc_result = "";



if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$m_id = $_POST['m_id'];
	$barcode = $_POST['barcode'];

	if (strlen($barcode) == 4) {
		$s_no = substr($barcode, 0, 3);
		$nc_id = substr($barcode, -1);

		$result = $conn->query("SELECT * FROM nscore WHERE s_no = '$s_no' AND nc_id = '$nc_id'");
		$row_cnt = $result->num_rows;

		if ($row_cnt > 0) {

			echo "<script>
					$(document).ready(function() {
					Swal.fire({
					position: 'center',
					icon: 'info',
					title: 'barcode ນີ້​ມີ​ຢູ່​ໃນ​ລະ​ບົບ​ແລ້ວ',
					showConfirmButton: false,
					timer: 1000
				  });
				});
					</script>";

			header("refresh:1; url=addscore");
		} else {

			$query = "INSERT INTO nscore (m_id, s_no, nc_id, nsc_result) VALUES (?, ?, ?, 1)";
			$stmt = $conn->prepare($query);
			$stmt->bind_param("ssi", $m_id, $s_no, $nc_id);
			$stmt->execute();

			if ($stmt) {
				$_SESSION['message'] = "ເພີ່ມ​ barcode ​ເຂົ້າ​ລະ​ບົບ​ສຳ​ເລັດ";
				$_SESSION['message_type'] = "success"; // To track message type
			} else {
				$_SESSION['message'] = "ເພີ່ມ​ barcode ​ເຂົ້າ​ລະ​ບົບບໍ່​ສຳ​ເລັດ";
				$_SESSION['message_type'] = "error"; // To track message type
			}
			header("Location: addscore");
			exit();
		}
	} else if (strlen($barcode) == 5) {
		$s_no = substr($barcode, 0, 3);
		$nc_id = substr($barcode, -2);

		$result = $conn->query("SELECT * FROM nscore WHERE s_no = '$s_no' AND nc_id = '$nc_id'");
		$row_cnt = $result->num_rows;

		if ($row_cnt > 0) {

			echo "<script>
					$(document).ready(function() {
					Swal.fire({
					position: 'center',
					icon: 'info',
					title: 'barcode ນີ້​ມີ​ຢູ່​ໃນ​ລະ​ບົບ​ແລ້ວ',
					showConfirmButton: false,
					timer: 1000
				  });
				});
					</script>";

			header("refresh:1; url=addscore");
		} else {

			$query = "INSERT INTO nscore (m_id, s_no, nc_id, nsc_result) VALUES (?, ?, ?, 1)";
			$stmt = $conn->prepare($query);
			$stmt->bind_param("ssi", $m_id, $s_no, $nc_id);
			$stmt->execute();

			if ($stmt) {
				$_SESSION['message'] = "ເພີ່ມ​ barcode ​ເຂົ້າ​ລະ​ບົບ​ສຳ​ເລັດ";
				$_SESSION['message_type'] = "success"; // To track message type
			} else {
				$_SESSION['message'] = "ເພີ່ມ​ barcode ​ເຂົ້າ​ລະ​ບົບບໍ່​ສຳ​ເລັດ";
				$_SESSION['message_type'] = "error"; // To track message type
			}
			header("Location: addscore");
			exit();
		}
	} else {

		header("Location: addscore");
	}
}
ob_end_flush();
