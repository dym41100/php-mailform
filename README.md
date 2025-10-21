## PHP Contact Form (Docker + MailHog)
Docker 上で動作する PHP のお問い合わせフォームです。 
PHPのオブジェクト指向構成を意識し、CSRF対策・バリデーション・自動返信メール機能を実装しています。 
本フォームでは、MVC構成とCSRF対策、Dockerによる環境統一を意識しました。
自動返信・管理者通知メール機能を分離し、テンプレートとして再利用可能にしています。

## Overview
Docker 上で動作するお問い合わせフォームです。  
以下の特徴を持っています：

- **MVC 構成**による保守性の高い設計  
- **CSRF対策**（トークン検証）によるセキュリティ強化  
- **自動返信メール**と**管理者通知メール**の分離設計  
- **テンプレート再利用可能**な構造  
- **CSV保存機能**による送信履歴の管理  

## 使用技術

| Category | Technology |
|-----------|-------------|
| Language  | PHP 8.3 |
| Environment | Docker Compose |
| Mail Testing | MailHog |
| Frontend | Bootstrap 5 / jQuery Validation Plugin |
| Server | Apache |

## 機能一覧
-  入力フォーム
-  入力値バリデーション
-  確認画面
-  自動返信・管理者通知メール
-  CSV保存機能
-  CSRF対策


## 起動手順 / How to Run

```bash
git clone git@github.com:dym41100/php-mailform.git
cd php-mailform
docker compose up --build
```

## アクセスURL
| 内容         | URL                                              |
| ---------- | ------------------------------------------------ |
| アプリ本体      | [http://localhost:50080](http://localhost:50080) |
| MailHog UI | [http://localhost:8025](http://localhost:8025)   |

## ディレクトリ構成
php-mailform/  
├── docker/  
│   └── app/  
│       ├── Dockerfile  
│       ├── php.ini  
│       └── xdebug.ini  
├── src/  
│   └── app/  
│       ├── core/          # Router / Session 管理  
│       ├── controllers/   # FormController  
│       ├── models/        # FormModel（バリデーション・メール・CSV保存）  
│       ├── views/         # 入力・確認・完了画面  
│       └── public/        # index.php, CSS, JS  
├── docker-compose.yml  
├── .gitignore  
└── README.md  



## メール送信（MailHogを利用）
本番用SMTPサーバではなく、MailHogに送信されます。
ブラウザで以下を開くと、送信メールを確認できます


## CSV保存について
送信データは app/storage/orders.csv に自動追記されます。
（storage/ フォルダは .gitignore に登録済み）

---

### 作者
Name: Takumi Sasamoto  
GitHub: https://github.com/dym41100  
Email: 218475824+dym41100@users.noreply.github.com  

### ライセンス
MIT License  
自由にクローン・改変・利用可能です。  

---

