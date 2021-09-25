<?php session_start();
    require "db.php";
    require_once "header.php";

    if($result[0]['manager'] == 1)
    {
        echo "you can not autohorized";
        exit;
    }
    $emp_no = $_SESSION['UserData']['emp_no'];
    $logins = $db->prepare("SELECT salary FROM employees INNER JOIN salaries ON employees.emp_no = salaries.emp_no WHERE employees.emp_no = '$emp_no' ");
    $logins->execute();
    $result = $logins->fetchAll(PDO::FETCH_ASSOC);  
?>
    <div class="container">
      <h1>Salary Information</h1>
      <ul class="list-group">
    <?php foreach ($result as $key=>$salary){
        $total += $salary['salary']; 
        echo '<li class="list-group-item">'.($key+1).'. salary = '.$salary['salary'].'</li>';
    }
    ?>
    <li class="list-group-item active" aria-current="true"><?php echo "Total Salary: ".$total ?></li>
</ul>
    </div>
</body>
</html>

