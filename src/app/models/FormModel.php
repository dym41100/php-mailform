<?php

namespace App\Models;

use RuntimeException;
use Throwable;

class FormModel
{
    /**
     * 入力データを検証する
     *
     * @param array<string, string> $data
     * @return array<string, string> エラーメッセージ配列（キー：項目名）
     */
    public function validate(array $data): array
    {
        $errors = [];

        if (empty($data['name'])) {
            $errors['name'] = 'お名前を入力してください。';
        }
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = '有効なメールアドレスを入力してください。';
        }
        if (empty($data['inquiry'])) {
            $errors['inquiry'] = 'お問い合わせ内容を入力してください。';
        }

        return $errors;
    }

    /**
     * メール送信（ユーザー + 管理者）
     *
     * @param array<string, string> $data
     * @return bool
     */
    public function sendMail(array $data): bool
    {
        mb_language('Japanese');
        mb_internal_encoding('UTF-8');

        $sentUser  = $this->sendUserMail($data);
        $sentAdmin = $this->sendAdminMail($data);

        return $sentUser && $sentAdmin;
    }

    /**
     * ユーザー宛メール送信
     *
     * @param array<string, string> $data
     * @return bool
     */
    private function sendUserMail(array $data): bool
    {
        $to = $data['email'] ?? '';
        if ($to === '' || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
            error_log('sendUserMail: invalid user email');
            return false;
        }

        $subject = '【自動返信】お問い合わせありがとうございます';
        $headers = $this->buildHeaders();

        try {
            $body = $this->renderMailTemplate(__DIR__ . '/../views/mail/user_mail.php', $data);
            return mb_send_mail($to, $subject, $body, $headers);
        } catch (Throwable $e) {
            error_log('sendUserMail: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * 管理者宛メール送信
     *
     * @param array<string, string> $data
     * @return bool
     */
    private function sendAdminMail(array $data): bool
    {
        $to = 'info@yourcompany.com';
        $subject = '【通知】新しいお問い合わせがありました';
        $headers = $this->buildHeaders();

        try {
            $body = $this->renderMailTemplate(__DIR__ . '/../views/mail/admin_mail.php', $data);
            return mb_send_mail($to, $subject, $body, $headers);
        } catch (Throwable $e) {
            error_log('sendAdminMail: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * 共通メールヘッダ作成
     *
     * @return string
     */
    private function buildHeaders(): string
    {
        return implode("\r\n", [
            'From: info@yourcompany.com',
            'Content-Type: text/plain; charset=UTF-8',
            'Content-Transfer-Encoding: 8bit',
        ]);
    }

    /**
     * メールテンプレートを読み込み、変数を展開して返す
     *
     * @param string $templatePath
     * @param array<string, mixed> $data
     * @return string
     */
    private function renderMailTemplate(string $templatePath, array $data): string
    {
        if (!is_file($templatePath) || !is_readable($templatePath)) {
            throw new RuntimeException("テンプレートが見つかりません: {$templatePath}");
        }

        // テンプレート側で $name 等を参照できるように展開
        extract($data, EXTR_SKIP);

        ob_start();
        include $templatePath;
        $body = (string) ob_get_clean();

        // メール本文は必ずCRLFを \n に統一（mb_send_mail で扱いやすく）
        $body = str_replace(["\r\n", "\r"], "\n", $body);

        return $body;
    }

    /**
     * 入力内容をCSVに保存する
     *
     * @param array<string, string> $data
     * @throws RuntimeException 書き込み失敗時
     */
    public function saveCsv(array $data): void
    {
        $dir = dirname(__DIR__) . '/storage';
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0777, true) && !is_dir($dir)) {
                throw new RuntimeException("ディレクトリ作成に失敗しました: {$dir}");
            }
        }

        $csvFile = $dir . '/orders.csv';

        // ファイルを追記モードで開く
        $fp = fopen($csvFile, 'a');
        if ($fp === false) {
            throw new RuntimeException("CSVファイルを開けませんでした: {$csvFile}");
        }

        // 新規ファイルなら BOM（Excel対応）とヘッダー行を追加
        if (filesize($csvFile) === 0) {
            // Shift-JIS でも文字化けしないよう BOM を出力
            fwrite($fp, "\xEF\xBB\xBF"); // UTF-8 BOM（Excel対応用）

            $header = [
                '日時',
                'お名前',
                'メールアドレス',
                '会社名',
                '郵便番号',
                '住所',
                '電話番号',
                'お問い合わせ内容',
            ];
            $encodedHeader = array_map(
                static fn(string $v): string => mb_convert_encoding($v, 'SJIS-win', 'UTF-8'),
                $header
            );
            // escape を空文字にしてExcelでのバックスラッシュ問題を回避
            fputcsv($fp, $encodedHeader, ',', '"', '');
        }

        // データ行
        $row = [
            date('Y-m-d H:i:s'),
            $data['name'] ?? '',
            $data['email'] ?? '',
            $data['company'] ?? '',
            $data['zip'] ?? '',
            $data['address'] ?? '',
            $data['tel'] ?? '',
            $data['inquiry'] ?? '',
        ];

        // UTF-8 → Shift-JISに変換
        $encodedRow = array_map(
            static fn(string $v): string => mb_convert_encoding($v, 'SJIS-win', 'UTF-8'),
            $row
        );

        // CSVへ追記（escape='' は PHP 8.4対応）
        $result = fputcsv($fp, $encodedRow, ',', '"', '');
        fclose($fp);

        if ($result === false) {
            throw new RuntimeException('CSVファイルへの書き込みに失敗しました。');
        }
    }
}
