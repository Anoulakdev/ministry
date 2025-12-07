<?php
session_start();
ob_start();
include '../config.php';
include '../style/sweetalert.php';
include 'status.php';


$update = false;
$s_id = "";
$s_no = "";
$s_barcode = "";



// if (isset($_POST['add'])) {
// 	$s_no = $_POST['s_no'];


// 	$result = $conn->query("SELECT * FROM sheet WHERE s_no = '$s_no'");
// 	$row_cnt = $result->num_rows;

// 	if ($row_cnt > 0) {

// 		echo "<script>
// 			$(document).ready(function() {
// 			Swal.fire({
// 			position: 'center',
// 			icon: 'info',
// 			title: 'ເລກ​ທີໃບ​ລົງ​ຄະ​ແນນມີ​ໃນ​ລະ​ບົບ​ແລ້ວ',
// 			showConfirmButton: false,
// 			timer: 3000
// 		  });
// 		});
// 			</script>";

// 		header("refresh:3; url=sheet");
// 	} else {

// 		$query = "INSERT INTO sheet(s_no)VALUES(?)";
// 		$stmt = $conn->prepare($query);
// 		$stmt->bind_param("s", $s_no);
// 		$stmt->execute();


// 		echo "<script>
// 		$(document).ready(function() {
// 		Swal.fire({
// 			position: 'center',
// 			icon: 'success',
// 			title: 'ເພີ່ມຂໍ້​ມູນເຂົ້າລະບົບສຳເລັດແລ້ວ',
// 			showConfirmButton: false,
// 			timer: 3000
// 		});
// 	});
// 	</script>";

// 		header("refresh:3; url=sheet");
// 	}
// }

if (isset($_POST['add'])) {
	$conn->query("TRUNCATE TABLE sheet");

	$start = $_POST['start'];
	$end   = $_POST['end'];

	$length = strlen((string)$end);

	// เตรียม statement
	$query = "INSERT INTO sheet(s_no) VALUES(?)";
	$stmt = $conn->prepare($query);

	for ($i = $start; $i <= $end; $i++) {
		$s_no = str_pad($i, $length, "0", STR_PAD_LEFT);

		$stmt->bind_param("s", $s_no);
		$stmt->execute();
	}

	$stmt->close();

	echo "<script>
        $(document).ready(function() {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'ເພີ່ມຂໍ້​ມູນເຂົ້າລະບົບສຳເລັດແລ້ວ',
                showConfirmButton: false,
                timer: 3000
            });
        });
    </script>";

	// redirect หลัง 3 วิ
	header("refresh:3; url=sheet");
}



// if (isset($_GET['delete'])) {
// 	$s_id = $_GET['delete'];


// 	$query = "DELETE FROM sheet WHERE s_id=?";
// 	$stmt = $conn->prepare($query);
// 	$stmt->bind_param("i", $s_id);
// 	$stmt->execute();

// 	if ($stmt) {

// 		header("refresh:1; url=sheet");
// 	}
// }

if (isset($_GET['deleteall'])) {
	$s_no = $_GET['deleteall'];


	$query = "DELETE FROM nscore WHERE s_no=?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("i", $s_no);
	$stmt->execute();

	if ($stmt) {

		header("refresh:1; url=deletesheet");
	}
}

// if (isset($_POST['update'])) {
// 	$s_id = $_POST['s_id'];
// 	$s_no = $_POST['s_no'];



// 	$query = "UPDATE sheet SET s_no=? WHERE s_id=?";
// 	$stmt = $conn->prepare($query);
// 	$stmt->bind_param("si", $s_no, $s_id);
// 	$stmt->execute();

// 	echo "<script>
// 				$(document).ready(function() {
// 					Swal.fire({
// 						position: 'center',
// 						icon: 'success',
// 						title: 'ອັບເດດຂໍ້ມູນສຳເລັດແລ້ວ',
// 						showConfirmButton: false,
// 						timer: 3000
// 					  });
// 				});
// 			</script>";

// 	header("refresh:3; url=sheet");
// }
ob_end_flush();
