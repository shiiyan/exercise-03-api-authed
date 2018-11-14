課題１のAPIにトークン認証の機能を追加しました。認証用のトークンは課題２のOauth認証後にプロファイルの画面に表示します。


## 注意事項
1. `config/auth.php`にGitHubより発行されたCLIENT_IDとCLIENT_SECRETとJWT_SECRETを入れる必要があります。

2. データベースとテーブル等は課題１と２の`README.md`を参照してください。
3. Sign up機能がないため、プロファイルを表示する為には、予めユザーのデータをデータベースにInsertしてください。
4. APIリクエストの時に課題１の説明以外に、取得したBearer TokenをAuthorizationへーダーに含む必要があります。例：
```
curl -H "Authorization: Bearer <BEARER_TOKEN> ..."
```
5. トークンの有効期間は発行の時から２分となります。
