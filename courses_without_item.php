<?php
session_name('MoodleSession');
session_save_path('/home/nls/moodledata/sessions');
session_start();
if ($_SESSION['USER']->username != 'nls') {
  return header('location: http://www.nikparvar.ir/nls/');
}
?>

<!DOCTYPE html>
<html class="no-js" lang="en" dir="rtl">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nikparvar High School</title>
  <link rel="stylesheet" href="css/foundation.min.css">
  <link rel="stylesheet" href="css/app.css">
</head>

<body>
  <div class="grid-container">
    <div class="grid-x grid-padding-x">
      <div class="large-12 cell">
        <h1>دبیرستان نیک پرور</h1>
      </div>
    </div>

    <div class="grid-x grid-padding-x">
      <div class="large-12 cell">
        <div class="callout">
          <h3>لیست دروسی که موارد نمره دهی خود را تعیین نکرده‌اند.</h3>
    <?php

    // Create connection
    $conn = new mysqli('localhost','nls' ,'Di$c0ver','nls');
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $conn->set_charset("utf8");
    $sql = "SELECT" .
        "`nls`.`mdl_course`.`id` AS `courseid`," .
        "`nls`.`mdl_course`.`fullname` AS `fullname`" .
    "FROM" .
        "`nls`.`mdl_course`" .
    "WHERE" .
        "(NOT (`nls`.`mdl_course`.`id` IN (SELECT" .
                "`nls`.`mdl_grade_items`.`courseid`" .
            "FROM" .
                "`nls`.`mdl_grade_items`" .
            "WHERE" .
                "(`nls`.`mdl_grade_items`.`itemname` IS NOT NULL))))";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
?>
         <table class="hover">
            <thead>
              <tr>
                <th>کد درس</th>
                <th>نام درس</th>
              </tr>
            </thead>
            <tbody>
<?php
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>'.$row["courseid"].'</td>';
            echo '<td>'.$row["fullname"].'</td>';
            echo '</tr>';
        }

            echo '</tbody>';
          echo '</table>';

    } else {
        echo "0 results";
    }

    $conn->close();

?>
        </div>
      </div>
    </div>

</body>

</html>
