<?php
session_start();
ob_start();
include '../config.php';
include '../style/sweetalert.php';
include 'status.php';


$update = false;
$osc_id = "";
$m_id = "";
$oc_id = "";
$osc_result = "";
$osc_reason = "";


if (isset($_POST['add'])) {
	$m_id = $_POST['m_id'];


	foreach ($_POST as $key => $value) {
		if (strpos($key, 'osc_result_') !== false) {
			$oc_id = str_replace('osc_result_', '', $key); // Extract the candidate ID
			$osc_result = $value; // Get the selected score (1 or 2)

			$osc_reason_key = 'osc_reason_' . $oc_id;
			$osc_reason = isset($_POST[$osc_reason_key]) ? $_POST[$osc_reason_key] : '';

			// Insert or update the score in the database
			$query = "INSERT INTO oscore (m_id, oc_id, osc_result, osc_reason) VALUES (?, ?, ?, ?)";
			$stmt = $conn->prepare($query);
			$stmt->bind_param("iiis", $m_id, $oc_id, $osc_result, $osc_reason);
			$stmt->execute();
			$stmt->close();
		}
	}


	echo "<script>
				$(document).ready(function() {
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: '​ລົງ​ຄະ​ແນນສຳເລັດແລ້ວ',
						showConfirmButton: false,
						timer: 3000
					  });
				});
			</script>";

	header("refresh:3; url=naddscore");

	$conn->close();
}

ob_end_flush();
