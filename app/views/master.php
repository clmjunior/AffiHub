<?php /** @var \League\Plates\Template\Template $this */ ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://totalhub.totalseller.com.br/resources/css/master.css">

    <title><?= $this->e($title) ?></title>
    <body class="master-body">
        <header class="navbar">
            <span class="nav-logo">
                <img src="http://totalhub.totalseller.com.br/resources/img/logosvg.svg" alt="logo_img">
            </span>

            <nav>
                <ul class="nav-options">
                    <li><a href="#">Nav 1</a></li>
                </ul>
            </nav>
        </header>
        
        <div class="container-row content-container">
            <!-- Sidebar lateral -->
            <aside class="sidebar">
                <nav>
                    <span class="side-options">
                        email@example.com.br
                    </span>

                    <ul class="side-options">
                        <li><a class="option-link" href="#"><p>Side 1</p><ion-icon name="caret-down"></ion-icon></a></li>
                        <li><a class="option-link" href="#"><p>Side 2</p><ion-icon name="caret-down"></ion-icon></a></li>
                        <li><a class="option-link" href="#"><p>Side 3</p><ion-icon name="caret-down"></ion-icon></a></li>
                    </ul>
                    <div class="side-bottom">
                        <img src="" alt="">
                        
                    </div>
                </nav>
            </aside>

            <!-- Conte�do principal -->
            <main class="main-content">
                <?= $this->section('content') ?>
            </main>
        </div>


        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <script src="../../resources/js/master.js"></script>
    </body>
</html>