<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- bootstrap -->
     <link rel="shortcut icon" href="/assets/favicon.ico">
    <link rel="stylesheet" href="css/main.css">
      <title>Midwife | Sign Up</title>
</head>
<body>
<div class="container">
 <form id="createAccount" action="" method="post">
            <h1 class="form__title">Create Account</h1>
            <div class="form__message form__message--error"></div>
            <div class="form__input-group">
                <input type="text" class="form__input" name="usermail" autofocus placeholder="Email Address">
                <div class="form__input-error-message"></div>
            </div>
            <div class="form__input-group">
                <input type="password" class="form__input" name="password" autofocus placeholder="Password">
                <div class="form__input-error-message"></div>
            </div>
            <div class="form__input-group">
                <input type="password" class="form__input" name="cpassword" autofocus placeholder="Confirm password">
                <div class="form__input-error-message"></div>
            </div>
            <button class="form__button" value="register now" type="submit" name="submit">Register</button>
            <p class="form__text">
                <a class="form__link" href="midwifelogin.php" id="linkLogin">Already have an account? Sign in</a>
            </p>
        </form>
    <script src="js/main.js"></script>
    
</body>
</html>