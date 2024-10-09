<img src="https://github.com/user-attachments/assets/56d7f82c-1afc-4058-b077-c1c14999bc72" width="500px" height="500px">


# 祇園小箱

# アプリURL
https://star-on.net/login
![リンクのタイトル](https://star-on.net/login)
# 概要
* 大事な書類、絶対になくしたくない小物(結婚指輪などなんでもOK)を簡単に管理する事がきる。
* レスポンシブ対応済みでスマホからの利用をお勧めします。
## 解決方法
* 今までの所持品管理アプリのテキスト情報で保管場所を保存していているのでいざ探そうとしてもどこに置いたかわからなくなる問題を保管場所の登録方法をかえて解決！
操作は2ステップ。
保管場所を撮影して登録
保管したい物をコメントをつけて登録
既存のアプリでは保管した部屋はわかるけどその部屋のどこに置いたかわからなくなる事が問題だと思いました。そこで所持品の登録方法を変える事でその問題を解決しました。
# 開発背景
ふるさと納税を申し込んでいて税金の控除などの申請にひつようなワンストップ特例制度の書類がみつからず申込期限内に発送できなかった事をきっかけにこのような書類の紛失やどこに置いたかわからなくなる問題を解決するアプリケーションを作ろうと思いました。
使いづらいと継続利用しなくなると思うので操作が直感的にに出来るように登録は簡単に出来て、説明をみなくても利用できる簡単な設計を意識して開発しました。

# 開発で工夫したポイント
* 現存している持ち物管理アプリはひとつのアイテムを登録するのに記入する項目おおくて登録するのが大変だと思いました。そこで簡単に登録できるように登録作業の一部を自動化しました。
* 触っていて楽しいUI/UX体験ができるようにUIで様々な機能を提供。
* 快適な体験を提供するためにページ遷移を少なくし非同期処理で対応。
* レスポンシブ対応していてスマホでも操作可能。
* 登録アイテムの名前もAIに画像認識させて入力する手間省いて快適な利用体験を提供

# 使用技術スタック
| カテゴリー|　使用技術 |
| ---- | ---- |
| フロントエンド | HTML, CSS |
| バックエンド | PHP |
| インフラ　|AWS ECS on fargate|
| データベース |RDS(mysql) |
| 開発環境 | Docker |
| CI/CD |GitHub Actions |
| デザイン |draw.io |
| etc | Git, GitHub, Gemini 1.5 Flash  |

# 機能一覧
| ログイン画面 | 
|:----------:|
| <img src="https://github.com/user-attachments/assets/046c3bc3-7ef3-4fee-8e0f-d6bbb4d99b0e" style="width:100%;"> |
| テストユーザーを作成していますので、アカウントを作成せずにアプリをご利用できます。アカウント作成ボタンを押していただけばアカウント作成画面に移動 |


| アカウント画面 | 
|:----------:|
| <img src="https://github.com/user-attachments/assets/1e1dba97-60d4-4723-96c6-478d7c040733" style="width:100%; "> | 
| アカウント登録ボタンをクリックして 名前、email、パスワードを記入していただいたらアカウント登録完了。トップページへリダイレクト |

| トップページ画面 | 
|:----------:|
| <img src="https://github.com/user-attachments/assets/9874606b-82d1-45f6-bc72-c10be5d6b350" style="width:100%; "> | 
|　部屋を登録ボタンをクリックしアイテムの置いてある部屋の画像と場所名を登録 |

| 部屋の登録（複数） | 
|:----------:|
| <img src="https://github.com/user-attachments/assets/72c294fd-8cac-448c-8345-be19128cfb02" style="width:100%; "> | 
|　部屋を登録ボタンをクリックしアイテムの置いてある部屋の画像と場所名を登録。　画面上部右にある次ページをクリックする登録してある部屋を移動できる。|

| アイテム登録 | 
|:----------:|
| <img src="https://github.com/user-attachments/assets/4f1ec3a9-e4c9-4750-aab5-2f6a16f66a09" style="width:100%; "> | 
|　アイテム登録ボタンをクリックしアイテムについてメモがあれば記入し画像を選択。アイテムの名前はgemni-flashAPIを使用して画像認識を利用して名前を取得している。変更は編集ページで可能。時間がたてばオブジェクトが出現してそれをマウスで登録したい場所へ移動できます。　|


| アイテムのアニメーション | 
|:----------:|
| <img src="https://github.com/user-attachments/assets/eaa1d8a9-6116-4da7-875d-050d98a55996" style="width:100%; "> | 
|画像左側に出現するアイテムボタンをクリックすると対象のアイテムが動くので登録したアイテムの場所が視覚的に確認できます。 |


| アイテムの編集| 
|:----------:|
| <img src="https://github.com/user-attachments/assets/6336dd9d-898c-44f2-a8f2-860ea8f68392" style="width:100%; "> | 
|アイテムをクリックすると編集ページへ移動。名前などの編集がおわったら更新をクリックしたら編集は完了です。|

| アイテムの検索| 
|:----------:|
| <img src="https://github.com/user-attachments/assets/bb49d6e5-be24-4ffb-a8a2-2cde9a389b98" style="width:100%; "> | 
|画面上部の検索バーをクリック。検索したいアイテム名を記入したらアイテム一覧画面へ移動。アイテムの場所がどこにあるか表示される。|

| アイテムを削除する| 
|:----------:|
| <img src="https://github.com/user-attachments/assets/8fdcc83a-0c2f-44d3-b14d-e1bc3fb53d91" style="width:100%; "> | 
|アイテムをドラッグしたまま画面下部左のゴミ箱のアイコンに置くとアイコンが動きアイテムの削除が完了する。|

# 使い方
ご利用中のサブスクリプションを登録することで、各サービスの課金日を自動的に管理できます。登録されたメールアドレスへ、支払日が近づいた際に通知が送信されるため、継続するサービスと解約を検討するサービスを効率的に把握・管理できます。
# 大変だった点
課金日自動通知プログラムの構築において、ローカル環境とAWS本番環境における差異に起因する課題に直面しました。特に、フレームワークの挙動に関する理解を深める必要性に迫られ、試行錯誤を重ねる中で貴重な学びを得ることができました。
ローカル環境では正常に動作していたプログラムが、AWS本番環境では期待通りに動作しないという状況に遭遇し、原因究明と解決策の探索に時間を費やしました。その過程で、フレームワークの挙動や本番環境特有の制約について理解を深め、開発スキル向上に繋がりました。
今回の経験を通して、開発環境と本番環境間の差異を意識して開発する事の重要性を改めて認識しました。

# インフラ図
 <img src="https://github.com/user-attachments/assets/82faf6ea-4493-4284-bd72-411f4642df5c" style="width:100%; ">

 # ER図
 <img src="https://github.com/user-attachments/assets/71fb07c1-0aff-4d02-8b9e-779b9318d24d" style="width:100%; ">

# 今後の展望
サブスクリプション契約時に、月額課金などの情報が自動的にアプリへ登録されるよう、自動化を実現したいと考えています。





