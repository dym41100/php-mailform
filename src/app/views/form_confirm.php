<?php
/** @var array $data 入力データ（$_SESSION['form_data']に保存されている想定） */
/** @var string $csrf_token CSRFトークン */

$data = $_SESSION['form_data'] ?? [];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>確認画面</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>
  <div class="form-card">
    <h1 class="form-title">入力内容の確認</h1>
    <p>以下の内容でよろしければ「送信する」をクリックしてください。</p>
    <table class="w-100 mb-3">
      <tr><th class="col-4 py-2">お名前</th><td><?= htmlspecialchars($data['name'] ?? '', ENT_QUOTES, 'UTF-8') ?></td></tr>
      <tr><th class="col-4 py-2">メールアドレス</th><td><?= htmlspecialchars($data['email'] ?? '', ENT_QUOTES, 'UTF-8') ?></td></tr>
      <tr><th class="col-4 py-2">会社名</th><td><?= htmlspecialchars($data['company'] ?? '', ENT_QUOTES, 'UTF-8') ?></td></tr>
      <tr><th class="col-4 py-2">郵便番号</th><td><?= htmlspecialchars($data['zip'] ?? '', ENT_QUOTES, 'UTF-8') ?></td></tr>
      <tr><th class="col-4 py-2">住所</th><td><?= htmlspecialchars($data['address'] ?? '', ENT_QUOTES, 'UTF-8') ?></td></tr>
      <tr><th class="col-4 py-2">電話番号</th><td><?= htmlspecialchars($data['tel'] ?? '', ENT_QUOTES, 'UTF-8') ?></td></tr>
      <tr><th class="col-4 py-2">お問い合わせ内容</th><td><?= htmlspecialchars($data['inquiry'] ?? '', ENT_QUOTES, 'UTF-8') ?></td></tr>
    </table>

    <div class="row justify-content-around">
      <!-- 戻るボタン（入力フォームに戻る） -->
      <form action="?action=input" method="post" class="col-5 w-50">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
        <?php foreach ($data as $key => $value) : ?>
          <input type="hidden" name="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>" value="<?= htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8') ?>">
        <?php endforeach; ?>
        <button type="submit" class="btn btn-secondary w-100 py-2">修正する</button>
      </form>

      <!-- 送信ボタン（メール送信・CSV保存） -->
      <form action="?action=send" method="post" class="col-5 w-50">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
        <button type="submit" class="btn btn-primary w-100 py-2">送信する</button>
      </form>
  </div>
</div>
</body>
</html>
