<?php  
    session_start();
    require "db.php";
    require_once "header.php";
    $dept_no = $_SESSION['UserData']['dept_no'];
    $logins = $db->prepare("SELECT employees.* from employees INNER JOIN dept_emp ON dept_emp.emp_no = employees.emp_no WHERE dept_emp.dept_no = '$dept_no' ORDER BY emp_no  DESC limit 30");
    $logins->execute();
    $result = $logins->fetchAll(PDO::FETCH_ASSOC);  
?>
<div class="container">
<table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <?php
                 foreach ($result as $emp)
                 {
                     foreach($emp as $key=>$emp2)
                     {
                        echo '<th>'.$key.'</th>';
                     }
                    break;
                }  
                ?>
            </tr>
        </thead>
        <tbody>
                <?php foreach ($result as $emp)
                {
                    echo '<tr>';
                    foreach($emp as $key=>$emp2)
                     {
                        echo '<th>'.$emp2.'</th>';
                     }
                     echo '</tr>';
                }
                ?>
        </tbody>
        <tfoot>
            <tr>
                <?php 
                  foreach ($result as $emp)
                  {
                      foreach($emp as $key=>$emp2)
                      {
                         echo '<th>'.$key.'</th>';
                      }
                     break;
                 }
                ?>
            </tr>
        </tfoot>
    </table>
    <a href="addEmployee.php"><button type="button" class="btn btn-outline-primary me-2">Add Employee</button></a>
</div>
</body>
<script>
    $(document).ready(function() {
    $('#example').DataTable();
} );
</script>
</html>