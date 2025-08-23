<?php 
/** @var \League\Plates\Template\Template $this */ 
$name   = $this->e($name);
$title  = $this->e($title);
$sufix  = "Affiler | ";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://affiler.com.br/resources/css/master.css">
    <link rel="stylesheet" href="http://affiler.com.br/resources/css/<?= $name ?>.css">
    <title><?= $sufix . $title ?></title>
</head>

<body class="master-body">
    <header class="navbar">
        <span class="nav-logo">
            <a href="/">
                <img src="<?= getenv('IMG_HOST_RESOURCES'); ?>/logosvg.svg" alt="logo_img">
            </a>
        </span>

        <?php if (!in_array($name, ["catalog", "login", "signup"])): ?>
            
            <nav>
                <ul class="nav-options">
                    <li><a href="#">Nav 1</a></li>
                </ul>
            </nav>

        <?php else: ?>
            <div class="nav-end">
                <div class="nav-user-container">
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        
                        <?php if (in_array($name, ["catalog", "signup"])): ?>
                            <a href="/login" class="btn-secondary-outline">Entrar</a>
                        <?php endif; ?>

                        <?php if (in_array($name, ["catalog", "login"])): ?>
                            <a href="/signup" class="btn-secondary">Cadastre-se</a>
                        <?php endif; ?>

                    <?php endif; ?>
                </div>
            </div>

            <?php if ($name === "catalog"): ?>
                <div class="sub-navbar">
                    test
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </header>
    
    <div class="container-row content-container">
        <!-- Sidebar -->
        <?php if (!in_array($name, ["catalog", "login", "signup"])): ?>
            <aside class="sidebar">
                <nav>
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
                </nav>
            </aside>
        <?php endif; ?>

        <!-- Main content -->
        <main class="main-content">
            <?= $this->section('content') ?>
        </main>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Leryx Solutions. Todos os direitos reservados. | Developed by Leryx Solutions</p>
    </footer>

    <!-- Scripts -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="../../resources/js/master.js"></script>
</body>
</html>
