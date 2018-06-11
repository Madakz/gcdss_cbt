<?php
  include "class_lib/functions.php";
?>

 <?php
          if(isset($_POST['sub']))    //checks if the submit button has been click
          {
            $student_id = $_POST['student_id'];   //initialize the student_id with student_id collected from the form input
            $password =$_POST['password'];    //initialize the password with password collected from the form input
            $login = new Bajoga;    //creating an object of the class
?>
          <!-- use the object to call the Login function with arguments as student_id and password -->
          
          <p style="color:red; text-align: center; font-size: 20px;"><?php echo $login->login($student_id, $password);  }?></p>
          <h2>Login</h2> 
              <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST"  id="main-contact-form" >
                <div class="form-group">
                  <label>Student Id:</label>
                  <input type="text" name="student_id" class="form-control" placeholder="Student Id" required="required">
                </div>
                <div class="form-group">
                  <label>Password:</label>
                  <input type="password" name="password" class="form-control" placeholder="Password" required="required">
                </div>                        
                <div class="form-group">
                  <input type="submit" name="sub" value="Login" class="form-control btn-submit" />
                  <!-- <button type="submit" class="btn-submit">Send Now</button> -->
                </div>
              </form> 
               