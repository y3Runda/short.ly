<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$title?> - Short.ly</title>
    <!-- Connect css files -->
    <link rel="stylesheet" href="/public/css/main.css">
    <!-- Connect fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
</head>
<body>

    <div id="wrapper">
        <div id="content">
            <header class="container bg-primary">
                <div class="everything">
                    <div id="logo">
                        <a href="/">
                            <!-- Here I can set logo with <img> -->
                            <span>Short.ly</span>
                        </a>
                    </div>
                    <div id="about">
                        <noindex>
                            <a href="/about" style="margin-left: 0;">About</a>
                        </noindex>
                        <noindex>
                            <a href="/help">Help</a>
                        </noindex>
                    </div>
                    <div id="menu-btns">
                        <a href="/user/login" class="btn white">Login</a>
                        <a href="/user/signup" class="btn red header-last-btn">Signup</a>
                    </div>
                </div>
            </header>
            <?php echo $content; ?>
        </div>
        <footer class="container">

        </footer>
    </div>

</body>
</html>