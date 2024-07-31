# 祇園小箱
# 1.概要
* 大事な書類、絶対になくしたくない小物(結婚指輪などなんでもOK)を簡単に管理する事がきる。
* 今までの所持品管理アプリのテキスト情報で保管場所を保存していているのでいざ探そうとしてもどこに置いたかわからなくなる問題を保管場所の登録方法をかえて解決！
* レスポンシブ対応済みでスマホからの利用をお勧めします。
## 解決方法

# 2.開発背景
ふるさと納税を申し込んでいて税金の控除などの申請にひつようなワンストップ特例制度の書類がみつからず申込期限内に発送できなかった事をきっかけにこのような書類の紛失やどこに置いたかわからなくなる問題を解決するアプリケーションを作ろうと思いました。
使いづらいと継続利用しなくなると思うので操作が直感的にに出来るように登録は簡単に出来て、説明をみなくても利用できる簡単な設計を意識して開発しました。
# 3.開発で工夫したポイント
* 現存している持ち物管理アプリはひとつのアイテムを登録するのに記入する項目おおくて登録するのが大変だと思いました。そこで簡単に登録できるように登録作業の一部を自動化しました。
* 触っていて楽しいUI/UX体験ができるようにUIで様々な機能を提供。
# auto start settings, optional.
mkdir -p ~/Library/LaunchAgents
ln -sfv /usr/local/opt/memcached/*.plist ~/Library/LaunchAgents
launchctl load ~/Library/LaunchAgents/homebrew.mxcl.memcached.plist

# check
telnet localhost 11211
Next, you need to install ElasticSearch (for full text search).

# Download ElasticSearch's newest zip file from download page.
# https://www.elastic.co/downloads/elasticsearch

# And unzip it under `~/tools` directory. (Assume that you downloaded version 2.3.2)

# if you want to use Japanese, install kuromoji plugin
~/tools/elasticsearch-2.3.2/bin/plugin install analysis-kuromoji

# edit config file
vi ~/tools/elasticsearch-2.3.2/config/elasticsearch.yml

  # use unique cluster name
  cluster.name: kenta.katsumata

# start in the background
~/tools/elasticsearch-2.3.2/bin/elasticsearch -d

# test
curl http://localhost:9200/
After that, you can start this app like below:

# Install dependencies
mix deps.get

# Create and migrate your database
mix ecto.create && mix ecto.migrate

# Insert initial data
mix run priv/repo/seeds.exs

# Install Node.js dependencies
npm install

# Start Phoenix endpoint
mix phoenix.server
Now you can visit localhost:4000 from your browser.

And you can login to admin page by user admin01@example.com password 1234.

Environment variables
If you want to use guardian, social login, SES email, ElasticSearch(AWS ElasticSearch Service), you need to set environment variables like below:

# ~/.bash_profile
export MEDIA_SAMPLE_GUARDIAN_SECRET_KEY=your_random_value

export MEDIA_SAMPLE_GITHUB_CLIENT_ID=your_client_id
export MEDIA_SAMPLE_GITHUB_CLIENT_SECRET=your_client_secret

export MEDIA_SAMPLE_FACEBOOK_CLIENT_ID=your_client_id
export MEDIA_SAMPLE_FACEBOOK_CLIENT_SECRET=your_client_secret

export MEDIA_SAMPLE_TWITTER_CLIENT_ID=your_client_id
export MEDIA_SAMPLE_TWITTER_CLIENT_SECRET=your_client_secret

export MEDIA_SAMPLE_EMAIL_SERVER=ses_server
export MEDIA_SAMPLE_EMAIL_USER=ses_smtp_user
export MEDIA_SAMPLE_EMAIL_PASSWORD=ses_smtp_password
export MEDIA_SAMPLE_EMAIL_SENDER=ses_email

export MEDIA_SAMPLE_ELASTICSEARCH_URL=elastic_search_url

# Following environment variables are for AWS ElasticSearch Service.
# If you use local ElasticSearch, these variables are not required.
export MEDIA_SAMPLE_ELASTICSEARCH_ACCESS_KEY_ID=aws_access_key_id
export MEDIA_SAMPLE_ELASTICSEARCH_SECRET_ACCESS_KEY=aws_secret_access_key
export MEDIA_SAMPLE_ELASTICSEARCH_REGION=aws_region
And you need to load:

source ~/.bash_profile
Locale
This project supports locales en and ja (en is default), localhost:4000/en and localhost:4000/ja

If you access to localhost:4000 without specifing any locale, locale is automatically decided by your browser settings and you'll be redirected.

Initial data are only for English, if you want to make ja locale data, you need to change locale to ja and create or update record.

Create ElasticSearch Index
You can create ElasticSearch index and import data from your database like below:

# iex
MediaSample.Search.create_index
MediaSample.Search.import_documents

# compiled package
bin/media_sample rpc Elixir.MediaSample.Search create_index
bin/media_sample rpc Elixir.MediaSample.Search import_documents
MediaSample.Search.create_index/0 function do both create and delete index operation. You can call only delete index operation like below:

# iex
MediaSample.Search.delete_index

# compiled package
bin/media_sample rpc Elixir.MediaSample.Search delete_index
API
You can call some APIs like below:

# get JWT token
curl -d "email=user01%40example%2ecom&password=12345678" http://localhost:4000/en/api/v1/session/create
# => {"jwt":"hogehoge"}

# call entry save API with JWT token
curl -v -H "Authorization: Bearer hogehoge" \
-H "Accept: application/json" -H "Content-type: application/json" \
-X POST -d '{"title":"entry 01", "description":"entry 01 description", "status":1, "category_id":1, "tags":[1, 2], "sections":[{"section_type":1, "content":"section 01", "seq":1, "status":1}]}' \
http://localhost:4000/en/api/v1/mypage/entry/save

# full text search (with ElasticSearch)
curl http://localhost:4000/en/api/v1/entries/search?words=goromaru%20messi
TODO
 resolve logger problem (logger and lager)
