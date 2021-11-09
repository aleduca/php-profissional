<?php $this->layout('master', ['title' => $title]) ?>

<h2>Contato</h2>

<?php echo getFlash('contact_success', 'background-color:green;color:white'); ?>
<?php echo getFlash('contact_error', 'background-color:red;color:white'); ?>

<form method="post" action="/contact">

    <?php echo getCsrf(); ?>
    
    <input type="text" name="name" placeholder="Seu nome" value="<?php echo getOld('name'); ?>"> 
    <?php echo getFlash('name'); ?><br>
    <input type="text" name="email" placeholder="Seu email" value="<?php echo getOld('email'); ?>"> 
    <?php echo getFlash('email'); ?><br>
    <input type="text" name="subject" placeholder="Assunto" value="<?php echo getOld('subject'); ?>"> 
    <?php echo getFlash('subject'); ?><br>

    <textarea placeholder="Mensagem" name="message"><?php echo getOld('subject'); ?></textarea>
    <?php echo getFlash('message'); ?> <br>

    <button type="submit">Enviar</button>

</form>
