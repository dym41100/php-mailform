<?php

namespace App\Controllers;

use App\Models\FormModel;
use App\Core\Session;
use Exception;
use RuntimeException;

class FormController
{
    private Session $session;

    public function __construct(?Session $session = null)
    {
        $this->session = $session ?? new Session();
    }

    /**
     * 共通データを生成
     * @return array< string, mixed>
     */
    private function prepareData(): array
    {
        $csrf_token = Session::generateToken();
        $data = $_POST ?: ($_SESSION['form_data'] ?? []);
        return compact('csrf_token', 'data');
    }

    /**
     * 共通ビュー読み込みメソッド
     * @param array<string, mixed> $vars
     */
    private function render(string $view, array $vars): void
    {
        extract($vars);
        include __DIR__ . '/../views/' . $view . '.php';
    }

    /** CSRFトークン検証 */
    private function validateCsrf(): void
    {
        try {
            $this->session->validateToken((string)($_POST['csrf_token'] ?? ''));
        } catch (Exception $e) {
            throw new RuntimeException('不正なアクセスが検出されました。', 0, $e);
        }
    }

    /** 入力画面 */
    public function input(): void
    {
        $vars = $this->prepareData();
        $this->render('form_input', [
            'csrf_token' => $vars['csrf_token'],
            'data' => $vars['data'],
            'errors' => [],
        ]);
    }

    /** 確認画面 */
    public function confirm(): void
    {
        $this->validateCsrf();
        $model = new FormModel();
        $errors = $model->validate($_POST);

        $vars = $this->prepareData();
        $_SESSION['form_data'] = $vars['data'];

        if (!empty($errors)) {
            $this->render('form_input', [
                'csrf_token' => $vars['csrf_token'],
                'data' => $vars['data'],
                'errors' => $errors,
            ]);
            return; // ← else削除のため早期return
        }
        $this->render('form_confirm', [
                'csrf_token' => $vars['csrf_token'],
                'data' => $vars['data'],
        ]);
    }

    /** 送信処理 */
    public function send(): void
    {
        $this->validateCsrf();

        $data = $_SESSION['form_data'] ?? null;
        if (!$data) {
            header('Location: ?action=input');
            return;
        }

        $model = new FormModel();
        $model->sendMail($data);
        $model->saveCsv($data);

        unset($_SESSION['form_data']);
        $vars = $this->prepareData();
        $this->render('form_complete', [
            'csrf_token' => $vars['csrf_token'],
        ]);
    }
}
