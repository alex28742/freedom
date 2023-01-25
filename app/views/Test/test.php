<p>View: TEST->test</p>



<? foreach($posts as $post):?>
<p><?=$post['title']?></p>
<p><?=$post['excerpt']?></p>
<hr>
<? endforeach; ?>


