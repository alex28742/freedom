<select name="lang" id="lang">
    <option value="<?=$this->language['code'] ?>"><?=$this->language['title'] ?></option>
    <? foreach ($this->languages as $key => $val): ?>
        // пропускаем базовый язык (установленный по-умолчанию)
        <? if($this->language['code'] !== $key): ?>
            <option value="<?=$key?>"><?=$val['title']?></option>
        <? endif;?>
    <? endforeach; ?>
</select>
