<?php
$this->title = 'Article info';

use backend\models\Articles;
use backend\models\Comments;
use backend\models\Likes;
?>

<div class="site-index">
	<div class="jumbotron text-center bg-transparent">
	    <h1 class="display-4">User</h1>
	</div>

	<table width="100%">
		<tr>
			<td class="block_name">Id</td>
			<td class="block_info"> <?= $user->id ?> </td>
		</tr>
		<tr>
			<td class="block_name">Username</td>
			<td class="block_info"> <?= $user->username ?> </td>
		</tr>
		<tr>
			<td class="block_name">Articles</td>
			<td class="block_info"> 
				<?= Articles::find()->where(['user_id'=>$user->id])->count() ?>
			 </td>
		</tr>
		<tr>
			<td class="block_name">Comments</td>
			<td class="block_info"> 
				<?= Comments::find()->where(['user_id'=>$user->id])->count() ?> 
			</td>
		</tr>
		<tr>
			<td class="block_name">Likes</td>
			<td class="block_info"> 
				<?= Likes::find()->where(['user_id'=>$user->id])->count() ?> 
			</td>
		</tr>
		<tr>
			<td class="block_name">Registered</td>
			<td class="block_info"> 
				<?= date('i:H d-m-Y', $user->created_at) ?> 
			</td>
		</tr>
	</table>

	<div style="height: 40px; margin-top: 25px; justify-content: space-between; display: flex;">
		<a href="/users/delete?id=<?= $user->id ?>">
			<button class="btn btn-danger"> Delete </button>
		</a>
		<a href="/users">
			<button class="btn btn-success"> Back </button>
		</a>
	</div>

</div>
