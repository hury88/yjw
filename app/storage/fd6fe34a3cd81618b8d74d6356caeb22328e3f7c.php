<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" name="viewport">
    <title><?php $__env->startSection('title'); ?> <?php echo __e($system_seotitle); ?> <?php echo $__env->yieldSection(); ?></title>
    <meta name="keywords" content="<?php echo __e($system_keywords); ?>">
    <meta name="description" content="<?php echo __e($system_description); ?>">
    <meta name="renderer" content="webkit">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    <?php echo $__env->yieldContent('css'); ?>
</head>
<body>

<?php $__env->startSection('navigation'); ?>
    <?php echo $__env->make('partial.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->yieldSection(); ?>


<?php $__env->startSection('breadcrumbs'); ?>
<?php echo $__env->yieldSection(); ?>


<?php echo $__env->yieldContent('wapper'); ?>

<?php $__env->startSection('footer'); ?> 
<?php echo $__env->make('partial.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->yieldSection(); ?> 
<?php $__env->startSection('scripts'); ?>
<?php echo $__env->yieldSection(); ?>
</body>
</html>