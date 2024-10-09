<img src="https://github.com/user-attachments/assets/56d7f82c-1afc-4058-b077-c1c14999bc72" width="500px" height="500px">


# 祇園小箱
# アプリURL
https://star-on.net/login
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
アカウントを作成します、部屋とアイテムを登録できます。部屋は画像と名前で登録し、複数の部屋を管理可能です。アイテム登録時は画像認識で名前が自動取得され、配置もドラッグで任意の配置に置けます。登録したアイテムは編集、検索が可能で、アニメーションで位置確認もできます。不要なアイテムはドラッグして削除できます。直感的な操作で家庭内の整理整頓をサポートし、大切な書類やなくしたら困るものを登録出来ます。

# 大変だった点
開発で苦労した点として、レスポンシブデザインの実装、位置情報の管理、そしてGoogleのAI APIを利用した画像認識機能がありました。
まず、アイテムの位置（X軸・Y軸）をデータベースに登録し、jQueryで動的にCSSを調整することで、ページリロード後も位置を保持する機能を実現しました。また、Jqueryを使用してページの縮尺にあわしてアイテムのサイズも小さくするのと画像の位置の調整を実装させデバイスごとに最適な表示を提供しました。
さらに、画像認識ではGoogleのAI APIを使用してアイテムの名前を自動登録する機能を実装していましたが、突然の仕様変更によりライブラリが使えなくなりました。更新がない中、自分でライブラリを編集し、新仕様に対応させたことで機能の継続を実現しました。
# インフラ図
 <img src="https://github.com/user-attachments/assets/82faf6ea-4493-4284-bd72-411f4642df5c" style="width:100%; ">

 # ER図
 <img src="https://github.com/user-attachments/assets/71fb07c1-0aff-4d02-8b9e-779b9318d24d" style="width:100%; ">

# 今後の展望
今後は、AWSにデプロイしたアプリケーションのパフォーマンスを改善しながら、テストコードの網羅性を向上させることを目指します。具体的には、テストカバレッジを計測し、未テスト部分を特定して漏れのないテストを実施します。これにより、バグの早期発見が可能になり、より安定したアプリケーションの運用が実現します。自動化されたテストの実行環境を整えることで、開発プロセスの効率化も図ります。





