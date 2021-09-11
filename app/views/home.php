<?php $this->layout('master', ['title' => $title]) ?>

<h2>Users</h2>

<ul id="users-home">
    <?php foreach ($users as $user) : ?>
        <li><?php echo $user->firstName; ?> | <a href="/user/<?php echo $user->id; ?>">detalhes</a></li>
    <?php endforeach; ?>
</ul>

<?php $this->start('scripts') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.4/axios.min.js" integrity="sha512-lTLt+W7MrmDfKam+r3D2LURu0F47a3QaW5nF0c6Hl0JDZ57ruei+ovbg7BrZ+0bjVJ5YgzsAWE+RreERbpPE1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    axios.defaults.headers = {
        "Content-type":"applicatio/json",
        HTTP_X_REQUESTED_WITH: "XMLHttpRequest",
    }
    async function loadUSers(){
        try{
            const {data} = await axios.get('/users');
            console.log(data);
        }catch(error){
            console.log(error);
        }
    }

    loadUSers();
</script>

<?php $this->stop() ?>