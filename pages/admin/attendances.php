<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>PES | Attendances</title>
    <link rel="icon" type="image/x-icon" href="../../src/assets/img/favicon.ico"/>
    <link href="../../layouts/modern-light-menu/css/light/loader.css" rel="stylesheet" type="text/css" />
    <link href="../../layouts/modern-light-menu/css/dark/loader.css" rel="stylesheet" type="text/css" />
    <script src="../../layouts/modern-light-menu/loader.js"></script>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="../../src/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../../layouts/modern-light-menu/css/light/plugins.css" rel="stylesheet" type="text/css" />
    <link href="../../layouts/modern-light-menu/css/dark/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="../../src/plugins/src/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="../../src/assets/css/light/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    <link href="../../src/assets/css/dark/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

    <!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="../../src/plugins/src/table/datatable/datatables.css">

    <link rel="stylesheet" type="text/css" href="../../src/plugins/css/light/table/datatable/dt-global_style.css">
    <link rel="stylesheet" type="text/css" href="../../src/plugins/css/light/table/datatable/custom_dt_custom.css">

    <link rel="stylesheet" type="text/css" href="../../src/plugins/css/dark/table/datatable/dt-global_style.css">
    <link rel="stylesheet" type="text/css" href="../../src/plugins/css/dark/table/datatable/custom_dt_custom.css">
    <link href="../../src/assets/css/light/elements/tooltip.css" rel="stylesheet" type="text/css" />
    <link href="../../src/assets/css/dark/elements/tooltip.css" rel="stylesheet" type="text/css" />
    
    <link href="../../src/assets/css/dark/components/modal.css" rel="stylesheet" type="text/css" />
    <link href="../../src/assets/css/light/components/modal.css" rel="stylesheet" type="text/css" />
    
    <link href="../../src/plugins/css/light/filepond/custom-filepond.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../../src/plugins/src/filepond/filepond.min.css">
    <link rel="stylesheet" href="../../src/plugins/src/filepond/FilePondPluginImagePreview.min.css">
    <!-- <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet"> -->
    <!-- <script defer src="https://unpkg.com/filepond/dist/filepond.min.js"></script> -->

    <!-- END PAGE LEVEL CUSTOM STYLES -->
     
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        .employee-row {
            font-weight: bold;
            background-color: #f2f2f2;
        }
        .attendance-row td {
            padding-left: 40px; /* Indent attendance records */
        }
    </style>

</head>
<body class="layout-boxed">
    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->
    <div class="header-container container-xxl">
        <header class="header navbar navbar-expand-sm expand-header">

            <ul class="navbar-item flex-row ms-lg-auto ms-0">

                <?php include('../../components/nav-dropdown.php'); ?>
                
            </ul>
        </header>
    </div>
    <!--  END NAVBAR  -->
    <?php
// Include database connection

    if (isset($_POST['export_excel'])) {
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=attendance_report.xls");

        echo "Employee ID\tEmployee\tDate\tTime\tTimestamp\n";

        $sql = "SELECT attendances.*, 
                    CONCAT(accounts.first_name, ' ', accounts.middle_name, ' ', accounts.last_name) AS full_name 
                FROM attendances 
                JOIN accounts ON attendances.userid = accounts.employee_id 
                ORDER BY attendances.userid, attendances.attn_date ASC";

        if (isset($_POST['from_date']) && isset($_POST['to_date']) && !empty($_POST['from_date']) && !empty($_POST['to_date'])) {
            $from = $_POST['from_date'];
            $to = $_POST['to_date'];
            $sql = "SELECT attendances.*, 
                        CONCAT(accounts.first_name, ' ', accounts.middle_name, ' ', accounts.last_name) AS full_name 
                    FROM attendances 
                    JOIN accounts ON attendances.userid = accounts.employee_id 
                    WHERE attn_date BETWEEN '$from' AND '$to'
                    ORDER BY attendances.userid, attendances.attn_date ASC";
        }

        $result = $con->query($sql);

        while ($row = $result->fetch_assoc()) {
            echo $row['userid'] . "\t" . $row['full_name'] . "\t" . $row['attn_date'] . "\t" . $row['attn_time'] . "\t" . $row['attn_timestamp'] . "\n";
        }
        exit;
    }
