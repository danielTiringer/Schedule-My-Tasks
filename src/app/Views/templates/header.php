<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="/assets/css/style.css">
        <title>Schedule-My-Tasks</title>
    </head>
    <body>
        <?php
            $uri = service('uri');
        ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="/">Schedule-My-Tasks</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <?php if (session()->get('isLoggedIn')): ?>
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item <?= (!$uri->getSegment(1) ? 'active' : null) ?>">
                                <a class="nav-link" href="/">Daily Tasks</a>
                            </li>
                            <li class="nav-item <?= ($uri->getSegment(1) == 'todos' ? 'active' : null) ?>">
                                <a class="nav-link" href="/todos">Todos</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav my-2 my-lg-0">
                            <li class="nav-item <?= ($uri->getSegment(1) == 'profile' ? 'active' : null) ?>">
                                <a class="nav-link" href="<?= route_to('profile') ?>">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= route_to('logout') ?>">Logout</a>
                            </li>
                        </ul>
                    <?php else: ?>
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item <?= ($uri->getSegment(1) == 'login' ? 'active' : null) ?>">
                                <a class="nav-link" href="<?= route_to('login') ?>">Login</a>
                            </li>
                            <li class="nav-item <?= ($uri->getSegment(1) == 'register' ? 'active' : null) ?>">
                                <a class="nav-link" href="<?= route_to('register') ?>">Register</a>
                            </li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
        <div class="container">
