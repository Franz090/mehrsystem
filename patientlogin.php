<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap -->
     <link rel="shortcut icon" href="/assets/favicon.ico">
    <link rel="stylesheet" href="css/main.css">
   
    <title>Patient</title>
</head>
<body>
    <header>
        <nav>
            <ul class="nav_links">
                <a class="loginButton" href='#'><button>Login</button></a>
                <a class="signUpButton" href='#'><button>Sign Up</button></a>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h1 class="form__title">Sign In</h1>
        <form class="form" id="login" action="" method="post">
            <div class="form__message form__message--error"></div>
            <div class="form__input-group">
                <input type="text" class="form__input" autofocus  name="usermail" placeholder="Enter email">
                <div class="form__input-error-message"></div>
            </div>
            <div class="form__input-group">
                <input type="password" class="form__input" name="password" autofocus placeholder="Enter password">
                <div class="form__input-error-message"></div>
            </div>
            <button class="form__button" type="submit" name="submit">Login</button>
            <p class="form__text">
                <a href="#" class="form__link">Forgot your password?</a>
            </p>
            <p class="form__text">
                <a class="form__link" href="patientform.php">Don't have an account? Create account</a>
            </p>
        </form>
    <script src="js/main.js"></script>
    
    
</body>
</html>