これはログイン、ログアウト機能を実装したデモアプリです。ログイン機能はGitHubのOauth APIを使って実現したものです。


## 注意事項
1. auth.phpにGitHubより発行されたCLIENT_IDとCLIENT_SECRETを入れる必要があります。

2. SQLサーバにmyusersというデータベースとusersテーブルを準備する必要があります。
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
3. Sign up機能がないため、プロファイルを表示する為には改めてユザーのデータをデータベースにInsertしてください。
