<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $this->e($title) ?></title>
    <link rel="stylesheet" type="text/css" href="/assets/css/styles.css">
</head>
<body>
    <div id="header">
    <?=$this->insert('partials/header')?>
    </div>
    <div class="container">
        <?=$this->section('content')?>
    </div>
    <?=$this->section('scripts')?>
</body>
</html>