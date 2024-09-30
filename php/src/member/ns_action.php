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



if (isset($_POST['add'])) {
	$m_id = $_POST['m_id'];
	// $nc_id = $_POST['nc_id'];
	// $nsc_result = 1;
	// $sc_res = 0;

	// $sql = "SELECT nc_id FROM newcandidate";
	// $result = $conn->query($sql);
	// $data = array();
	// if ($result->num_rows > 0) {
	// 	while ($row = $result->fetch_assoc()) {
	// 		$data[] = $row;
	// 	}
	// }


	// foreach ($data as $row) {
	// 	$data1 = $row['nc_id'];

	// 	$query = "INSERT INTO nscore(m_id,nc_id,nsc_result)VALUES(?,?,?)";
	// 	$stmt = $conn->prepare($query);
	// 	$stmt->bind_param("sss", $m_id, $data1, $nsc_result);
	// 	$stmt->execute();
	// }


	// foreach ($nc_id as $ncid) {
	// 	$stmt1 = $conn->prepare("UPDATE nscore SET nsc_result = $sc_res WHERE m_id = $m_id AND nc_id = ?");
	// 	$stmt1->bind_param("s", $ncid);
	// 	$stmt1->execute();
	// }

	if (isset($_POST['nc_id']) && count($_POST['nc_id']) == 4) {
		$nc_ids = $_POST['nc_id'];  // Array of selected candidate IDs
		foreach ($nc_ids as $nc_id) {
			// Insert into nscore with nsc_result = 0 (checkbox selected)
			$insert_query = "INSERT INTO nscore (m_id, nc_id, nsc_result) VALUES (?, ?, 0)";
			$stmt = $conn->prepare($insert_query);
			$stmt->bind_param("si", $m_id, $nc_id);
			$stmt->execute();
		}

		// Insert for unselected candidates with nsc_result = 1
		$unselected_query = "SELECT nc_id FROM newcandidate WHERE nc_id NOT IN (" . implode(',', $nc_ids) . ")";
		$unselected_result = $conn->query($unselected_query);

		while ($unselected_row = $unselected_result->fetch_assoc()) {
			$unselected_nc_id = $unselected_row['nc_id'];
			$insert_unselected = "INSERT INTO nscore (m_id, nc_id, nsc_result) VALUES (?, ?, 1)";
			$stmt = $conn->prepare($insert_unselected);
			$stmt->bind_param("si", $m_id, $unselected_nc_id);
			$stmt->execute();
		}


		echo "<script>
				$(document).ready(function() {
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'ທ່ານ​ໄດ້​ລົງ​ຄະ​ແນນສຳເລັດແລ້ວ',
						showConfirmButton: false,
						timer: 3000
					  });
				});
			</script>";

		header("refresh:3; url=naddscore");
	}
}
ob_end_flush();
