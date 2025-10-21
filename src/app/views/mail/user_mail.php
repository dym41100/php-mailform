<?= htmlspecialchars($name ?? '', ENT_QUOTES, 'UTF-8') ?> 様

この度はお問い合わせいただき、誠にありがとうございます。
以下の内容で受け付けいたしました。

＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
【お名前】 <?= htmlspecialchars($name ?? '', ENT_QUOTES, 'UTF-8') . PHP_EOL ?>
【メールアドレス】 <?= htmlspecialchars($email ?? '', ENT_QUOTES, 'UTF-8') . PHP_EOL ?>
【会社名】 <?= htmlspecialchars($company ?? '', ENT_QUOTES, 'UTF-8') . PHP_EOL ?>
【住所】 〒<?= htmlspecialchars($zip ?? '', ENT_QUOTES, 'UTF-8') ?> <?= htmlspecialchars($address ?? '', ENT_QUOTES, 'UTF-8') . PHP_EOL ?>
【電話番号】 <?= htmlspecialchars($tel ?? '', ENT_QUOTES, 'UTF-8') . PHP_EOL ?>
【お問い合わせ内容】
<?= htmlspecialchars($inquiry ?? '', ENT_QUOTES, 'UTF-8') . PHP_EOL ?>
＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝

担当者より折り返しご連絡いたします。
今しばらくお待ちください。

-----------------------------------
株式会社〇〇〇〇
info@yourcompany.com
-----------------------------------
