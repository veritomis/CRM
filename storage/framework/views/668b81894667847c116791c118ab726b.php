<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>UNBC</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600;700&family=Work+Sans:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">

    <style>
       /*body {
            font-family: 'Nunito', sans-serif;
        }*/
        body{
            font-family: 'Work Sans', sans-serif;
        }
    </style>
</head>

<body>
    <?php echo $__env->yieldContent('content'); ?>
</body>

</html>
<?php /**PATH D:\Users\Veronica\Documents\proyectos unbc\unbc crm\aplicacion1 (1)\resources\views/app.blade.php ENDPATH**/ ?>