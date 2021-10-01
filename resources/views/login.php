<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login - WarCheats</title>
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="manifest.json">
    <link rel="mask-icon" href="safari-pinned-tab.svg" color="#0288d1">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,400italic,500,700">
    <link rel="stylesheet" href="../../assets/css/vendor.min.css">
    <link rel="stylesheet" href="../../assets/css/elephant.min.css">
    <link rel="stylesheet" href="../../assets/css/login-2.min.css">
</head>

<body>
    <div class="login">
    <div class="text-center">
            <h2 class="login-heading">Login</h2>
            </div>
        <div class="login-body">
            <!--<a class="login-brand" href="index.html">
                <img class="img-responsive" src="../../assets/img/logo.svg" alt="Elephant">
            </a>-->           
            <?php            
            if (array_key_exists('alert', $data))
                echo $data['alert'];
            ?>
            <div class="login-form">
                <form name="login" data-toggle="validator" action="auth" method="post">
                    <input type="hidden" name="_csrf" value="<?php echo $data['_csrf'] ?>" />
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input id="username" class="form-control" type="text" name="username" spellcheck="false" autocomplete="off" data-msg-required="Please enter your email address." required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" class="form-control" type="password" name="password" minlength="6" data-msg-minlength="Password must be 6 characters or more." data-msg-required="Please enter your password." autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label class="custom-control custom-control-primary custom-checkbox">
                            <input class="custom-control-input" type="checkbox" checked="checked">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-label">Keep me signed in</span>
                        </label>
                        <span aria-hidden="true"> · </span>
                        <a href="<?php echo $config['info']['lost-password']; ?>">Forgot password?</a>
                    </div>
                    <button class="btn btn-primary btn-block" type="submit">Sign in</button>
                </form>
            </div>
        </div>
    </div>
    <div class="login-footer">
        Don't have an account? <a href="<?php echo $config['info']['sign-up']; ?>">Sign Up</a>
    </div>
    </div>
    <script src="../../assets/js/vendor.min.js"></script>
    <script src="../../assets/js/elephant.min.js"></script>
</body>
</html>