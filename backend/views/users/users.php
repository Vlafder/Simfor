<?php
$this->title = 'Users list';

use backend\models\Articles;
use backend\models\Comments;
use backend\models\Likes;
?>

<div class="site-index">
	<div class="jumbotron text-center bg-transparent">
	    <h1 class="display-4">Users</h1>
	</div>


	<div class="block_item" style="width: 5%;" > Id         </div>
  	<div class="block_item" style="width: 61%;"> Username   </div>
  	<div class="block_item" style="width: 8%;"> Articles   </div>
 	<div class="block_item" style="width: 8%;"> Comments   </div>
 	<div class="block_item" style="width: 8%;" > Likes      </div>
 	<div class="block_item" style="width: 8%;" > Registered </div>
 	<br>


	<?php foreach ($users as $user): ?>
		<a href='<?= "/users/user?id=".$user->id ?>'>
			<button class="art_btn" style="width: 100%">
	     		<div class="block_item" style="width: 5%;" > <?= $user->id ?>       </div>
		      	<div class="block_item" style="width: 61%;"> <?= $user->username ?> </div>
		      	<div class="block_item" style="width: 8%;"> 
		      		<?= Articles::find()->where(['user_id'=>$user->id])->count() ?> </div>
		     	<div class="block_item" style="width: 8%;">
		     		<?= Comments::find()->where(['user_id'=>$user->id])->count() ?> </div>
		     	<div class="block_item" style="width: 8%;" >
		     		<?= Likes::find()->where(['user_id'=>$user->id])->count() ?>    </div>
		     	<div class="block_item" style="width: 8%;" > 
		     		<?= date('d-m-Y', $user->created_at) ?>                         </div>
			</button>
		</a>
    <?php endforeach; ?>
</div>
