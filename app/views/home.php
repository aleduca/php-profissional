<?php $this->layout('master', ['title' => $title]) ?>

<h2>Users <?php echo $users->count ?></h2>

<form method="get" action="/">
    <input type="text" name="s" placeholder="Digite o nome que deseja buscar...">

    <button type="submit">Buscar</button>
</form>

<ul id="users-home">
    <?php foreach ($users->rows as $user) : ?>
        <li><?php echo $user->firstName; ?> | <a href="/user/<?php echo $user->id; ?>">detalhes</a></li>
    <?php endforeach; ?>
</ul>

<?php echo $links; ?>