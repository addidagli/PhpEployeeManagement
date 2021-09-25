<?php session_start(); /* Starts the session */
  require 'db.php';

	if(isset($_POST['Submit'])){

    $Username = isset($_POST['Username']) ? $_POST['Username'] : '';
		$Password = isset($_POST['Password']) ? $_POST['Password'] : '';

		if($Username == '' || $Password == '')
    {
      $msg="<span style='color:red'>Please fill up all inputs</span>";
    }
    else{
      $control = $db->prepare("SELECT * FROM employees where first_name = :first_name");
			$control->bindParam(":first_name",$Username, PDO::PARAM_STR);
			$control->execute();
			$sayi = $control->rowCount();
			if($sayi == 0)
      {
        $msg="<span style='color:red'>This employee is not exist</span>";
      }
      else{
        $logins = $db->prepare("SELECT dept_manager.dept_no,employees.first_name,employees.last_name,employees.emp_no,
        COUNT(dept_manager.dept_no)AS manager,COUNT(dept_emp.dept_no) AS employee FROM employees 
       LEFT JOIN dept_manager ON dept_manager.emp_no = employees.emp_no
       LEFT JOIN dept_emp ON dept_emp.emp_no = employees.emp_no
       WHERE employees.first_name = '$Username' AND employees.last_name = '$Password'");
       $logins->execute();
       $result = $logins->fetchAll();
       
   
       if(($result[0]['first_name'] == $Username) &&  ($result[0]['last_name'] == $Password)){
         $_SESSION['UserData']['Username']=$Username;
         $_SESSION['UserData']['Password']=$Password;
         $_SESSION['UserData']['emp_no']=$result[0]['emp_no'];
         $_SESSION['UserData']['dept_no']=$result[0]['dept_no'];
         $_SESSION['UserData']['manager']=$result[0]['manager'];

         
         if($result[0]['manager'] == 1){
           header("Location:manager.php");
           exit;
         }else{
           header("Location:employee.php");
           exit;
         }
         //var_dump($result[0]['first_name']);
       
       }else{
         $msg="<span style='color:red'>Username or Password is incorrect</span>";
       }
      }
    }
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Document</title>
<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
<link href="./css/style.css" rel="stylesheet">
</head>
<body>

  
<form action="" method="post" name="Login_Form">
  <table width="400" border="0" align="center" cellpadding="5" cellspacing="1" class="Table" style="	margin-top: 15%;">
    <?php if(isset($msg)){?>
    <tr>
      <td colspan="2" align="center" valign="top"><?php echo $msg;?></td>
    </tr>
    <?php } ?>
    <tr>
      <td colspan="2" align="left" valign="top"><h3>Login</h3></td>
    </tr>
    <tr>
      <td align="right" valign="top">Username</td>
      <td><input name="Username" type="text" class="form-control Input" placeholder="Username"></td>
    </tr>
    <tr>
      <td align="right">Password</td>
      <td><input name="Password" type="password" class="form-control Input"  placeholder="Password"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input name="Submit" type="submit" value="Login" class="btn btn-primary btn-sm"></td>
    </tr>
  </table>
</form>
</body>
</html>