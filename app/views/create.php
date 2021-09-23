<?php $this->layout('master', ['title' => $title]) ?>

<h2>Create</h2>


<?php echo getFlash('message'); ?>

<form action="/user/store" method="post">

    <?php echo getCsrf(); ?>

    <input type="text" name="firstName" placeholder="Seu nome" value="<?php echo getOld('firstName'); ?>">
    <?php echo getFlash('firstName'); ?>
    <br>
    <input type="text" name="lastName" placeholder="Seu sobrenome"  value="<?php echo getOld('lastName'); ?>">
    <?php echo getFlash('lastName'); ?>
    <br>
    <input type="text" name="email" placeholder="Seu email" value="<?php echo getOld('email'); ?>">
    <?php echo getFlash('email'); ?>
    <br>
    <input type="password" name="password" placeholder="Sua senha" value="<?php echo getOld('password'); ?>">
    <?php echo getFlash('password'); ?>
    <br>
    <button type="submit">Create</button>
</form>
