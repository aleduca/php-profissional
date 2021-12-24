<?php $this->layout('master', ['title' => $title]) ?>

<?php echo getFlash('updated_success', 'color:green'); ?>
<?php echo getFlash('updated_error'); ?>

<form method="post" action="/user/<?php echo $user->id ?>">
    <input type="text" name="firstName" value="<?php echo $user->firstName ?>">
    <?php echo getFlash('firstName'); ?>
    <input type="text" name="lastName" value="<?php echo $user->lastName ?>">
    <?php echo getFlash('lastName'); ?>
    <input type="text" name="email" value="<?php echo $user->email ?>">
    <?php echo getFlash('email'); ?>
    <button type="submit">Atualizar</button>
</form>

<hr>
<?php echo getFlash('password_success','color:green'); ?>
<?php echo getFlash('password_error'); ?>
<form action="/password/user/<?php echo $user->id ?>" method="post">

    <?php echo getCsrf(); ?>

    <input type="text" name="password">
    <?php echo getFlash('password'); ?>
    <input type="text" name="password_confirmation">
    <?php echo getFlash('password_confirmation'); ?>

    <button type="submit">Atualizar</button>
</form>

<hr>

<?php if ($user->path) : ?>
    <img src="/<?php echo $user->path ?>" alt="">
<?php endif; ?>

<form action="/user/profile/update" method="post"></form>

<hr>
<?php echo getFlash('upload_error'); ?>
<?php echo getFlash('upload_success', 'color:green'); ?>
<form action="/user/image/update" method="post" enctype="multipart/form-data">

    <input type="file" name="file" accept="image/png, image/jpeg, image/gif">

    <button type="submit">Alterar foto</button>

</form>
