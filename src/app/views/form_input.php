<?php
/** @var string $csrf_token */
/** @var array<string, string> $errors */
$errors = $errors ?? [];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせフォーム</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<div class="form-card">
    <?php if (!empty($errors)) : ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $message) : ?>
                    <li><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <h1 class="form-title">お問い合わせフォーム</h1>
    <form id="contact-form" class="h-adr" action="?action=confirm" method="post" novalidate>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" class="p-country-name" value="Japan">
        <div class="mb-3">
            <label for="name" class="form-label">お名前 <span class="text-danger">*</span></label>
            <input type="text" class="form-control required" id="name" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" data-error_place="#nameError"><span id="nameError"></span>
        </div>
        <div class="mb-3">
            <label for="company" class="form-label">会社名</label>
            <input type="text" class="form-control" id="company" name="company" value="<?= htmlspecialchars($_POST['company'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">メールアドレス <span class="text-danger">*</span></label>
            <input type="email" class="form-control required" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" data-error_place="#emailError"><span id="emailError"></span>
        </div>
        <div class="mb-3">
            <label for="zip" class="form-label">郵便番号(半角英数)</label>
            <input type="text" class="form-control p-postal-code" id="zip" name="zip" placeholder="例：123-4567" size="8" maxlength="8" value="<?= htmlspecialchars($_POST['zip'] ?? '', ENT_QUOTES, 'UTF-8') ?>" data-error_place="#zipError"><span id="zipError"></span>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">住所</label>
            <input type="text" class="form-control p-region p-locality p-street-address p-extended-address" id="address" name="address" value="<?= htmlspecialchars($_POST['address'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>
        <div class="mb-3">
            <label for="tel" class="form-label">電話番号(半角英数)</label>
            <input type="text" class="form-control" id="tel" name="tel" placeholder="例：090-1234-5678" value="<?= htmlspecialchars($_POST['tel'] ?? '', ENT_QUOTES, 'UTF-8') ?>" data-error_place="#telError"><span id="telError"></span>
        </div>
        <div class="mb-3">
            <label for="inquiry" class="form-label">お問い合わせ内容 <span class="text-danger">*</span></label>
            <textarea class="form-control required" id="inquiry-text" name="inquiry" rows="4" data-error_place="#inquiryError"><?= htmlspecialchars($_POST['inquiry'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea><span id="inquiryError"></span>
        </div>
        <div class="row justify-content-around">
            <button type="reset" class="btn col-5 btn-secondary py-2">リセット</button>
            <button type="submit" class="btn col-5 btn-primary py-2">確認画面へ進む</button>
        </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/localization/messages_ja.min.js"></script>
<script src="/js/validate.js"></script>
<script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
</body>
</html>
