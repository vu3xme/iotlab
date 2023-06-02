<?php
//load databse configuration file
include_once 'dbConfig.php';

//custom function filter excel data
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
}

// Excel file name for download 
$fileName = "DO_export_data-" . date('Ymd') . ".xlsx"; 
 

// Excel file name for download 
$fileName = "members-data_" . date('Y-m-d') . ".xls"; 
 
// Column names 
$fields = array('ID', 'sensor', 'location', 'value1', 'value2', 'value3', 'CREATED'); 
 
// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 
 
// Fetch records from database 
$query = $db->query("SELECT * FROM SensorData ORDER BY id ASC"); 
if($query->num_rows > 0){ 
    // Output each row of the data 
    while($row = $query->fetch_assoc()){ 
        
        $lineData = array($row['id'], $row['sensor'], $row['location'], $row['value1'], $row['value2'], $row['value3'], $row['reading_time']); 
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    } 
}else{ 
    $excelData .= 'No records found...'. "\n"; 
} 
 
// Headers for download 
header("Content-Type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=\"$fileName\""); 
 
// Render excel data 
echo $excelData; 
 
exit;
?>