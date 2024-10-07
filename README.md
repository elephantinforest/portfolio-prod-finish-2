<img src="https://github.com/user-attachments/assets/56d7f82c-1afc-4058-b077-c1c14999bc72" width="500px" height="500px">


# 祇園小箱
# 1.概要
* 大事な書類、絶対になくしたくない小物(結婚指輪などなんでもOK)を簡単に管理する事がきる。
* レスポンシブ対応済みでスマホからの利用をお勧めします。
## 解決方法
* 今までの所持品管理アプリのテキスト情報で保管場所を保存していているのでいざ探そうとしてもどこに置いたかわからなくなる問題を保管場所の登録方法をかえて解決！
操作は2ステップ。
保管場所を撮影して登録

保管したい物をコメントをつけて登録


既存のアプリでは保管した部屋はわかるけどその部屋のどこに置いたかわからなくなる事が問題だと思いました。そこで所持品の登録方法を変える事でその問題を解決しました。


# 2.開発背景
ふるさと納税を申し込んでいて税金の控除などの申請にひつようなワンストップ特例制度の書類がみつからず申込期限内に発送できなかった事をきっかけにこのような書類の紛失やどこに置いたかわからなくなる問題を解決するアプリケーションを作ろうと思いました。
使いづらいと継続利用しなくなると思うので操作が直感的にに出来るように登録は簡単に出来て、説明をみなくても利用できる簡単な設計を意識して開発しました。
# 3.開発で工夫したポイント
* 現存している持ち物管理アプリはひとつのアイテムを登録するのに記入する項目おおくて登録するのが大変だと思いました。そこで簡単に登録できるように登録作業の一部を自動化しました。
* 触っていて楽しいUI/UX体験ができるようにUIで様々な機能を提供。

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
| <img src="https://github.com/user-attachments/assets/992303fe-f088-4f86-9c50-32acbcc5f27e" style="width:100%; "> | 
| アカウント登録ボタンをクリックして 名前、email、パスワードを記入していただいたらアカウント登録完了。トップページへリダイレクト |

| トップページ画面(サブスク未登録時) | 
|:----------:|
| <img src="https://github.com/user-attachments/assets/fc2b3b50-a17f-4917-b5f8-5c499520690a" style="width:100%; "> | 
|　赤いclick hereボタンをクリックしてサブスクリプション登録画面に！　他にも登録したサブスクリプションの一覧がトップページで表示されます。 |

| サブスクリプションの登録 | 
|:----------:|
| <img src="https://github.com/user-attachments/assets/9b231801-925d-4b83-8ab8-1332a05beb07" style="width:100%; "> | 
|サブスクリプション名、月額料金、課金日、サブスクリプションサービスの内容、URLを記入しsubmitボタンをクリックして登録完了。|

| トップページ(サブスク登録時) | 
|:----------:|
| <img src="https://github.com/user-attachments/assets/cdcbf75a-2ca6-4234-9f16-bc68164c7e29" style="width:100%; "> | 
|合計金額、サブスク登録者数など表示します。社名をクリックしたらサブスク登録時のURLにアクセスできる設計になっています。|


| サブスクリプションの編集 | 
|:----------:|
| <img src="https://github.com/user-attachments/assets/680c411b-5cc7-4f6f-986b-f57672424ba8" style="width:100%; "> | 
|トップページの詳細ボタンをクリックしたら編集画面へ移動します。料金などの変更があれば訂正してeditボタンをクリックすれば編集は完了します。 |


| サブスクリプション登録解除| 
|:----------:|
| <img src="https://github.com/user-attachments/assets/680c411b-5cc7-4f6f-986b-f57672424ba8" style="width:100%; "> | 
|トップページの詳細ボタンをクリックしたら編集画面へ移動。ページ下部のdeleteボタンをクリックすれば登録解除は完了します。|

# 使い方
ご利用中のサブスクリプションを登録することで、各サービスの課金日を自動的に管理できます。登録されたメールアドレスへ、支払日が近づいた際に通知が送信されるため、継続するサービスと解約を検討するサービスを効率的に把握・管理できます。
# 大変だった点
課金日自動通知プログラムの構築において、ローカル環境とAWS本番環境における差異に起因する課題に直面しました。特に、フレームワークの挙動に関する理解を深める必要性に迫られ、試行錯誤を重ねる中で貴重な学びを得ることができました。
ローカル環境では正常に動作していたプログラムが、AWS本番環境では期待通りに動作しないという状況に遭遇し、原因究明と解決策の探索に時間を費やしました。その過程で、フレームワークの挙動や本番環境特有の制約について理解を深め、開発スキル向上に繋がりました。
今回の経験を通して、開発環境と本番環境間の差異を意識して開発する事の重要性を改めて認識しました。

# インフラ図
 <img src="https://github.com/user-attachments/assets/de3e4bb2-d440-4c88-b218-7124193d0e95" style="width:100%; ">

# 今後の展望
サブスクリプション契約時に、月額課金などの情報が自動的にアプリへ登録されるよう、自動化を実現したいと考えています。





