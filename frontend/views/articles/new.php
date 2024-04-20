<?php 
	$this->title = 'New article';

	use frontend\models\NewArticle;
	use yii\widgets\ActiveForm;
	use yii\helpers\Html;
	use yii\helpers\Url;

	$article = new NewArticle;
?>

<?php $form = ActiveForm::Begin(); ?>

	<div class='container-fluid py-5 text-left fs-5 fw-light'>
		<?= $form -> field($article, 'title') -> textInput() ?>
		<?= $form -> field($article, 'text') -> textArea() ?>

		<br>

		<div class="form-group">
			<?= Html::submitButton('Post', ['class' => 'btn btn-success', 'style'=>'float: right;']) ?>
		</div>
	</div>

<?php ActiveForm::end(); ?>