<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php echo $this->session->flashdata('message'); ?>
    <h3>Register</h3>
    <form action="/users/register" method="post">
      Name: <input type="text" name="name" value=""><br>
      Alias: <input type="text" name="alias" value=""><br>
      Email: <input type="text" name="email" value=""><br>
      Password: <input type="password" name="password" value=""><br>
      Confirm Password: <input type="password" name="conf_pass" value=""><br>
      Date of birth: <input type="date" name="dob" value=""><br>
      <input type="submit" value="Submit "><br>
    </form><br>
    <h3>Login</h3>
    <form class="" action="/users/login" method="post">
      Email: <input type="text" name="email" value=""><br>
      Password: <input type="password" name="password" value=""><br>
      <input type="submit" value="submit">
    </form>
  </body>
</html>
