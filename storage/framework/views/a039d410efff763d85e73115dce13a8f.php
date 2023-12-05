<?php
    echo "<?php".PHP_EOL;
?>

namespace <?php echo e($config->namespaces->apiRequest); ?>;

use <?php echo e($config->namespaces->model); ?>\<?php echo e($config->modelNames->name); ?>;
use InfyOm\Generator\Request\APIRequest;

class Update<?php echo e($config->modelNames->name); ?>APIRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = <?php echo e($config->modelNames->name); ?>::$rules;
        <?php echo $uniqueRules; ?>

        return $rules;
    }
}
<?php /**PATH D:\Users\Veronica\Documents\proyectos unbc\unbc crm\aplicacion1 (1)\resources\views/vendor/laravel-generator/api/request/update.blade.php ENDPATH**/ ?>