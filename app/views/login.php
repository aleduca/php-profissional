<?php $this->layout('master', ['title' => $title]) ?>

<?php if (!logged()) : ?>
<h2>Login</h2>
    <?php echo getFlash('message'); ?>
<form action="/login" method="post" id="box-login">
    <input type="text" name="email" placeholder="Seu email" value="salazar.horacio@hotmail.com">
    <input type="password" name="password" placeholder="Sua senha" value="123">
    <button type="submit">Login</button>
</form>
<?php else : ?>
    <h2>Já está logado</h2>
<?php endif; ?>