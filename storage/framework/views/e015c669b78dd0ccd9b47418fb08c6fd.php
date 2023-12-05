        if (empty($<?php echo e($config->modelNames->camel); ?>)) {
<?php if($config->options->localized): ?>
            Flash::error(__('models/<?php echo e($config->modelNames->camelPlural); ?>.singular').' '.__('messages.not_found'));
<?php else: ?>
            Flash::error('<?php echo e($config->modelNames->human); ?> not found');
<?php endif; ?>

            return redirect(route('<?php echo e($config->prefixes->getRoutePrefixWith('.')); ?><?php echo e($config->modelNames->camelPlural); ?>.index'));
        }
<?php /**PATH D:\Users\Veronica\Documents\proyectos unbc\unbc crm\aplicacion1 (1)\resources\views/vendor/laravel-generator/scaffold/controller/messages/not_found.blade.php ENDPATH**/ ?>