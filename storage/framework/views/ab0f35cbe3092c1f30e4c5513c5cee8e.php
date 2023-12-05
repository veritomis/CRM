<?php
    echo "<?php".PHP_EOL;
?>

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('<?php echo e($config->tableName); ?>', function (Blueprint $table) {
            <?php echo $fields; ?>

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('<?php echo e($config->tableName); ?>');
    }
};
<?php /**PATH D:\Users\Veronica\Documents\proyectos unbc\unbc crm\aplicacion1 (1)\resources\views/vendor/laravel-generator/migration.blade.php ENDPATH**/ ?>