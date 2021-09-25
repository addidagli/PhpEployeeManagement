<?php session_start();
require 'db.php';
require_once "header.php";
$dept_no = $_SESSION['UserData']['dept_no'];

if(isset($_POST['Submit']))
{
  $first_name = strip_tags($_POST['first_name']);
  $last_name = strip_tags($_POST['last_name']);
  $hire_date = $_POST['hire_date'];
  $gender = $_POST['gender'];
  $birth_date = $_POST['birth_date'];

  $emp_no=mt_rand(1000000, 9999999);
  $to_date = new Datetime('9999-01-01');
  $to_date = $to_date->format('Y-m-d');

  if(!empty($first_name) && !empty($last_name) && !empty($gender) && !empty($hire_date) && !empty($birth_date)){
        $query = $db->prepare("INSERT INTO employees (emp_no,birth_date,first_name, last_name, gender,hire_date) VALUES (?,?,?,?,?,?)");
        $result = $query->execute(array($emp_no,$birth_date,$first_name,$last_name,$gender,$hire_date));
        if($result){
          $add = $db->prepare("INSERT INTO dept_emp (emp_no, dept_no, from_date, to_date) VALUES (?,?,?,?) ");
          $res_dep = $add->execute(array($emp_no,$dept_no,$hire_date,$to_date));
          if($res_dep)
          {
            $msg = "<span style='color:green'>Employee added</span>";
          }
          else{
            $msg = "<span style='color:red'>Fail</span>";
          }
        }
        else 
        {
          $msg = "<span style='color:red'>something went wrong</span>";
        }

    } else {
      $msg = "<span style='color:red'>please fill up all of inputs</span>";
    }

}
?>
<div class="container">
<div class="col-12">
<?php echo $msg;?>
</div>
<form class="row g-3" method="post">
  <div class="col-6">
    <label for="inputFirstName" class="form-label">First Name</label>
    <input type="text" class="form-control" id="inputFirstName" placeholder="first name" name="first_name">
  </div>
  <div class="col-6">
    <label for="inputLastName" class="form-label">Last Name</label>
    <input type="text" class="form-control" id="inputAddress2" placeholder="last name" name="last_name">
  </div>
  <div class="col-md-4">
    <label for="inputHireDate" class="form-label">Hire Date</label>
    <input type="date" class="form-control" id="inputHireDate" name="hire_date">
  </div>
  <div class="col-md-4">
    <label for="inputState" class="form-label">Gender</label>
    <select id="inputState" class="form-select" name="gender">
      <option selected>Choose...</option>
      <option value="M">M</option>
      <option value="F">F</option>
    </select>
  </div>
  <div class="col-md-4">
    <label for="inputBirthDate" class="form-label">Birth Date</label>
    <input type="date" class="form-control" id="inputBirthDate" name="birth_date">
  </div>
  <div class="col-md-4">
    <label for="inputState" class="form-label">Department</label>
    <select id="inputState" class="form-select" name="department">
      <option selected><?php  echo $dept_no; ?></option>
    </select>
  </div>
  <div class="col-12">
    <input name="Submit" type="submit" value="Add Employee" class="btn btn-primary">
    <a href="manager.php"><input value="Back" class="btn btn-outline-warning me-2"></a>
  </div>
</div>
</form>
</body>
</html>