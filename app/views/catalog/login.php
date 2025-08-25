<?php /** @var \League\Plates\Template\Template $this */ ?>
<?php $this->layout('master', ['title' => $title, 'name' => $name]) ?>

<div class="logo-icon-container">
    <img src="<?= getenv('IMG_HOST_RESOURCES'); ?>/logoicon.svg" alt="logo_img">
</div>

<div class="form-card">
    <h1 class="card-title">Login</h1>
    <form action="">
        test
    </form>
</div>