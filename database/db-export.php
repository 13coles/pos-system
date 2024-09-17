<?php
  $database = 'inventory_db';
  $conn = mysqli_connect('localhost', 'root', 'root', $database);
  
  $tables = array();
  $sql = "SHOW TABLES";
  $result = mysqli_query($conn, $sql);

  while($row = mysqli_fetch_row($result)) {
    $tables[] = $row[0];
  }

  $sql_script = '';
  foreach($tables as $table) {
    $query = "SELECT * FROM $table";
    $result = mysqli_query($conn, $query);
    $col = mysqli_num_fields($result);
   
    $row2 = mysqli_fetch_row(mysqli_query($conn, 'SHOW CREATE TABLE '.$table));
    $sql_script .= "\n\n".$row2[1].";\n\n";

    for($i = 0; $i < $col; $i++) {
      while($row = mysqli_fetch_row($result)) {
        $sql_script .= "INSERT INTO $table VALUES (";
        for($j = 0; $j < $col; $j++) {
          $row[$j] = addslashes($row[$j]);

          if(isset($row[$j])) {
            $sql_script .= '"'.$row[$j].'"';
          } else {
            $sql_script .= '""';
          }
          if($j < ($col - 1)) {
            $sql_script .= ',';
          }
        }
        $sql_script .= ");\n";
      }
    }
    $sql_script .= "\n\n\n";
  }

  if(!empty($sql_script)) {
    $backup_file_name = $database.'_backup.sql';
    $fileHandler = fopen($backup_file_name, 'w+');
    $num_of_lines = fwrite($fileHandler, $sql_script);
    fclose($fileHandler);
    
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($backup_file_name));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length:'. filesize($backup_file_name));
    ob_clean();
    flush();
    readfile($backup_file_name);
    exec('re'.$backup_file_name);
    
    echo 'Downloaded Successfully!';
  } else {
    echo 'Download Unsuccessful!';
  }
?>