<label>
    <input type='checkbox'
           name='banner-show-all'
           <?php if (isset($_REQUEST['banner-show-all'])) echo 'checked' ?>>
    게시 기간 지난 배너 포함
</label>
<select name='filter-by-banner-position'>
    <option value='0'>모든 위치</option>
    <?php foreach ($this->labels as $v => $label): ?>
        <option value="<?= $v ?>"
                <?= isset($_REQUEST['filter-by-banner-position']) && $_REQUEST['filter-by-banner-position'] == $v ? 'selected' : '' ?>>
                <?= $label ?>
        </option>
    <?php endforeach; ?>
</select>
