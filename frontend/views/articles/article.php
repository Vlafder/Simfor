<?php
$this->title = $article->title;
?>

<?php
	use frontend\models\NewComment;
	use yii\widgets\ActiveForm;
	use yii\helpers\Html;
	use yii\helpers\Url;

	$comment = new NewComment;
?>

<div class="site-index">

    <div class="container-fluid py-5 text-left">

        <h1 class="display-4"><?= $article->title ?></h1>

        <div style="margin-left: 15px; margin-right: 15px;">
	        <p class="fs-5 fw-light" >By <?= $article->user_id ?></p>

	        <div class="body-content">
				<p><?= $article->text ?></p>
			</div>	



			<?php if( !Yii::$app->user->isGuest ){ ?>
				<button class="elements" onclick="Like('<?= "like".$article->art_id?>')">
			<?php } else{ ?>
				<a href="/site/login"> <button class="elements">
			<?php } ?>

					<svg xmlns="http://www.w3.org/2000/svg" height="34px" viewBox="0 0 24 24" width="34px" id='<?= "like".$article->art_id?>' 
						fill="<?php if($liked) echo('red'); else echo('#202020') ?>">

						<path d="M0 0h24v24H0V0z" fill="none"/>
						<path d="M16.5 3c-1.74 0-3.41.81-4.5 2.09C10.91 3.81 9.24 3 7.5 3 4.42 3 2 5.42 2 8.5c0 3.78 3.4 6.86 8.55 11.54L12 21.35l1.45-1.32C18.6 15.36 22 12.28 22 8.5 22 5.42 19.58 3 16.5 3zm-4.4 15.55l-.1.1-.1-.1C7.14 14.24 4 11.39 4 8.5 4 6.5 5.5 5 7.5 5c1.54 0 3.04.99 3.57 2.36h1.87C13.46 5.99 14.96 5 16.5 5c2 0 3.5 1.5 3.5 3.5 0 2.89-3.14 5.74-7.9 10.05z"/>
					</svg>
				</button>

			<?php if( Yii::$app->user->isGuest ){ ?>
				</a>
			<?php } ?>

			<span id='<?= "like".$article->art_id."count" ?>' style="display: inline-block; width: 10px">
				<?= $article->likes?>	
			</span>





			<img style="padding-left: 20px; width: 62px;" class="elements" src="/views.png"> <?= $article->views?>

			<a style="float: right;" class="btn btn-outline-secondary" href="/" > To main </a>

			<br><br><hr>

			<?php if( !Yii::$app->user->isGuest ){ ?>
				<?php $form = ActiveForm::Begin(); ?>
						<?= $form -> field($comment, 'text') -> textInput() ->  label('') ?>

						<br>

						<div class="form-group">
							<?= Html::submitButton('Comment', ['class' => 'btn btn-success', 'style' => 'margin-bottom: 0px;']) ?>
						</div>

				<?php ActiveForm::end(); ?>
				<br><hr>
			<?php } ?>

			<br>

			<?php foreach ($comments as $comment): ?>
				<div class="comment">
					<h5> By <?= $comment->user_id ?> </h5> 
					<p> <?= $comment->text ?> </p>
				</div>
			<?php endforeach; ?>
		</div>

	</div>



	<script> 
		function Like(val) {
			if(document.getElementById(val).getAttribute('fill') == "#202020"){
				document.getElementById(val).setAttribute('fill', 'red');
				document.getElementById(val+'count').innerHTML = Number(document.getElementById(val+'count').innerHTML) + 1;
				$.ajax({
					url: '/articles/like',
					type: 'POST',
					data: '<?= "art_id=".$article->art_id ?>'
				});
			}
			else{
				document.getElementById(val).setAttribute('fill', '#202020');
				document.getElementById(val+'count').innerHTML = Number(document.getElementById(val+'count').innerHTML) - 1;
				$.ajax({
					url: '/articles/like',
					type: 'POST',
					data: '<?= "art_id=".$article->art_id ?>'
				});
			}
		}
    </script>



</div>