新しいお問い合わせがありました。

＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
【お名前】 <?= htmlspecialchars($name ?? '', ENT_QUOTES, 'UTF-8') . PHP_EOL ?>
【メールアドレス】 <?= htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8') . PHP_EOL ?>
【会社名】 <?= htmlspecialchars($company ?? '', ENT_QUOTES, 'UTF-8') . PHP_EOL ?>
【住所】 〒<?= htmlspecialchars($zip ?? '', ENT_QUOTES, 'UTF-8') ?> <?= htmlspecialchars($address ?? '', ENT_QUOTES, 'UTF-8') . PHP_EOL ?>
【電話番号】 <?= htmlspecialchars($tel ?? '', ENT_QUOTES, 'UTF-8') . PHP_EOL ?>
【お問い合わせ内容】
<?= htmlspecialchars($inquiry ?? '', ENT_QUOTES, 'UTF-8') . PHP_EOL ?>
＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