?>
    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <?php include('../../components/side-navigation.php'); ?>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="middle-content container-xxl p-0">

                    <div class=" layout-top-spacing">
                        <nav class="breadcrumb-style-five  mb-3" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Management</li>
                                <li class="breadcrumb-item"><a href="attendances.php">DTR</a></li>
                            </ol>
                        </nav>
                    </div>

                    <div class="container">
                        <form method="POST">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label>From Date:</label>
                                    <input type="date" id="from_date" name="from_date" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label>To Date:</label>
                                    <input type="date" id="to_date" name="to_date" class="form-control">
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <div class="col-md-12 mb-5">
                        <label>&nbsp;</label>
                        <button name="filter" class="btn btn-primary btn-block" onclick="fetchAttendance()">Filter</button>
                        <label>&nbsp;</label>
                        <button type="button" id="hideDailyTime" class="btn btn-danger btn-block" disabled>Hide Daily Time</button>
                        <label>&nbsp;</label>
                        <button type="button" id="exportExcel" class="btn btn-success btn-block">Export to Excel</button>
                    </div>

                    <div class="row layout-spacing">
                        <div class="col-lg-12">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-content widget-content-area p-4">
                                    <table id="attendanceTable">
                                        <thead>
                                            <tr>
                                                <th>RFID</th>
                                                <th id="employeeData">Employee</th>
                                                <th class="dailyData">Date</th>
                                                <th class="dailyData">Time IN</th>
                                                <th class="dailyData">Time OUT</th>
                                                <th>Work Hours</th>
                                                <th>Late (mins)</th>
                                                <th>Overtime</th>
                                                <th class="dailyData">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody id="attendanceBody">
                                            <tr><td colspan='9'>No attendance records found</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!--  BEGIN FOOTER  -->
            <!-- <div class="footer-wrapper">
                <div class="footer-section f-section-1">
                    <p class="">Copyright © <span class="dynamic-year">2022</span> <a target="_blank" href="https://designreset.com/cork-admin/">DesignReset</a>, All rights reserved.</p>
                </div>
                <div class="footer-section f-section-2">
                    <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></p>
                </div>
            </div> -->
            <!--  END FOOTER  -->
        </div>
        <!--  END CONTENT AREA  -->

    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="../../src/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../../src/plugins/src/mousetrap/mousetrap.min.js"></script>
    <script src="../../src/plugins/src/waves/waves.min.js"></script>
    <script src="../../src/plugins/src/global/vendors.min.js"></script>
    <script src="../../src/plugins/src/highlight/highlight.pack.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="../../src/plugins/src/table/datatable/datatables.js"></script>
    <script src="../../src/assets/js/custom.js"></script>

    
    <!-- <script src="../../src/plugins/src/filepond/filepond.min.js"></script>
    <script src="../../src/plugins/src/filepond/FilePondPluginFileValidateType.min.js"></script>
    <script src="../../src/plugins/src/filepond/FilePondPluginImageExifOrientation.min.js"></script>
    <script src="../../src/plugins/src/filepond/FilePondPluginImagePreview.min.js"></script>
    <script src="../../src/plugins/src/filepond/FilePondPluginImageCrop.min.js"></script>
    <script src="../../src/plugins/src/filepond/FilePondPluginImageResize.min.js"></script>
    <script src="../../src/plugins/src/filepond/FilePondPluginImageTransform.min.js"></script>
    <script src="../../src/plugins/src/filepond/filepondPluginFileValidateSize.min.js"></script> -->
    

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>

        function fetchAttendance() {
            let fromDate = document.getElementById("from_date").value;
            let toDate = document.getElementById("to_date").value;

            fromDate = formatDate(fromDate);
            toDate = formatDate(toDate);

            console.log("From: " + fromDate);
            console.log("To: " + toDate);
            

            fetch("../../api/fetch_attendance.php?from=" + fromDate + "&to=" + toDate )
            .then(response => response.json())
            .then(data => {
                console.log(data)
                let tbody = document.getElementById("attendanceBody");
                tbody.innerHTML = "";

                if (data.length > 0) {
                    let previousUserId = null;
                    console.log(data)
                    data.forEach((row, index) => {
                        if (previousUserId !== row.userid) {
                            let empRow = document.createElement("tr");
                            empRow.classList.add("employee-row");
                            empRow.innerHTML = `<td>${row.userid}</td><td colspan='9'>${row.full_name}</td>`;
                            tbody.appendChild(empRow);
                            previousUserId = row.userid;
                        }

                        let attnRow = document.createElement("tr");
                        attnRow.classList.add("attendance-row");
                        attnRow.innerHTML = `<td></td><td></td><td>${row.attn_date} (${row.day_of_week})</td>
                                             <td>${row.check_in_time}</td>
                                             <td>${row.check_out_time || 'N/A'}</td> <!-- Handle missing out times -->
                                             <td>${row.work_hours}</td>
                                             <td>${row.late}</td>
                                             <td>${row.overtime}</td>
                                             <td>${row.remark}</td>`;
                        tbody.appendChild(attnRow);

                        const isLastRecordUser = index === data.length - 1 || (index < data.length - 1 && data[index + 1].userid !== row.userid); 
                        if(isLastRecordUser) {
                            let attnTotalData = document.createElement("tr");
                            attnTotalData.classList.add("total-row");
                            attnTotalData.style.fontWeight = "bold";
                            attnTotalData.innerHTML = `<td colspan='5'>Total</td>
                                                    <td style="text-align: center;">${row.total_work_hours}</td>
                                                    <td style="text-align: center;">${row.total_late_minutes}</td>
                                                    <td style="text-align: center;">${row.total_overtime}</td>
                                                    <td class="dailyData"></td>`;
                            tbody.appendChild(attnTotalData);
                        }
                        const dailyTime = document.getElementById("hideDailyTime");
                        dailyTime.textContent = "Hide Daily Time";
                        dailyTime.classList.remove("btn-primary");
                        dailyTime.classList.add("btn-danger");
                        dailyTime.disabled = false;
                        document.querySelector("#employeeData").colSpan = 0;
                        document.querySelectorAll(".dailyData").forEach(row => {
                            row.style.display = "";
                        })
                    });
                } else {
                    tbody.innerHTML = "<tr><td colspan='8'>No attendance records found</td></tr>";
                }
            })
            .catch(error => console.error("Error fetching data:", error));
        }

        document.getElementById("hideDailyTime").addEventListener("click", () => {
        const dailyDataRow = document.querySelectorAll(".dailyData");
        const employeeDataRow = document.querySelector("#employeeData");
        const attendanceRows = document.querySelectorAll(".attendance-row");
        const button = document.getElementById("hideDailyTime");
    
        attendanceRows.forEach(row => {
            row.style.display = row.style.display === "none" ? "" : "none";
        });

        dailyDataRow.forEach(row => {
            row.style.display = row.style.display === "none" ? "" : "none";
        })
    
        // Update button text
        button.textContent = button.textContent.includes("Hide") ? "Show Daily Time" : "Hide Daily Time";
        employeeDataRow.colSpan = button.textContent.includes("Hide") ? 0 : 4;
        // Update button class color
        button.classList.toggle("btn-primary");
        button.classList.toggle("btn-danger");
        });

         document.getElementById("exportExcel").addEventListener("click", function() {
            let table = document.getElementById("attendanceTable");
            let clonedTable = table.cloneNode(true);
            
            // Check if daily time data is hidden
            let dailyDataElements = document.querySelectorAll(".dailyData");
            let isDailyTimeHidden = dailyDataElements[0] && dailyDataElements[0].style.display === "none";
            
            if (isDailyTimeHidden) {
                // Remove daily time columns from header
                let headerRow = clonedTable.querySelector("thead tr");
                let dailyTimeHeaders = headerRow.querySelectorAll(".dailyData");
                dailyTimeHeaders.forEach(header => header.remove());
                
                // Adjust employee column span
                let employeeHeader = headerRow.querySelector("#employeeData");
                if (employeeHeader) {
                    employeeHeader.colSpan = 4;
                }
                
                // Remove daily time rows (attendance-row) from body
                let attendanceRows = clonedTable.querySelectorAll(".attendance-row");
                attendanceRows.forEach(row => row.remove());
                
                // Remove empty cells from employee rows and total rows
                let bodyRows = clonedTable.querySelectorAll("tbody tr");
                bodyRows.forEach(row => {
                    if (row.classList.contains("employee-row")) {
                        // Keep first cell (RFID) and second cell (Employee name with colspan)
                        let cells = row.querySelectorAll("td");
                        for (let i = cells.length - 1; i >= 2; i--) {
                            if (i > 1) cells[i].remove();
                        }
                    } else if (row.classList.contains("total-row")) {
                        // Adjust total row structure
                        let cells = row.querySelectorAll("td");
                        if (cells.length > 0) {
                            cells[0].textContent = "Total";
                            cells[0].colSpan = 5; // Span across RFID and Employee columns
                            // Remove the extra cells that were originally for daily data
                            for (let i = cells.length - 1; i >= 1; i--) {
                                if (i < 6) break; // Keep work hours, late, overtime, remarks
                                cells[i].remove();
                            }
                        }
                    }
                });
            }
            
                // Create worksheet from the modified table
                let ws = XLSX.utils.table_to_sheet(clonedTable);
                let wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "Attendance Report");
                
                // Generate filename with current date
                let currentDate = new Date().toISOString().split('T')[0];
                let filename = `Attendance_Report_${currentDate}.xlsx`;
                
                XLSX.writeFile(wb, filename);
            });

        function formatDate(dateString) {
            if (!dateString) return "";
            let parts = dateString.split("-");
            return `${parts[1]}/${parts[2]}/${parts[0]}`;
        }

    </script>

</body>
</html>