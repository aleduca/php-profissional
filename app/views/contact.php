<?php $this->layout('master', ['title' => $title]) ?>

<h2>Contato</h2>

<form method="post" action="/contact">
    
    <input type="text" name="name" placeholder="Seu nome" value="<?php echo getOld('name'); ?>"> <br>
    <?php echo getFlash('name'); ?>
    <input type="text" name="email" placeholder="Seu email" value="<?php echo getOld('email'); ?>"> <br>
    <?php echo getFlash('email'); ?>
    <input type="text" name="subject" placeholder="Assunto" value="<?php echo getOld('subject'); ?>"> <br>
    <?php echo getFlash('subject'); ?>

    <textarea placeholder="Mensagem" name="message"><?php echo getOld('subject'); ?></textarea> <br>
    <?php echo getFlash('message'); ?>

    <button type="submit">Enviar</button>

</form>
