`Phalcon`を使ってログイン、ログアウト機能を実装したデモアプリです。ログイン機能はGitHubのOauth API経由で実現しました。


## 注意事項
1. `config/auth.php`にGitHubより発行されたCLIENT_IDとCLIENT_SECRETを入れる必要があります。

2. SQLサーバに`myusers`というデータベースと`users`テーブルを事前に作る必要があります。
```sql
CREATE TABLE `users` (
   `id` int(11) NOT NULL AUTO_INCREMENT, 
   `github_id` int,
   `name` varchar(100) COLLATE utf8_bin DEFAULT NULL, 
   `html_url` varchar(500) COLLATE utf8_bin DEFAULT NULL, 
   `avatar_url` varchar(120) COLLATE utf8_bin DEFAULT NULL, 
   PRIMARY KEY (`id`) 
   );
```
3. Sign up機能がないため、プロファイルを表示する為には、予めユザーのデータをデータベースにInsertしてください。
