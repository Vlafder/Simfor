<?php
$this->title = 'New articles';

use frontend\models\Likes;
?>

<div class="site-index">

    <div class="container-fluid py-5 text-center">
        <h1 class="display-4">New Lorum Articles</h1>
        <p class="fs-5 fw-light">We bring you best articles from all around the web</p>
    </div>
    
    <div class="body-content">
		<div class="row" style="justify-content: center;">
			<?php foreach ($articles as $article): ?>
				<div class="col-lg-4">
					<h3><?= $article->title ?></h3>

					<div style="position: relative">
						<p><?= substr($article->text, 0, 400) . " ..." ?></p>
						<div class="text_blur"></div>
					</div>

					<p style="color: grey">By <?= $article->user_id?> </p>




					<?php if( !Yii::$app->user->isGuest ){ ?>
						<button class="elements" onclick="Like('<?= "like".$article->art_id?>')">
					<?php } else{ ?>
						<a href="/site/login"> <button class="elements">
					<?php } 
						$liked = Likes::find() -> where( ['art_id' => $article->art_id, 'user_id'=>Yii::$app->user->id]) -> one();
						if($liked == null)
							$liked = false;
						else
							$liked = $liked->state;
					?>

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



					<img style="padding-left: 20px; width: 62px;" class="elements" src="/views.png" >
					<?= $article->views?>

					<a style="float: right;" class="btn btn-outline-secondary" href=" <?='/articles/article?id=' . $article->art_id ?>" > More &raquo;</a>
					

				</div>
			<?php endforeach; ?>
		</div>
	</div>

	<?php if($articles!=null) {?>
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
	<?php } ?>











	<div class="page_nav_footer">
		<div class="page_nav_buttons">
			<a href="<?php if($pagenum==1) echo("/"); else echo("/articles/?page=".($pagenum-1)); ?>" style="text-decoration: none;">
				<button class="btn btn-outline-success">&laquo;</button>
			</a>

			<p class="btn btn-outline-success" style="margin: 0px;"><?= $pagenum ?></p>

			<a href="<?php if($pagenum==$page_cnt) echo("/articles/?page=".($pagenum)); else echo("/articles/?page=".($pagenum+1)); ?>">
				<button class="btn btn-outline-success">&raquo;</button>
			</a>
		</div>
	</div>

</div>