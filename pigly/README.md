# 体重管理アプリ「PiGLy」

体重やカロリー、運動記録を登録・管理できるアプリケーションです。
Laravelを使用し、CRUD機能を実装しています。

---

## 📌 使用技術

- PHP 8.1
- Laravel 10.x
- MySQL 8.0
- Docker / Docker Compose
- Bootstrap 5
- Vite（ビルド済み）

---

## 🔧 セットアップ手順（ローカル環境）

リポジトリをクローン

```bash
git clone https://github.com/harumizuki/pigly.git
cd pigly

Docker環境を起動
docker-compose up -d

Laravelプロジェクト内へ移動
cd src

マイグレーション実行
docker exec -it pigly-app-1 bash
php artisan migrate

フロントエンドビルド済みのため、追加のnpm操作は不要です

主な機能

機能	内容
一覧表示	登録された体重記録を一覧表示
新規登録	日付・体重・カロリー・運動情報の登録
編集機能	登録済みの記録を修正
削除機能	不要な記録を削除
バリデーション	フロント＆サーバーサイドで実施
メッセージ表示	成功時にメッセージ表示あり

![一覧画面](public/images/index_sample.png)
📝 ER図（任意）



🙋‍♂️ 作成者

harumizuki
COACHTECH 課題提出用
