# 📬 PHP Contact Form (Docker + MailHog)
Docker 上で動作する PHP のお問い合わせフォームです。 
PHPのオブジェクト指向構成を意識し、CSRF対策・バリデーション・自動返信メール機能を実装しています。 
本フォームでは、MVC構成とCSRF対策、Dockerによる環境統一を意識しました。
自動返信・管理者通知メール機能を分離し、テンプレートとして再利用可能にしています。
---

## 🧰 使用技術

- PHP 8.3 / Apache
- Docker Compose
- MailHog（メールテスト）
- Bootstrap 5
- jQuery Validation Plugin

## 🚀 概要主な機能
- 入力フォーム
- 入力値のバリデーション
- 確認画面
- 自動返信メール送信
- 入力内容のCSV保存
- CSRF対策（トークン検証）

---


### 🔧 起動手順
```bash
git clone https://github.com/<yourname>/php-mailform.git
cd php-mailform
docker compose up --build
```

---

### 🌐 アクセスURL
| 内容         | URL                                              |
| ---------- | ------------------------------------------------ |
| アプリ本体      | [http://localhost:50080](http://localhost:50080) |
| MailHog UI | [http://localhost:8025](http://localhost:8025)   |

---

### 📁 ディレクトリ構成
php-mailform/
├── docker/
│   └── app/
│       ├── Dockerfile
│       ├── php.ini
│       └── xdebug.ini
├── src/
│   └── app/
│       ├── core/          # Router / Session管理
│       ├── controllers/   # FormController
│       ├── models/        # FormModel（バリデーション・メール・CSV保存）
│       ├── views/         # 各画面（入力・確認・完了）
│       └── public/        # 公開ディレクトリ（index.php, CSS, JS）
├── docker-compose.yml
├── .gitignore
└── README.md


### 📨 メール送信（MailHogを利用）
本番用SMTPサーバではなく、MailHogに送信されます。
ブラウザで以下を開くと、送信メールを確認できます


### 🧾 CSV保存について
送信データは app/storage/orders.csv に自動追記されます。
（storage/ フォルダは .gitignore に登録済み）

---

### 👨‍💻 作者
Name: Takumi Sasamoto
GitHub: https://github.com/dym41100
Email: 218475824+dym41100@users.noreply.github.com

### ✅ ライセンス
MIT License
自由にクローン・改変・利用可能です。

---

