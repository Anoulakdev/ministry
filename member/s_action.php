<?php
session_start();
ob_start();
include '../config.php';
include '../style/sweetalert.php';
include 'status.php';


$update = false;
$nsc_id = "";
$m_id = "";
$s_no = "";
$nc_id = "";
$nsc_result = "";



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$m_id = $_POST['m_id'];
	$s_no = $_POST['s_no'];
	$nc_ids = $_POST['nc_id'];

	// ตรวจสอบว่า nc_id มีค่าเป็น array และมีข้อมูลอย่างน้อย 3 รายการ
	if (count($nc_ids) == 3) {
		if ($nc_ids[0] == '' || $nc_ids[1] == '' || $nc_ids[2] == '') {
			echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'ຂໍ້​ມູນ​ຜູ້​ສະ​ໝັກ​ບໍ່​ຄົບ​',
                        showConfirmButton: false,
                        timer: 2000
                    });
                });
            </script>";
			header("refresh:2; url=addscore");
			exit; // หยุดการทำงานเพิ่มเติม
		}

		// ตรวจสอบว่าค่า nc_id[0] และ nc_id[1] ซ้ำกันหรือไม่
		if ($nc_ids[0] == $nc_ids[1] || $nc_ids[0] == $nc_ids[2] || $nc_ids[1] == $nc_ids[2]) {
			echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'ຂໍ້​ມູນ​ຜູ້​ສະ​ໝັກ​ຊ້ຳ​ກັນ',
                        showConfirmButton: false,
                        timer: 2000
                    });
                });
            </script>";
			header("refresh:2; url=addscore");
			exit; // หยุดการทำงานเพิ่มเติม
		}

		// ตรวจสอบว่า nc_id[2] มีค่ามากกว่า 28 หรือไม่
		if ($nc_ids[0] > 20 || $nc_ids[1] > 20 || $nc_ids[2] > 20) {
			echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'ບໍ່​ມີ​ຂໍ້​ມູນ​ຜູ້​ສະ​ໝັກ​',
                        showConfirmButton: false,
                        timer: 2000
                    });
                });
            </script>";
			header("refresh:2; url=addscore");
			exit; // หยุดการทำงานเพิ่มเติม
		}
	}

	$checksno = $conn->query("SELECT * FROM sheet WHERE s_no LIKE '$s_no'");
	$row_check = $checksno->num_rows;

	if ($row_check > 0) {

		$result = $conn->query("SELECT * FROM nscore WHERE s_no = $s_no");
		$row_cnt = $result->num_rows;

		if ($row_cnt > 0) {

			echo "<script>
		$(document).ready(function() {
			Swal.fire({
				position: 'center',
				icon: 'info',
				title: 'ໃບ​ບິນ​ນີ້​ໄດ້​ລົງ​ຄະ​ແນນແລ້ວ',
				showConfirmButton: false,
				timer: 2000
			  });
		});
		</script>";

			header("refresh:2; url=addscore");
		} else {


			foreach ($nc_ids as $nc_id) {
				// Insert into nscore with nsc_result = 0 (checkbox selected)
				$insert_query = "INSERT INTO nscore (m_id, s_no, nc_id, nsc_result) VALUES (?, ?, ?, 0)";
				$stmt = $conn->prepare($insert_query);
				$stmt->bind_param("ssi", $m_id, $s_no, $nc_id);
				$stmt->execute();
			}

			// Insert for unselected candidates with nsc_result = 1
			$unselected_query = "SELECT nc_id FROM newcandidate WHERE nc_id NOT IN (" . implode(',', $nc_ids) . ")";
			$unselected_result = $conn->query($unselected_query);

			while ($unselected_row = $unselected_result->fetch_assoc()) {
				$unselected_nc_id = $unselected_row['nc_id'];
				$insert_unselected = "INSERT INTO nscore (m_id, s_no, nc_id, nsc_result) VALUES (?, ?, ?, 1)";
				$stmt = $conn->prepare($insert_unselected);
				$stmt->bind_param("ssi", $m_id, $s_no, $unselected_nc_id);
				$stmt->execute();
			}


			echo "<script>
				$(document).ready(function() {
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'ທ່ານ​ໄດ້​ລົງ​ຄະ​ແນນສຳເລັດແລ້ວ',
						showConfirmButton: false,
						timer: 2000
					  });
				});
				</script>";

			header("refresh:2; url=addscore");
		}
	} else {
		echo "<script>
				$(document).ready(function() {
					Swal.fire({
						position: 'center',
						icon: 'error',
						title: 'ໃບ​ລົງ​ຄະ​ແນນ​ ບໍ່​ມີ​ໃນ​ລະ​ບົບ​',
						showConfirmButton: false,
						timer: 2000
					  });
				});
				</script>";

		header("refresh:2; url=addscore");
	}
}

ob_end_flush();
