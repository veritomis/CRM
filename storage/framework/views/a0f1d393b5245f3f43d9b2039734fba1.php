<?php
    echo "<?php".PHP_EOL;
?>

namespace <?php echo e($config->namespaces->request); ?>;

use <?php echo e($config->namespaces->model); ?>\<?php echo e($config->modelNames->name); ?>;
use Illuminate\Foundation\Http\FormRequest;

class Create<?php echo e($config->modelNames->name); ?>Request extends FormRequest
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
        return <?php echo e($config->modelNames->name); ?>::$rules;
    }
}
<?php /**PATH D:\Users\Veronica\Documents\proyectos unbc\unbc crm\aplicacion1 (1)\resources\views/vendor/laravel-generator/scaffold/request/create.blade.php ENDPATH**/ ?>