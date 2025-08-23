<?php 
/** @var \League\Plates\Template\Template $this */ 
$name = $this->e($name);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://affiler.com.br/resources/css/master.css">
    <link rel="stylesheet" href="http://affiler.com.br/resources/css/<?= $name ?>.css">
    
    <title><?= $this->e($title) ?></title>
    <body class="master-body">
        <header class="navbar">
            <span class="nav-logo">
                <a href="/" ><img src="<?= getenv('IMG_HOST_RESOURCES'); ?>/logosvg.svg" alt="logo_img"></a>
            </span>
        <?php if($name != "catalog" && $name != "login" && $name != "signup" && $name != "login"): ?>

            <nav>
                <ul class="nav-options">
                    <li><a href="#">Nav 1</a></li>
                </ul>
            </nav>

        <?php elseif($name == "catalog"): ?>
            
            <div class="nav-end">
                <div class="nav-user-container">
                    <?php
                        if(isset($_SESSION['user_id'])):
                    ?>
                        <a href="/login" class="btn-secondary-outline">
                            Painel
                        </a>
                    <?php
                        else:
                    ?>
                        <a href="/login" class="btn-secondary-outline">
                            Entrar
                        </a>
                        <a href="/signup" class="btn-secondary">
                            Cadastre-se
                        </a>
                    <?php
                        endif;
                    ?>
                </div>
            </div>

            <div class="sub-navbar">
                test

            </div>


        <?php
            endif;
        ?>
        </header>
        
        <div class="container-row content-container">

            <!-- Sidebar lateral -->
            <?php if($name != "catalog" && $name != "login" && $name != "signup" && $name != "login"): ?>

                <aside class="sidebar">
                    <nav>
                        <span class="side-options">
                            
                        </span>

                        <ul class="side-options">

                            <li class="has-dropdown">
                                <a class="option-link" href="#">
                                    <span class="icon"><ion-icon name="cube"></ion-icon></span>
                                    <span class="text">Produtos</span>
                                    <span class="arrow"><ion-icon name="caret-down"></ion-icon></span>
                                </a>
                                <ul class="dropdown">
                                    <li><a href="produtos">Listar Produtos</a></li>
                                    <li><a href="anuncios">Anúncios</a></li>
                                </ul>
                            </li>

                            <li class="has-dropdown">
                                <a class="option-link" href="#">
                                    <span class="icon"><ion-icon name="people"></ion-icon></span>
                                    <span class="text">Usuários</span>
                                    <span class="arrow"><ion-icon name="caret-down"></ion-icon></span>
                                </a>
                                <ul class="dropdown">
                                    <li><a href="#">Definir Acessos</a></li>
                                    <li><a href="listar-usuarios">Listar Usuários</a></li>
                                </ul>
                            </li>

                            <!-- A PRINCIPIO O ACESSO A ESTE MENU SERA SOMENTE DO SUPORTE -->
                            <li class="has-dropdown">
                                <a class="option-link" href="#">
                                    <span class="icon"><ion-icon name="settings"></ion-icon></span>
                                    <span class="text">Configurações</span>
                                    <span class="arrow"><ion-icon name="caret-down"></ion-icon></span>
                                </a>
                                <ul class="dropdown">
                                    <li class="has-dropdown">
                                        <a class="option-link" href="#">
                                            <span class="text">Monitoramento</span>
                                            <span class="arrow subarrow"><ion-icon name="chevron-down"></ion-icon></span>
                                        </a>
                                        <ul class="dropdown subdropdown">
                                            <li><a class="option-link" href="/monitoramento-filas">Filas</a></li>
                                            <li><a class="option-link" href="/acompanhamento-logs">Logs</a></li>
                                        </ul>
                                    </li>
                                    <li class="has-dropdown">
                                        <a class="option-link" href="#">
                                            <span class="text">Marketplaces</span>
                                            <span class="arrow subarrow"><ion-icon name="chevron-down"></ion-icon></span>
                                        </a>
                                        <ul class="dropdown subdropdown">
                                            <li><a class="option-link" href="/acesso-marketplace">Acesso</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                        </ul>

                        <div class="side-bottom">
                            <img src="" alt="">
                            
                        </div>
                    </nav>
                </aside>
            <?php
                endif;
            ?>

            <!-- Conteúdo principal -->
            <main class="main-content">
                <?= $this->section('content') ?>
            </main>
        </div>


        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <script src="../../resources/js/master.js"></script>
    </body>
</html>