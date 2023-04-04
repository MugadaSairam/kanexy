<?php 
 session_start();
include("includes/header.php");
 ?>
<main id="main">
        <section class="login">
            <div class="container">
                <div class="row">
                   <div class="col-md-12">
                        <h1>Login Here</h1>
                        
                            <?php
                                if(isset($_COOKIE['success']))
                                {
                                    echo "<P class='alert alert-success>".$_COOKIE['success']."<P>";
                                } 
                                function filterData($data)
                                {
                                    return addslashes(strip_tags(trim($data)));
                                }
                            
                                if(isset($_POST['submit']))
                                {
                                    
                                    $mail = isset($_POST['email']) ? filterData($_POST['email']) : '';
                                    $pass = isset($_POST['pwd']) ? filterData($_POST['pwd']) : '';
                                
                                    // vaidations
                                    $errors = [];
                                    
                                    
                                    // email validation
                                    if($mail === "")
                                    {
                                        $errors['email'] = "Email is Required";
                                    }
                                    else
                                    {
                                        if(!filter_var($mail, FILTER_VALIDATE_EMAIL))
                                        {
                                            $errors['email'] = "Valid email id is Required";
                                        }
                                    }
                                    
                                    //password validation
                                    if($pass === "")
                                    {
                                        $errors["pass"] = "Password is Required";
                                    }
                                    
                                    if(count($errors) === 0)
                                    {
                                        include("includes/connect.php");
                                        
                                        $result = mysqli_query($con, "select * from registerdata where email='$mail'");
                                        if(mysqli_num_rows($result)===1)
                                        {
                                            $row = mysqli_fetch_assoc($result);
                                            if(password_verify($pass, $row['password']))
                                            {
                                                if($row['status'] === "active")
                                                {
                                                    $_SESSION['login_true'] = $row['token'];
                                                    $_SESSION['username'] = $row['username'];
                                                    header("Location:home.php");
                                                }
                                                else
                                                {
                                                    echo "<p class='alert alert-warning'>Please activate your account</p>";
                                                }
                                            }
                                            else
                                            {
                                                echo "<p class='alert alert-danger'>Password does not matched.</p>";
                                            }
                                        }
                                        else
                                        {
                                            echo "<p class='alert alert-danger' >Sorry! Unable to find your email account</p>";
                                        }
                                        
                                    }
                                }
                            ?>
                
                            <form method="POST" action="">
                                
                                <div class="form-group mt-5">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" />
                                    <small class="text-danger"><?php if(isset($errors['email'])) echo $errors['email']; ?></small>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Password</label>
                                    <input type="password" name="pwd" class="form-control" value="<?php if(isset($_POST['pwd'])) echo $_POST['pwd']; ?>" />
                                    <small class="text-danger"><?php if(isset($errors['pass'])) echo $errors['pass']; ?></small>
                                </div>
                                
                                
                                <div class="form-group mb-3">
                                    <input  type="submit" class="btn btn-success" value="Login" name="submit" />
                                    <p class="py-3"><a href='register.php'>Create Account</a> | <a href='forgot.php'>Forgot Password</a></p>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </section>
    </main>    














<?php include("includes/footer.php"); ?>