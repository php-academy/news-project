<?php
/* @var $this SiteController */
/* @var $model RegisterForm */
/* @var $form CActiveForm */
/* @var $user User */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'register-form-register-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

    <?php if($user) {
        ?><p class="note" > Пользователь <?=$user->login?> успешно зарегистрирован. </p ><?php
    }
    ?>
	<p class="note">Поля со <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'login'); ?>
		<?php echo $form->textField($model,'login'); ?>
		<?php echo $form->error($model,'login'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'repeatPassword'); ?>
		<?php echo $form->passwordField($model,'repeatPassword'); ?>
		<?php echo $form->error($model,'repeatPassword'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'name'); ?>
        <?php echo $form->textField($model,'name'); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'age'); ?>
		<?php echo $form->textField($model,'age'); ?>
		<?php echo $form->error($model,'age'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'avatar'); ?>
		<?php echo $form->fileField($model,'avatar'); ?>
		<?php echo $form->error($model,'avatar'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Зарегистрироваться'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
