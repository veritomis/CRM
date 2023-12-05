<!-- resources/views/auth/passwords/reset.blade.php -->


<?php $__env->startSection('content'); ?>
 
<style>
    .alert-success {
    background-color: #86B7B5;
    color: white;
}
body{
            font-family: 'Work Sans', sans-serif;
    }
</style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600;700&family=Work+Sans:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="app.css" type="text/css">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <img src="<?php echo e(asset('storage/foto_sistema/LegalCont-20230603-170641.png')); ?>" alt="logo" style="max-width: 180px; max-height: 180px; display: block; margin-left: auto; margin-right: auto;">
                    <div class="card-header"><?php echo e(__('Restablecer la contraseña')); ?></div>

                    <div class="card-body">
                        <form method="POST" action="<?php echo e(route('reset')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="form-group row">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-right"><?php echo e(__('Dirección de correo electrónico')); ?></label>

                                <div class="col-md-6">
                                    <input id="email" value="<?php echo e(old('email')); ?>" type="email"
                                        class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email"
                                        value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus>

                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <input type="hidden" name="password" id="password" class="form-control">
                                    <script>
                                        function generarClave() {
                                            var caracteresPermitidos = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                                            var longitud = 9;
                                            var resultado = '';

                                            for (var i = 0; i < longitud; i++) {
                                                var indice = Math.floor(Math.random() * caracteresPermitidos.length);
                                                resultado += caracteresPermitidos.charAt(indice);
                                            }

                                            document.getElementById('password').value = resultado;
                                        }

                                        window.onload = function() {
                                            generarClave();
                                        };
                                    </script>
                                </div>
                            </div>

                        </br>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        <?php echo e(__('Restablecer la contraseña')); ?>

                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Users\Veronica\Documents\proyectos unbc\unbc crm\aplicacion1 (1)\resources\views/reset.blade.php ENDPATH**/ ?>