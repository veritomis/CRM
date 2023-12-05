    public function index(Request $request)
    {
        $<?php echo e($config->modelNames->camelPlural); ?> = $this-><?php echo e($config->modelNames->camel); ?>Repository-><?php echo $renderType; ?>;

        return view('<?php echo e($config->prefixes->getViewPrefixForInclude()); ?><?php echo e($config->modelNames->snakePlural); ?>.index')
            ->with('<?php echo e($config->modelNames->camelPlural); ?>', $<?php echo e($config->modelNames->camelPlural); ?>);
    }<?php /**PATH D:\Users\Veronica\Documents\proyectos unbc\unbc crm\aplicacion1 (1)\resources\views/vendor/laravel-generator/scaffold/controller/index_method_repository.blade.php ENDPATH**/ ?>