<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $this->e($title) ?></title>
    <link rel="stylesheet" type="text/css" href="/assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <?=$this->section('styles')?>
</head>
<body>

    <div id="header">
    <?=$this->insert('partials/header')?>
    </div>
    <div class="container">
        <?=$this->section('content')?>
    </div>
    <script src="/app.js"></script>
    <?=$this->section('scripts')?>
</body>
</html>
