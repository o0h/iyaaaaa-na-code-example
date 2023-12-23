<?= json_encode(['user' => $me], JSON_UNESCAPED_UNICODE) ?>
<ol>
    <?php foreach ($ranking as $row): ?>
        <li><?= json_encode($row, JSON_UNESCAPED_UNICODE) ?></li>
    <?php endforeach;?>
</ol>
