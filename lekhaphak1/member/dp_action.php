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
$oc2_id = "";
$osc2_result = "";
$osc2_reason = "";
$nc2_id = "";
$nsc2_result = "";

if (isset($_POST['add'])) {
	// รับค่าและ sanitize เบื้องต้น
	$m_id = isset($_POST['m_id']) ? trim($_POST['m_id']) : '';
	$s_no = isset($_POST['s_no']) ? trim($_POST['s_no']) : '';
	$nc2_ids = isset($_POST['nc2_id']) && is_array($_POST['nc2_id']) ? $_POST['nc2_id'] : [];

	// ตรวจสอบ input พื้นฐาน
	if ($m_id === '' || $s_no === '') {
		echo "<script>
            $(document).ready(function() {
                Swal.fire({ position: 'center', icon: 'error', title: 'ຂໍ້​ມູນບໍ່ຄົບ', showConfirmButton: false, timer: 2000 });
            });
        </script>";
		header("refresh:2; url=dpaddscore");
		exit;
	}

	// ตรวจสอบว่ามีจำนวนตาม $kill2
	if (count($nc2_ids) != $kill2) {
		echo "<script>
            $(document).ready(function() {
                Swal.fire({ position: 'center', icon: 'error', title: 'ຈຳນວນຜູ້ສະຫາຍຕ້ອງເເທ້ຈິງ $kill2 ຄົນ', showConfirmButton: false, timer: 2000 });
            });
        </script>";
		header("refresh:2; url=dpaddscore");
		exit;
	}

	// ตรวจสอบค่าที่ว่าง และว่าทุกค่าเป็นตัวเลข
	foreach ($nc2_ids as $val) {
		$val = trim($val);
		if ($val === '' || !is_numeric($val)) {
			echo "<script>
                $(document).ready(function() {
                    Swal.fire({ position: 'center', icon: 'error', title: 'ຂໍ້​ມູນ​ຜູ້​ສະ​ໝັກ​ບໍ່​ຄົບ ຫຼື ບໍ່​ຖືກ​ຕ້ອງ', showConfirmButton: false, timer: 2000 });
                });
            </script>";
			header("refresh:2; url=dpaddscore");
			exit;
		}
		// แปลงเป็น int เพื่อความปลอดภัย
		$val = (int)$val;
		if ($val > $cnc2 || $val < 1) {
			echo "<script>
                $(document).ready(function() {
                    Swal.fire({ position: 'center', icon: 'error', title: 'ຂໍ້​ມູນ​ຜູ້​ສະ​ໝັກ​ບໍ່​ຖືກ​ຕ້ອງ', showConfirmButton: false, timer: 2000 });
                });
            </script>";
			header("refresh:2; url=dpaddscore");
			exit;
		}
	}

	// ตรวจสอบค่าซ้ำ
	if (count($nc2_ids) !== count(array_unique($nc2_ids))) {
		echo "<script>
            $(document).ready(function() {
                Swal.fire({ position: 'center', icon: 'error', title: 'ຂໍ້​ມູນ​ຜູ້​ສະ​ໝັກ​ຊ້ຳ​ກັນ', showConfirmButton: false, timer: 2000 });
            });
        </script>";
		header("refresh:2; url=dpaddscore");
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
		$stmt_check_nscore = $conn->prepare("SELECT COUNT(*) AS cnt FROM nscore2 WHERE s_no = ?");
		$stmt_check_nscore->bind_param("s", $s_no);
		$stmt_check_nscore->execute();
		$res_nscore = $stmt_check_nscore->get_result();
		$row_nscore = $res_nscore->fetch_assoc();
		$stmt_check_nscore->close();

		if ($row_nscore['cnt'] > 0) {
			echo "<script>
                $(document).ready(function() {
                    Swal.fire({ position: 'center', icon: 'info', title: 'ໃບ​ບິນ​ນີ້​ໄດ້​ລົງ​ຄະ​ແນນແລ້ວ', showConfirmButton: false, timer: 2000 });
                });
            </script>";
			header("refresh:2; url=dpaddscore");
			exit;
		} else {
			// เริ่ม transaction (optional แต่ช่วยความถูกต้อง)
			$conn->begin_transaction();
			$error = false;

			// INSERT oscore2 จาก radio inputs: ค้นหา key ที่ขึ้นต้นด้วย osc2_result_
			foreach ($_POST as $key => $value) {
				if (strpos($key, 'osc2_result_') === 0) {
					$oc2_id = str_replace('osc2_result_', '', $key);
					$oc2_id = (int)$oc2_id;
					$osc2_result = trim($value);

					$osc2_reason_key = 'osc2_reason_' . $oc2_id;
					$osc2_reason = isset($_POST[$osc2_reason_key]) ? trim($_POST[$osc2_reason_key]) : '';

					$insert_oscore = $conn->prepare("INSERT INTO oscore2 (m_id, s_no, oc2_id, osc2_result, osc2_reason) VALUES (?, ?, ?, ?, ?)");
					if (!$insert_oscore) {
						$error = true;
						break;
					}
					$insert_oscore->bind_param("isiis", $m_id, $s_no, $oc2_id, $osc2_result, $osc2_reason);
					if (!$insert_oscore->execute()) {
						$error = true;
					}
					$insert_oscore->close();

					if ($error) break;
				}
			}

			// INSERT nscore2 สำหรับ nc2_ids
			if (!$error) {
				$insert_nscore = $conn->prepare("INSERT INTO nscore2 (m_id, s_no, nc2_id, nsc2_result) VALUES (?, ?, ?, 1)");
				if (!$insert_nscore) $error = true;
				else {
					foreach ($nc2_ids as $nc2_raw) {
						$nc2_id = (int)trim($nc2_raw);
						$insert_nscore->bind_param("ssi", $m_id, $s_no, $nc2_id);
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
				header("refresh:2; url=dpaddscore");
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
				header("refresh:2; url=praddscore");
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
		header("refresh:2; url=dpaddscore");
		exit;
	}
} // end if isset add

// ถ้ารันมาถึงนี่ ให้ปิด output buffer
ob_end_flush();
