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
	$nc_id = $_POST['nc_id'];
	$nsc_result = 1;
	$sc_res = 0;

	$sql = "SELECT nc_id FROM newcandidate";
	$result = $conn->query($sql);
	$data = array();
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
	}


	foreach ($data as $row) {
		$data1 = $row['nc_id'];

		$query = "INSERT INTO nscore(m_id,nc_id,nsc_result)VALUES(?,?,?)";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("sss", $m_id, $data1, $nsc_result);
		$stmt->execute();
	}


	foreach ($nc_id as $ncid) {
		$stmt1 = $conn->prepare("UPDATE nscore SET nsc_result = $sc_res WHERE m_id = $m_id AND nc_id = ?");
		$stmt1->bind_param("s", $ncid);
		$stmt1->execute();
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
ob_end_flush();
