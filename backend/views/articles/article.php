<?php
$this->title = 'Article info';
?>

<div class="site-index">
	<div class="jumbotron text-center bg-transparent">
	    <h1 class="display-4">Articles</h1>
	</div>

	<table width="100%">
		<tr>
			<td class="block_name">Id</td>
			<td class="block_info"> <?= $article->art_id ?> </td>
		</tr>
		<tr>
			<td class="block_name">Author</td>
			<td class="block_info"> <?= $article->user_id ?> </td>
		</tr>
		<tr>
			<td class="block_name">Title</td>
			<td class="block_info"> <?= $article->title ?> </td>
		</tr>
		<tr>
			<td class="block_name">Text</td>
			<td class="block_info"> <?= $article->text ?> </td>
		</tr>
		<tr>
			<td class="block_name">Likes</td>
			<td class="block_info"> <?= $article->likes ?> </td>
		</tr>
		<tr>
			<td class="block_name">Views</td>
			<td class="block_info"> <?= $article->views ?> </td>
		</tr>
		<tr>
			<td class="block_name">Date</td>
			<td class="block_info"> <?= $article->date ?> </td>
		</tr>
	</table>

	<div style="height: 40px; margin-top: 25px; justify-content: space-between; display: flex;">
		<a href="/articles/delete?id=<?= $article->art_id ?>">
			<button class="btn btn-danger"> Delete </button>
		</a>
		<a href="/articles">
			<button class="btn btn-success"> Back </button>
		</a>
	</div>

</div>
