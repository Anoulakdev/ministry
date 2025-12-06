<?php
session_start();
ob_start();
include '../config.php';
include '../kill.php';
include '../candidatecounts.php';
include '../style/sweetalert.php';
include 'status.php';

$update = false;
$m_id = "";
$s_no = "";
$oc1_id = "";
$osc1_result = "";
$osc1_reason = "";
$nc1_id = "";
$nsc1_result = "";

if (isset($_POST['add'])) {
	// รับค่าและ sanitize เบื้องต้น
	$m_id = isset($_POST['m_id']) ? trim($_POST['m_id']) : '';
	$s_no = isset($_POST['s_no']) ? trim($_POST['s_no']) : '';
	$nc1_ids = isset($_POST['nc1_id']) && is_array($_POST['nc1_id']) ? $_POST['nc1_id'] : [];

	// ตรวจสอบ input พื้นฐาน
	if ($m_id === '' || $s_no === '') {
		echo "<script>
            $(document).ready(function() {
                Swal.fire({ position: 'center', icon: 'error', title: 'ຂໍ້​ມູນບໍ່ຄົບ', showConfirmButton: false, timer: 2000 });
            });
        </script>";
		header("refresh:2; url=praddscore");
		exit;
	}

	// ตรวจสอบว่ามีจำนวนตาม $kill1
	if (count($nc1_ids) != $kill1) {
		echo "<script>
            $(document).ready(function() {
                Swal.fire({ position: 'center', icon: 'error', title: 'ຈຳນວນຜູ້ສະຫາຍຕ້ອງເເທ້ຈິງ $kill1 ຄົນ', showConfirmButton: false, timer: 2000 });
            });
        </script>";
		header("refresh:2; url=praddscore");
		exit;
	}

	// ตรวจสอบค่าที่ว่าง และว่าทุกค่าเป็นตัวเลข
	foreach ($nc1_ids as $val) {
		$val = trim($val);
		if ($val === '' || !is_numeric($val)) {
			echo "<script>
                $(document).ready(function() {
                    Swal.fire({ position: 'center', icon: 'error', title: 'ຂໍ້​ມູນ​ຜູ້​ສະ​ໝັກ​ບໍ່​ຄົບ ຫຼື ບໍ່​ຖືກ​ຕ້ອງ', showConfirmButton: false, timer: 2000 });
                });
            </script>";
			header("refresh:2; url=praddscore");
			exit;
		}
		// แปลงเป็น int เพื่อความปลอดภัย
		$val = (int)$val;
		if ($val > $cnc1 || $val < 1) {
			echo "<script>
                $(document).ready(function() {
                    Swal.fire({ position: 'center', icon: 'error', title: 'ຂໍ້​ມູນ​ຜູ້​ສະ​ໝັກ​ບໍ່​ຖືກ​ຕ້ອງ', showConfirmButton: false, timer: 2000 });
                });
            </script>";
			header("refresh:2; url=praddscore");
			exit;
		}
	}

	// ตรวจสอบค่าซ้ำ
	if (count($nc1_ids) !== count(array_unique($nc1_ids))) {
		echo "<script>
            $(document).ready(function() {
                Swal.fire({ position: 'center', icon: 'error', title: 'ຂໍ້​ມູນ​ຜູ້​ສະ​ໝັກ​ຊ້ຳ​ກັນ', showConfirmButton: false, timer: 2000 });
            });
        </script>";
		header("refresh:2; url=praddscore");
		exit;
	}

	// ---------- ตรวจสอบว่า s_no มีอยู่ในตาราง sheet หรือไม่ (prepared) ----------
	$stmt_check_sheet = $conn->prepare("SELECT COUNT(*) AS cnt FROM sheet WHERE s_no = ?");
	$stmt_check_sheet->bind_param("s", $s_no);
	$stmt_check_sheet->execute();
	$res_check = $stmt_check_sheet->get_result();
	$row_check = $res_check->fetch_assoc();
	$stmt_check_sheet->close();

	if ($row_check['cnt'] > 0) {
		// ตรวจสอบว่ามีการลงคะแนนก่อนแล้วหรือไม่ (ใช้ prepared)
		$stmt_check_oscore = $conn->prepare("SELECT COUNT(*) AS cnt FROM oscore1 WHERE s_no = ?");
		$stmt_check_oscore->bind_param("s", $s_no);
		$stmt_check_oscore->execute();
		$res_oscore = $stmt_check_oscore->get_result();
		$row_oscore = $res_oscore->fetch_assoc();
		$stmt_check_oscore->close();

		if ($row_oscore['cnt'] > 0) {
			echo "<script>
                $(document).ready(function() {
                    Swal.fire({ position: 'center', icon: 'info', title: 'ໃບ​ບິນ​ນີ້​ໄດ້​ລົງ​ຄະ​ແນນແລ້ວ', showConfirmButton: false, timer: 2000 });
                });
            </script>";
			header("refresh:2; url=praddscore");
			exit;
		} else {
			// เริ่ม transaction (optional แต่ช่วยความถูกต้อง)
			$conn->begin_transaction();
			$error = false;

			// INSERT oscore1 จาก radio inputs: ค้นหา key ที่ขึ้นต้นด้วย osc1_result_
			foreach ($_POST as $key => $value) {
				if (strpos($key, 'osc1_result_') === 0) {
					$oc1_id = str_replace('osc1_result_', '', $key);
					$oc1_id = (int)$oc1_id;
					$osc1_result = trim($value);

					$osc1_reason_key = 'osc1_reason_' . $oc1_id;
					$osc1_reason = isset($_POST[$osc1_reason_key]) ? trim($_POST[$osc1_reason_key]) : '';

					$insert_oscore = $conn->prepare("INSERT INTO oscore1 (m_id, s_no, oc1_id, osc1_result, osc1_reason) VALUES (?, ?, ?, ?, ?)");
					if (!$insert_oscore) {
						$error = true;
						break;
					}
					$insert_oscore->bind_param("isiis", $m_id, $s_no, $oc1_id, $osc1_result, $osc1_reason);
					if (!$insert_oscore->execute()) {
						$error = true;
					}
					$insert_oscore->close();

					if ($error) break;
				}
			}

			// INSERT nscore1 สำหรับ nc1_ids
			if (!$error) {
				$insert_nscore = $conn->prepare("INSERT INTO nscore1 (m_id, s_no, nc1_id, nsc1_result) VALUES (?, ?, ?, 1)");
				if (!$insert_nscore) $error = true;
				else {
					foreach ($nc1_ids as $nc1_raw) {
						$nc1_id = (int)trim($nc1_raw);
						$insert_nscore->bind_param("ssi", $m_id, $s_no, $nc1_id);
						if (!$insert_nscore->execute()) {
							$error = true;
							break;
						}
					}
					$insert_nscore->close();
				}
			}

			if ($error) {
				$conn->rollback();
				echo "<script>
        		$(document).ready(function() {
            	Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'ການເພີ່ມຂໍ້ມູນລົ້ມເຫຼວ',
                showConfirmButton: false,
                timer: 2000
						});
					});
				</script>";
				header("refresh:2; url=praddscore");
				exit;
			} else {
				$conn->commit();
				echo "<script>
			$(document).ready(function() {
				Swal.fire({
					position: 'center',
					icon: 'success',
					title: 'ລົງຄະແນນສຳເລັດ!',
					showConfirmButton: false,
					timer: 2000
				});
			});
    		</script>";
				header("refresh:2; url=dpaddscore");
				exit;
			}
		}
	} else {
		// s_no ไม่มีในตาราง sheet
		echo "<script>
            $(document).ready(function() {
                Swal.fire({ position: 'center', icon: 'error', title: 'ເລກທີ່​ໃບ​ລົງ​ຄະ​ແນນບໍ່ຖືກຕ້ອງ', showConfirmButton: false, timer: 2000 });
            });
        </script>";
		header("refresh:2; url=praddscore");
		exit;
	}
} // end if isset add

// ถ้ารันมาถึงนี่ ให้ปิด output buffer
ob_end_flush();
