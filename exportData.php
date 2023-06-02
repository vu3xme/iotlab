<?php 
 
// Load the database configuration file 
include_once 'esp-database.php'; 
include_once 'dbConfig.php'; 
// Fetch records from database 
$query = $db->query("SELECT * FROM SensorData ORDER BY id ASC"); 
 
if($query->num_rows > 0){ 
    $delimiter = ","; 
    $filename = "SensorData-data_" . date('Y-m-d') . ".csv"; 
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 
     
    // Set column headers 
    $fields = array('ID', 'location', 'VALUE1 DO ', 'VALUE2 Do (sat)', 'value3','CREATED DATE'); 
    fputcsv($f, $fields, $delimiter); 
     
    // Output each row of the data, format line as csv and write to file pointer 
    while($row = $query->fetch_assoc()){  
        $lineData = array($row['id'], $row['sensor'], $row['location'], $row['value1'], $row['value2'], $row['value3'], $row['reading_time']); 
        fputcsv($f, $lineData, $delimiter); 
    } 
     
    // Move back to beginning of file 
    fseek($f, 0); 
     
    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
     
    //output all remaining data on a file pointer 
    fpassthru($f); 
} 
exit; 
 
?>