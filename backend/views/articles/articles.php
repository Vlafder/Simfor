<?php
$this->title = 'Articles list';
?>

<div class="site-index">
	<div class="jumbotron text-center bg-transparent">
	    <h1 class="display-4">Articles</h1>
	</div>


	<div class="block_item" style="width: 5%;" > Id     </div>
  	<div class="block_item" style="width: 15%;"> Author </div>
  	<div class="block_item" style="width: 20%;"> Title   </div>
 	<div class="block_item" style="width: 33%;"> Text   </div>
 	<div class="block_item" style="width: 8%;" > Likes  </div>
 	<div class="block_item" style="width: 8%;" > Views  </div>
 	<div class="block_item" style="width: 8%;" > Date   </div>	
 	<br>


	<?php foreach ($articles as $article): ?>
		<a href='<?= "/articles/article?id=".$article->art_id ?>'>
			<button class="art_btn" style="width: 100%">
	     		<div class="block_item" style="width: 5%;" > <?= $article->art_id ?>                    </div>
		      	<div class="block_item" style="width: 15%;"> <?= $article->user_id ?>                   </div>
		      	<div class="block_item" style="width: 20%;"> <?= $article->title?>                      </div>
		     	<div class="block_item" style="width: 34%;"> <?= substr($article->text, 0, 40)."..." ?> </div>
		     	<div class="block_item" style="width: 8%; text-align: left;" > <?= $article->likes ?>   </div>
		     	<div class="block_item" style="width: 8%;" > <?= $article->views ?>                     </div>
		     	<div class="block_item" style="width: 8%;" > <?= $article->date ?>                      </div>
			</button>
		</a>
    <?php endforeach; ?>
</div>
