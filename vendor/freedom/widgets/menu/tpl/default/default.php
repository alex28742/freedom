<li>
    <a href="?id=<?=$id;?>">
        <?=$category['title'];?>

    </a>
    <? if(isset($category['childs'])): ?>
        <ul>
            <?= $this->getMenuHtml($category['childs']); ?>
        </ul>
    <? endif; ?>
</li>