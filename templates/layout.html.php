<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="/styles.css">
    <script defer src="/registration.js" type="text/javascript"></script>
    <title>modernnewpost</title>
</head>

<body>
    <header class="header">
        <nav>
            <ul class="header__menu">

                <li><a class="header__link<?php if($route === 'login') {echo ' active';} ?>" href="/login">Login</a></li>

                <li><a class="header__link<?php if($route === 'user/register') {echo ' active';} ?>" href="/user/register">Registration</a></li>

                <li><a class="header__link<?php if($route === '/documents') {echo ' active';} ?>" href="/documents">Documents</a></li>


                <li><a class="header__link<?php if($route === '/logout') {echo ' active';} ?>" href="/logout">Logout</a></li>


            </ul>
        </nav>
    </header>
    <div class="hamburger-menu">
        <input id="menu__toggle" type="checkbox" />
        <label class="menu__btn" for="menu__toggle">
            <span></span>
        </label>  
        <ul class="menu__box">

                <li><a class="header__link" href="/">Login</a></li>

                <li><a class="header__link" href="/user/register">Registration</a></li>

                <li><a class="header__link" href="/documents">Documents</a></li>


                <li><a class="header__link" href="/logout">Logout</a></li>


        </ul>
    </div>
    <main class="page">
        <?= $output ?>
    </main>
    <footer class="footer">
        modernnewpost
    </footer>
    <!--    <script src="get_documents.js"></script>
    <script src="documents.js"></script>-->
</body>
</html>