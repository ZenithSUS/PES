<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Generation</title>

    <link rel="icon" type="image/x-icon" href="../../src/assets/img/apalit.ico"/>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <!-- JSZip for Excel Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <!-- pdfmake for PDF Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.5/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.5/vfs_fonts.js"></script>
    <!-- Buttons HTML5 Export -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <!-- Buttons Print -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    
    <?php include('../../api/database.php'); ?>
    <h2>Generate Report</h2>
    <table id="testTable" class="display nowrap" style="width:100%">
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Employee</th>
                <th>Date</th>
                <th>Time</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
        <?php
                    
            $sql = "SELECT attendances.*, CONCAT(accounts.first_name, ' ', accounts.middle_name ,' ', accounts.last_name) AS full_name
            FROM attendances 
            JOIN accounts ON attendances.userid = accounts.employee_id";

            $result = $con->query(query: $sql);
            $html = '';

            if ($result && $result->num_rows > 0) {
                while ($users = $result->fetch_assoc()) {
                    $html .= '<tr>';
                    $html .= '<td >' . htmlspecialchars($users['userid']) . '</td>';
                    $html .= '<td >' . htmlspecialchars($users['full_name']) . '</td>';
                    $html .= '<td >' . htmlspecialchars($users['attn_date']) . '</td>';
                    $html .= '<td >' . htmlspecialchars($users['attn_time']) . '</td>';
                    $html .= '<td >' . htmlspecialchars($users['attn_timestamp']) . '</td>';
                    $html .= '</tr>';
                }
                echo $html;
            } else {
            }

            ?>
        </tbody>
    </table>

    <script>
        $(document).ready(function () {
            $('#testTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 
                    'csv',
                    'excel',
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        customize: function (doc) {
                            doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        }
                    },
                    'print'
                ],
                responsive: true
            });
        });
        
    </script>
</body>
</html>