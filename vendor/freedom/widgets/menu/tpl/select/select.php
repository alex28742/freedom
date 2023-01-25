<option value="<?=$id;?>">
    <?= $tab . $category['title'];?>
</option>
<? if(isset($category['childs'])): ?>
        <?php echo $this->getMenuHtml($category['childs'], '&nbsp;' . $tab . '-'); ?>
<? endif; ?>

