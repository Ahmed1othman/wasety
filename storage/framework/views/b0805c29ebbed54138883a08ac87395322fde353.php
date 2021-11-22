
<?php $__env->startSection('content'); ?>

    <div class="row h-100">
        <div class="col-12 col-md-10 mx-auto my-auto">
            <div class="card auth-card">
                <div class="position-relative image-side ">


                    <p class="white mb-0">
                        Please use your credentials to login.
                        <br>If you are not a member, please
                        <a href="#" class="white">register</a>.
                    </p>
                </div>
                <div class="form-side">
                    <a href="#">
                        <span class="logo-single"></span>
                    </a>
                    <p>
                        <?php if(session()->has('error')): ?>

                            <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
                                <div class="d-flex align-items-center">
                                    <div class="font-35 text-white"><i class='bx bxs-message-square-x'></i>
                                    </div>
                                    <div class="ms-3">
                                        <div class="text-white"><?php echo e(session()->get('error')); ?></div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                    </p>
                    <h6 class="mb-4">Login</h6>
                    <form method="POST" action="<?php echo e(route('login')); ?>">
                        <?php echo csrf_field(); ?>
                        <label class="form-group has-float-label mb-4">
                            <input class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                text-danger
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  type="email" name="email" value="<?php echo e(old('email')); ?>"  required/>
                            <span>E-mail</span>
                        </label>

                        <label class="form-group has-float-label mb-4">
                            <input class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            text-danger
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" type="password" placeholder=""required />
                            <span>Password</span>
                        </label>
                        <div class="d-flex justify-content-between align-items-center">
                            <?php if(Route::has('password.request')): ?>
                            <a  href="<?php echo e(asset(route('password.request'))); ?>">
                                <?php echo e(__('Forgot your password?')); ?>

                            </a>
                                <?php endif; ?>
                            <button class="btn btn-primary btn-lg btn-shadow" type="submit">LOGIN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\project 1\wasety\resources\views/auth/login.blade.php ENDPATH**/ ?>