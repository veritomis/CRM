<?php if($config->options->localized): ?>
    Flash::success(__('messages.deleted', ['model' => __('models/<?php echo e($config->modelNames->camelPlural); ?>.singular')]));
<?php else: ?>
    Flash::success('<?php echo e($config->modelNames->human); ?> deleted successfully.');
<?php endif; ?><?php /**PATH D:\Users\Veronica\Documents\proyectos unbc\unbc crm\aplicacion1 (1)\resources\views/vendor/laravel-generator/scaffold/controller/messages/delete_success.blade.php ENDPATH**/ ?>