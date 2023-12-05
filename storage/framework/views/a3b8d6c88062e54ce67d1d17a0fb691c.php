<?php
    echo "<?php".PHP_EOL;
?>

namespace <?php echo e($config->namespaces->apiController); ?>;

use <?php echo e($config->namespaces->apiRequest); ?>\Create<?php echo e($config->modelNames->name); ?>APIRequest;
use <?php echo e($config->namespaces->apiRequest); ?>\Update<?php echo e($config->modelNames->name); ?>APIRequest;
use <?php echo e($config->namespaces->model); ?>\<?php echo e($config->modelNames->name); ?>;
use <?php echo e($config->namespaces->repository); ?>\<?php echo e($config->modelNames->name); ?>Repository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use <?php echo e($config->namespaces->app); ?>\Http\Controllers\AppBaseController;

<?php echo $docController; ?>

class <?php echo e($config->modelNames->name); ?>APIController extends AppBaseController
{
    private <?php echo e($config->modelNames->name); ?>Repository $<?php echo e($config->modelNames->camel); ?>Repository;

    public function __construct(<?php echo e($config->modelNames->name); ?>Repository $<?php echo e($config->modelNames->camel); ?>Repo)
    {
        $this-><?php echo e($config->modelNames->camel); ?>Repository = $<?php echo e($config->modelNames->camel); ?>Repo;
    }

    <?php echo $docIndex; ?>

    public function index(Request $request): JsonResponse
    {
        $<?php echo e($config->modelNames->camelPlural); ?> = $this-><?php echo e($config->modelNames->camel); ?>Repository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

<?php if($config->options->localized): ?>
        return $this->sendResponse(
            $<?php echo e($config->modelNames->camelPlural); ?>->toArray(),
            __('messages.retrieved', ['model' => __('models/<?php echo e($config->modelNames->camelPlural); ?>.plural')])
        );
<?php else: ?>
        return $this->sendResponse($<?php echo e($config->modelNames->camelPlural); ?>->toArray(), '<?php echo e($config->modelNames->humanPlural); ?> retrieved successfully');
<?php endif; ?>
    }

    <?php echo $docStore; ?>

    public function store(Create<?php echo e($config->modelNames->name); ?>APIRequest $request): JsonResponse
    {
        $input = $request->all();

        $<?php echo e($config->modelNames->camel); ?> = $this-><?php echo e($config->modelNames->camel); ?>Repository->create($input);

<?php if($config->options->localized): ?>
        return $this->sendResponse(
            $<?php echo e($config->modelNames->camel); ?>->toArray(),
            __('messages.saved', ['model' => __('models/<?php echo e($config->modelNames->camelPlural); ?>.singular')])
        );
<?php else: ?>
        return $this->sendResponse($<?php echo e($config->modelNames->camel); ?>->toArray(), '<?php echo e($config->modelNames->human); ?> saved successfully');
<?php endif; ?>
    }

    <?php echo $docShow; ?>

    public function show($id): JsonResponse
    {
        /** @var <?php echo e($config->modelNames->name); ?> $<?php echo e($config->modelNames->camel); ?> */
        $<?php echo e($config->modelNames->camel); ?> = $this-><?php echo e($config->modelNames->camel); ?>Repository->find($id);

        if (empty($<?php echo e($config->modelNames->camel); ?>)) {
<?php if($config->options->localized): ?>
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/$MODEL_NAME_PLURAL_CAMEL$.singular')])
            );
<?php else: ?>
            return $this->sendError('<?php echo e($config->modelNames->human); ?> not found');
<?php endif; ?>
        }

<?php if($config->options->localized): ?>
        return $this->sendResponse(
            $<?php echo e($config->modelNames->camel); ?>->toArray(),
            __('messages.retrieved', ['model' => __('models/<?php echo e($config->modelNames->camelPlural); ?>.singular')])
        );
<?php else: ?>
        return $this->sendResponse($<?php echo e($config->modelNames->camel); ?>->toArray(), '<?php echo e($config->modelNames->human); ?> retrieved successfully');
<?php endif; ?>
    }

    <?php echo $docUpdate; ?>

    public function update($id, Update<?php echo e($config->modelNames->name); ?>APIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var <?php echo e($config->modelNames->name); ?> $<?php echo e($config->modelNames->camel); ?> */
        $<?php echo e($config->modelNames->camel); ?> = $this-><?php echo e($config->modelNames->camel); ?>Repository->find($id);

        if (empty($<?php echo e($config->modelNames->camel); ?>)) {
<?php if($config->options->localized): ?>
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/$MODEL_NAME_PLURAL_CAMEL$.singular')])
            );
<?php else: ?>
            return $this->sendError('<?php echo e($config->modelNames->human); ?> not found');
<?php endif; ?>
        }

        $<?php echo e($config->modelNames->camel); ?> = $this-><?php echo e($config->modelNames->camel); ?>Repository->update($input, $id);

<?php if($config->options->localized): ?>
        return $this->sendResponse(
            $<?php echo e($config->modelNames->camel); ?>->toArray(),
            __('messages.updated', ['model' => __('models/<?php echo e($config->modelNames->camelPlural); ?>.singular')])
        );
<?php else: ?>
        return $this->sendResponse($<?php echo e($config->modelNames->camel); ?>->toArray(), '<?php echo e($config->modelNames->name); ?> updated successfully');
<?php endif; ?>
    }

    <?php echo $docDestroy; ?>

    public function destroy($id): JsonResponse
    {
        /** @var <?php echo e($config->modelNames->name); ?> $<?php echo e($config->modelNames->camel); ?> */
        $<?php echo e($config->modelNames->camel); ?> = $this-><?php echo e($config->modelNames->camel); ?>Repository->find($id);

        if (empty($<?php echo e($config->modelNames->camel); ?>)) {
<?php if($config->options->localized): ?>
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/$MODEL_NAME_PLURAL_CAMEL$.singular')])
            );
<?php else: ?>
            return $this->sendError('<?php echo e($config->modelNames->human); ?> not found');
<?php endif; ?>
        }

        $<?php echo e($config->modelNames->camel); ?>->delete();

<?php if($config->options->localized): ?>
        return $this->sendError(
            $id,
            __('messages.deleted', ['model' => __('models/<?php echo e($config->modelNames->camelPlural); ?>.singular')])
        );
<?php else: ?>
        return $this->sendSuccess('<?php echo e($config->modelNames->human); ?> deleted successfully');
<?php endif; ?>
    }
}
<?php /**PATH D:\Users\Veronica\Documents\proyectos unbc\unbc crm\aplicacion1 (1)\resources\views/vendor/laravel-generator/api/controller/repository/controller.blade.php ENDPATH**/ ?>