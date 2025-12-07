<?php
include 'dp_action.php';
include '../kill.php';

// ---------------------------------------------
// GET LAST SHEET NUMBER
// ---------------------------------------------
$sql12 = "SELECT s_no FROM sheet ORDER BY s_id DESC LIMIT 1";
$result12 = $conn->query($sql12);
$row12 = $result12->fetch_assoc();
$length = isset($row12['s_no']) ? strlen($row12['s_no']) : 0;

// ---------------------------------------------
// GET NEW CANDIDATE
// ---------------------------------------------
$query = "SELECT * FROM newcandidate2";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
$result->free();
$stmt->close();

// ---------------------------------------------
// GET OLD CANDIDATE
// ---------------------------------------------
$query1 = "SELECT * FROM oldcandidate2";
$stmt1 = $conn->prepare($query1);
$stmt1->execute();
$result1 = $stmt1->get_result();
$data1 = [];

while ($row1 = $result1->fetch_assoc()) {
    $data1[] = $row1;
}
$result1->free();
$stmt1->close();

// IMPORTANT: อย่าเพิ่ง $conn->close(); ถ้าจะใช้ต่อ
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>ລົງ​ຄະ​ແນນສະ​ໝັກ​ຮອງເລ​ຂາ</title>

    <?php include '../style/stylesheet.php'; ?>
</head>

<body class="toggle-sidebar">

    <?php include '../navbar/navbar_m.php'; ?>
    <?php include '../sidebar/sidebar_m.php'; ?>

    <main id="main" class="main">

        <div class="pagetitle py-2">
            <h1>II. ຮອງເລ​ຂາ​ບໍ​ລິ​ຫານ​ງານ​ພັກ</h1>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-md-8">

                    <div class="card">
                        <div class="card-body">

                            <h4 class="my-3"><i class="bi bi-asterisk"></i> ​ພີມເລກ​ທີ່​ໃບ​ລົງ​ຄະ​ແນນ</h4>

                            <form class="row g-3" action="dp_action" method="post" onsubmit="return handleSubmit()">
                                <input type="hidden" name="m_id" value="<?= $_SESSION['m_id']; ?>">

                                <div class="col-12">

                                    <!-- sheet number -->
                                    <input type="text" name="s_no" id="s_no" class="form-control"
                                        maxlength="<?= $length ?>"
                                        placeholder="ເລກ​ທີ່​ໃບ​ລົງ​ຄະ​ແນນ"
                                        required>

                                    <br>

                                    <!-- OLD CANDIDATE -->
                                    <h4><i class="bi bi-asterisk"></i> ຄະນະບໍລິຫານງານຊຸດເກົ່າ</h4>

                                    <div class="scrollable-table">
                                        <table class="table">
                                            <thead class="table-light text-center align-middle">
                                                <tr>
                                                    <th>ເລືອກ</th>
                                                    <th>​ເຫດຜົນ</th>
                                                    <th>ຊື່</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center align-middle">
                                                <?php foreach ($data1 as $row1): ?>
                                                    <tr>
                                                        <td>
                                                            <input type="radio"
                                                                name="osc2_result_<?= $row1['oc2_id']; ?>"
                                                                value="1" checked
                                                                onclick="toggleTextarea(<?= $row1['oc2_id']; ?>, true)">
                                                            ເຫັນ​ດີ

                                                            <input type="radio"
                                                                name="osc2_result_<?= $row1['oc2_id']; ?>"
                                                                value="0"
                                                                onclick="toggleTextarea(<?= $row1['oc2_id']; ?>, false)">
                                                            ບໍ່ເຫັນ​ດີ
                                                        </td>

                                                        <td>
                                                            <textarea
                                                                name="osc2_reason_<?= $row1['oc2_id']; ?>"
                                                                id="osc2_reason_<?= $row1['oc2_id']; ?>"
                                                                rows="2" class="form-control"
                                                                disabled></textarea>
                                                        </td>

                                                        <td class="text-center"><?= $row1['oc2_name']; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <br>

                                    <!-- NEW CANDIDATE SELECT -->
                                    <h4><i class="bi bi-asterisk"></i> <?= $kill2 ?> ​ສະ​ຫາຍເປົ້າ​ໝາຍ​ໃໝ່</h4>

                                    <?php for ($i = 1; $i <= $kill2; $i++): ?>
                                        <input type="number"
                                            name="nc2_id[]"
                                            id="nc2_id_<?= $i; ?>"
                                            class="form-control mb-3"
                                            placeholder="ຜູ້ທີ່ <?= $i; ?>"
                                            required>
                                    <?php endfor; ?>

                                </div>

                                <div class="col-md-10">
                                    <button type="submit" id="add" name="add" class="btn btn-primary">ລົງ​ຄະ​ແນນ</button>

                                    <button class="btn btn-primary" type="button" disabled id="load">
                                        <span class="spinner-border spinner-border-sm"></span>
                                        ກຳ​ລັງ​ລົງ​ຄະ​ແນນ...
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>

                <!-- RIGHT SIDE: NEW CANDIDATE LIST -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="my-4"><i class="bi bi-person"></i> ຂໍ້​ມູນ​ເປົ້າ​ໝາຍ​ໃໝ່</h4>

                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>ລ/ດ</th>
                                        <th>ຊື່</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data as $row): ?>
                                        <tr>
                                            <td class="text-center"><?= $row['nc2_id']; ?></td>
                                            <td><?= $row['nc2_name']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main>

    <?php include '../style/script.php'; ?>

    <script>
        window.onload = () => {
            document.getElementById("s_no").focus();
        };

        function toggleTextarea(id, isContinue) {
            const txt = document.getElementById("osc2_reason_" + id);
            if (isContinue) {
                txt.disabled = true;
                txt.value = "";
                txt.removeAttribute("required");
            } else {
                txt.disabled = false;
                txt.setAttribute("required", "required");
            }
        }

        document.getElementById("load").style.display = "none";

        function handleSubmit() {
            document.getElementById("add").style.display = "none";
            document.getElementById("load").style.display = "inline-block";
            return true;
        }
    </script>

</body>

</html>