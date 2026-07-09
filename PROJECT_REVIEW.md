# PROJECT_REVIEW — sansuien テーマ 客観レビュー

- レビュー日: 2026-07-09 14:28
- 視点: 第三者の WordPress 熟練者が GitHub リポジトリを見た場合を想定
- 対象: Git 管理下のファイルのみ（`.gitignore` 対象・`.bak` は除外。ただし **コミット済みの** `.bak` は指摘対象に含める）
- 評価基準: ファイル構成／WordPress 慣習・命名規則／**クライアントが編集しやすい管理画面を構成できているか**（最重視・厳しめ）

---

## 対応状況（2026-07-09 追記）

§1-1 〜 §2-7（本文118行目まで）の指摘は以下のとおり対応済み。

- [x] §1-1 客室・お問い合わせページの ACF location（`theme_acf_page_location()` を新設し `page` location で解決。bootstrap に room/contact ページ定義を追加）
- [x] §1-2 プライバシーポリシー本文（`theme_option_rich()` を新設し Options を参照するよう修正）
- [x] §1-3 `theme_option()` の ACF 無効時 fallback キー（`options_` 接頭辞を付与）
- [x] §1-4 ヒーロー内お知らせリンク（`news_external_url` / 個別記事へのリンクに対応）
- [x] §1-5 `/news/` の受けテンプレート（`category-news.php` を新設）
- [x] §2-1 `header.php` / `footer.php` へ site-header・reserve-tab・site-footer を集約し、各エントリーテンプレートの重複呼び出しを削除
- [x] §2-2 `404.php` を新設、`index.php` を通常ループの fallback に是正
- [x] §2-3 `page-templates/top.php` の重複を削除、bootstrap の front page 定義を修正
- [x] §2-4 Example 残骸（`page-templates/example.php` / `template-parts/example/example.php` / `template-parts/front/example.php`）を削除。**`docs/theme.example.bak` は AGENTS.md の「.bak は読込・編集・削除しない」ルールにより意図的に対象外**
- [x] §2-5 `bootstrap.md`（無関係な内容）を削除ではなく `.private/`（新規・gitignore 対象）へ退避。README.md / docs/sansuien.md / DEPLOYMENT.md / `.env.deploy.example` から SSH host・user・port・サーバー絶対パス等の実値を除去し `.env.deploy` 参照に統一。**デプロイ入口3つの統合は未実施**（リスクが高いため見送り）
- [x] §2-6 `<main>` ランドマークを front-page / page-room / page-contact / single / category-room / category-news / index / 404 に追加。下層ページの主見出しを `h2` → `h1` に統一
- [x] §2-7 `the_custom_logo()` を実装（`has_custom_logo()` 判定でロゴ画像 or テキストブランドへフォールバック）
- [x] §3 命名規則: i18n（gettext）方針を明確化。`THEME_GETTEXT_DOMAIN` 定数・`__()`/`_e()`/`esc_html__()` 等を全廃し、日本語リテラル + plain escaping に統一（本サイトは翻訳予定がなく、WP i18n 抽出ツールがリテラルドメイン文字列を要求する制約と「`sansuien` を命名で使わない」というユーザー方針が両立しないため）。ユーザー指示により `sansuien` の使用箇所も最小化：`assets/js/sansuien.js` → `theme.js` にリネーム。残る使用箇所は style.css のテーマヘッダー（`Theme Name` / `Text Domain`、WordPress規約上必須）と `tools-domain/bootstrap-site.example.php` の `theme_slug`（デプロイ先スラッグの実値）のみ
- [x] §4-2-4 フロントページの本文エディタ非表示化（`group_theme_page_front` に `hide_on_screen: ['the_content']` を追加）
- [x] §4-2-5 CF7 フォームのID参照化（Options に `shop_contact_form_id` を追加。未設定時のみタイトル検索へ fallback）
- [x] §4-2-6 デモコンテンツの一元化（新設 `inc/demo-content.php` の `theme_demo_content()` を単一の情報源とし、ACF `default_value` / テンプレート fallback / bootstrap seed 値の3箇所が同じ関数を参照するよう統一。副産物として `shop_contact_url` のデフォルト値が `'#'` と `'#reserve'` で食い違っていた既存の drift も解消）
- [x] §4-2-1 / §4-2-3 ギャラリー・お客様の声のハードコード解消、`room_gallery` 固定4枠の解消。ユーザー確認の結果 **Secure Custom Fields（無料）採用が確定**したため、`front_gallery_images`（Gallery）・`front_voices`（Repeater）を新設し、`room_gallery` / `page_room_gallery` を固定4枠の image フィールドから枚数自由の Gallery フィールドへ統合。`inc/template-tags.php` に `theme_gallery_images()` / `theme_content_gallery_images()` を追加し、SCF/ACF PRO 未導入でも fatal error にならずデモ内容へフォールバックするよう実装
- [x] §4-2-2 客室の管理方式はユーザー確認の結果、**カテゴリー方式を維持し、無料の並び順プラグイン（Simple/Intuitive Custom Post Order）を追加する方針が確定**（CPT化は過去に一度差し戻された経緯があるため見送り）。表示側の `theme_get_content_posts()` は既に `menu_order` 順でクエリしているため、テーマ側の追加実装は不要。**ユーザーが Secure Custom Fields と Simple Custom Post Order を実際にインストール・有効化済み**
- [x] §4-2-7 `page_room_tags` / `room_tags` に「どこに・どう表示されるか」の `instructions` を追加（カンマ区切りのまま、無料版で現実的な改善に留める）
- [x] §4-3 投稿一覧の視認性（サムネイル・料金列）を `inc/setup.php`（`theme_posts_list_columns()`）でプラグイン無しに実装。並び順・Gallery/Repeaterは §4-2-1/2/3 の対応と同じくユーザーがプラグイン導入済み。フォームIDは §4-2-5 で対応済み。**SEO/OGP（SEO SIMPLE PACK 等）は未導入・ユーザー判断待ち**（チャットで確認中）
- [x] §5 ドキュメント整合性: README.md / docs/sansuien.md / docs/archive-cpt-acf-decision.md / PLAN-SANSUIEN.md の CPT 時代の記述（`archive-room.php` / `single-room.php` / `inc/cpt.php` 等、実在しないファイル名）を現行アーキテクチャ（標準投稿+カテゴリー、`category-room.php` 等）へ全面更新。**副次的に発見**: `PLAN-SANSUIEN.md` に SSH host/user/port・サーバー絶対パス・本番公開URLが平文で残っていたため、他の文書と同様に `.env.deploy` 参照へ伏せ字化した（§2-5 の是正漏れ）

検証: `php -l` 全ファイル通過、`tests/run.php` 8/8 パス、変更ファイルの phpcs 差分は新規追加コード起因のもの（`index.php`）のみ修正し、ファイル全体の既存 phpcs 負債（日本語コメントの句点欠如等）は本タスクの範囲外として未着手。

---

## 総評

| 観点 | 評価 | 一言 |
| --- | --- | --- |
| セキュリティ規律（エスケープ・fallback） | ★★★★☆ | 用途別エスケープ・ACF無効時フェイルセーフは高水準 |
| ファイル構成・テンプレート階層 | ★★☆☆☆ | `get_header()` の役割分割が独自流。標準テンプレート不足 |
| 命名規則 | ★★★☆☆ | 概ね良好だが i18n が中途半端 |
| ドキュメントと実装の一致 | ★☆☆☆☆ | README / docs が旧アーキテクチャ（CPT）のまま。第一印象を大きく損なう |
| 管理画面の編集体験（本題） | ★★☆☆☆ | 骨格（Options Page・タブUI）は良いが、**編集できない/効かない箇所が複数あり、クライアント運用に耐えない** |

エスケープ規律・ACF/CF7 無効時のフェイルセーフ・非破壊 bootstrap という「壊れないための土台」は熟練者が見ても評価できる水準にある。一方で、**「管理画面から編集できると謳っている項目が実際には表示されない・反映されない」不具合級の問題が2件**あり、ドキュメントが実装と乖離しているため、第三者は「丁寧に作られているが、最後の検証と整理が済んでいないリポジトリ」という印象を持つ。

---

## 1. 不具合レベルの問題（管理画面が機能しない系・最優先）

### 1-1.【重大】客室・お問い合わせ固定ページの ACF フィールドグループが管理画面に表示されない（可能性が極めて高い）

`inc/acf-pages.php` の `group_theme_page_room` / `group_theme_page_contact` の location は次の通り。

```php
'param' => 'page_template', 'operator' => '==', 'value' => 'page-room.php'
```

しかし `page-room.php` / `page-contact.php` は **`Template Name:` ヘッダーを持たないスラッグ一致テンプレート**（`page-{slug}.php`）であり、テンプレート階層で自動適用されるだけで、`_wp_page_template` メタには何も保存されない。ACF の `page_template` ルールは `get_page_template_slug()`（= `_wp_page_template` メタ）と比較するため、**このルールは永遠に成立しない**。

さらに `tools-domain/bootstrap-site.example.php` の `pages` 配列は空（コメントに「追加の固定ページを使わない」と旧方針の記述が残存）で、room / contact ページの作成もテンプレートメタの付与も行っていない。フロント表示はスラッグ解決＋テンプレート側 fallback 値で成立してしまうため、**「表示は正常だが、クライアントは客室ページ・お問い合わせページの編集項目を一切触れない」状態**になっている可能性が高い。

**修正案（いずれか）:**
- location を `page`（ID またはページ指定）に変更する。ページ ID は bootstrap で作成したものを option に控えるか、`page_path` 相当のカスタム location ルールを使う
- `page-room.php` / `page-contact.php` に `Template Name:` を付けて `page-templates/` に移し、bootstrap で `_wp_page_template` を付与する（`top.php` と同じ方式に統一）

### 1-2.【重大】プライバシーポリシー本文（ACF Options の WYSIWYG）が編集しても反映されない

`shop_privacy_policy_content` は **Options Page** に登録されているが、出力側の `template-parts/site-footer.php:37` は

```php
theme_rich( 'shop_privacy_policy_content', theme_default_privacy_policy_content() );
```

を呼んでおり、`theme_rich()` → `theme_meta()` は **現在の投稿の投稿メタ** を参照する。Options に保存した値は読まれず、常にテーマ内蔵の標準文面が表示される。`theme_option()` を経由するリッチテキスト出力関数（例: `theme_option_rich()`）が必要。

### 1-3.【中】ACF 無効時、共通設定（宿泊施設共通情報）の fallback が読む option キーが誤り

`inc/template-tags.php` の `theme_option()` は ACF 無効時に `get_option( $field_name )` を読むが、ACF Options Page の値は `options_{$field_name}` というキーで `wp_options` に保存される。したがって **ACF を停止すると、クライアントが入力済みの施設名・電話番号等がすべてコード内の既定値に戻る**。「ACF 無効時に fatal error を起こさない」というテーマの設計目標は満たしているが、「入力値が保持される」という期待には応えていない。`get_option( 'options_' . $field_name )` を先に見るべき。

### 1-4.【小】トップページのヒーロー内お知らせリンクが個別記事へ飛ばない

`template-parts/front/hero.php:28` — 最新お知らせのリンク先が `get_permalink()` ではなく `home_url( '/#news' )` 固定。外部 URL メタ（`news_external_url`）も無視される。

### 1-5.【小】`/news/` リライトルールを追加したのに、受けるテンプレートが実質「404 文言」

`inc/setup.php` で `^news/?$` → カテゴリーアーカイブのルールと `category_link` フィルタを丁寧に整備しているのに、`category.php` / `archive.php` が存在しないため `/news/` は `index.php` に落ち、「ページが見つかりませんでした」という**エラー文言付きの画面**が表示される。リンク生成側（`theme_category_url('news')`）を使う導線が現状ないため顕在化していないが、URL としては到達可能。`category.php`（または `category-news.php`）を用意するか、ルール自体を撤去して整合を取るべき。

---

## 2. ファイル構成・テンプレート階層（WordPress 慣習の観点）

### 2-1.【重要】`header.php` / `footer.php` がほぼ空で、サイトヘッダー・フッターを各テンプレートが手動で呼ぶ構成

WordPress の慣習では `get_header()` がサイトヘッダー（ロゴ・ナビ）まで出力する。本テーマは `header.php` が `<head>` と SVG シンボルのみで、各テンプレートが

```php
get_header();
get_template_part( 'template-parts/site-header' );
get_template_part( 'template-parts/reserve-tab' );
...
get_template_part( 'template-parts/site-footer' );
get_footer();
```

という 4〜5 行の決まり文句を毎回書く。この構成の実害が既に出ている：

- **`page.php` と `index.php` は site-header / reserve-tab / site-footer を呼んでいない。** つまりクライアントが管理画面から普通に固定ページ（例: 会社概要、プライバシーポリシーの独立ページ）を追加すると、**グローバルナビもフッターも予約タブもないページ**が公開される。「後々ページが増えることを考慮」という設計意図と正面から矛盾する、構成上最大の欠陥。
- 今後テンプレートを増やすたびに呼び忘れリスクを抱え続ける。

`site-header.php` の読み込みを `header.php` 内へ、`site-footer.php`（と reserve-tab）を `footer.php` 内へ移すのが標準解。ページ種別で出し分けたい場合も条件分岐を `header.php` / `footer.php` 側に置くほうが安全。

### 2-2. 標準テンプレートの不足と `index.php` の役割違反

- `404.php` がなく、`index.php` が「ページが見つかりませんでした」を表示している。`index.php` は最後の汎用 fallback（通常はループ）であり、404 文言を出すのは `404.php` の役割。検索結果（`search.php` 不在）やアーカイブ全般も同じ「見つかりません」画面に落ちる。
- `index.php` 冒頭の `require front-page.php` は動くが異例。front-page 表示は WordPress のテンプレート階層に任せれば済み、熟練者には「テンプレート階層を信頼していない」ように映る。

### 2-3. `front-page.php` と `page-templates/top.php` の完全重複

中身が同一の 2 ファイル。bootstrap は `top.php` をページに割り当てるが、フロントページに設定されれば `front-page.php` が優先されるため `top.php` はほぼデッドコード。管理画面のテンプレート選択肢にも「Top」が出てクライアントを迷わせる。`front-page.php` に一本化すべき。

### 2-4. Example 残骸が実案件テーマに残っている

- `page-templates/example.php` は **存在しない** `template-parts/example-page-content.php` を参照（`get_template_part` は無言で失敗）。しかも `Template Name: Example` により**クライアントの管理画面のテンプレート選択に「Example」が表示される**。
- `template-parts/example/example.php`、`template-parts/front/example.php` も未使用。
- `docs/theme.example.bak` が **コミットされている**（`.bak` をリポジトリに含めるのは第三者視点で不可解）。

AGENTS.md 自身が「Example を案件値へ置換する」と定めており、規約と実態の不一致として目立つ。デプロイ除外されているとしても、GitHub を見る第三者には未整理の印象を与える。

### 2-5. ルート直下の開発メタファイル過多と情報公開

テーマのルートに `PLAN-SANSUIEN.md`、`bootstrap.md`（中身は **Bootstrap CSS のユーティリティクラスのメモ**でプロジェクト無関係）、`AGENTS.md`、`AGENTS_TEMPLATE.md`、`CLAUDE.md`、`deploy.sh` ＋ `tools/deploy.sh` ＋ `tools-domain/deploy-theme.example.sh`（デプロイ入口が 3 つ）が並ぶ。テーマ = 配布物という WordPress の感覚からすると雑多で、`docs/` へ寄せるか削除すべきものが多い。

また `README.md` / `docs/sansuien.md` / `DEPLOYMENT.md` に **SSH ホスト名・ユーザー名・ポート・サーバー絶対パス・ローカルマシンの絶対パス**が記載されている。秘密鍵そのものではないが、公開リポジトリとしては攻撃対象領域の情報開示であり、伏せ字化または非公開ファイル（gitignore 済みの `.env.deploy` 系）へ移すべき。セキュリティ第一の方針とも整合しない。

### 2-6. `<main>` ランドマークと見出し階層

`<main>` を出力するのは `page.php` のみ。front-page / room / contact / category 各テンプレートは本文が `<section>` の羅列で、`<main>` も下層ページの `<h1>` も存在しない（下層は `page_hero` 内が `<h2>` 始まり）。Theme Check / アクセシビリティ双方の観点で減点。

### 2-7. `custom-logo` サポートが宣言だけ

`add_theme_support( 'custom-logo' )` があるのに `site-header.php` はテキストロゴ固定で `the_custom_logo()` を使わない。クライアントがカスタマイザーでロゴを設定しても何も起きない。実装するか、サポート宣言を外して「施設名は共通情報で編集」に一本化するか、どちらかに揃える。

---

## 3. 命名規則

**良い点:** PHP 関数の `theme_` プレフィックス統一、定数 `THEME_*`、enqueue ハンドル `theme-*`（kebab-case）、ACF name の snake_case、新規 CSS クラスの PascalCase（`ContactIntro`、`Modal`）と静的 HTML 由来クラスの維持 — いずれもプロジェクト規約通りで一貫している。phpcs（WPCS 全ルール）＋ 独自テストランナーの整備も good。

**指摘:**

- **テキストドメインを定数 `THEME_GETTEXT_DOMAIN` で渡している。** gettext 抽出ツールはリテラル文字列しか解析できず、WPCS の該当ルールを `severity 0` で黙らせて成立させている。実態はテンプレート内に日本語ハードコード（パンくず「トップ」、料金ラベル等）が大量にあり、i18n は機能していない。日本語専用テーマと割り切って `__()` を全廃するか、リテラル `'sansuien'` で統一するか、方針を明確にすべき。中途半端が最も印象が悪い。
  - **[対応済み]** ユーザー指示: 案件名 `sansuien` を命名規則上で（最低限必要な箇所以外）使うのは禁止。→ リテラル `'sansuien'` で統一する案は不採用とし、`__()`/`_e()`/`esc_html__()` 等の gettext 関数と `THEME_GETTEXT_DOMAIN` 定数を全廃、日本語リテラル直書き + plain escaping に統一した。`sansuien` の使用箇所は style.css のテーマヘッダーと bootstrap のデプロイ先スラッグのみに縮小。

---

## 4. 管理画面の編集体験（本題・厳しめ評価）

### 4-1. 評価できる点

- **ACF Options Page「宿泊施設共通情報」**: 施設名・電話・住所・受付時間・地図・SNS を 1 箇所に集約し、ヘッダー／フッター／予約導線で共用する設計は、クライアント編集型サイトの定石をきちんと踏んでいる。
- **タブ UI**（ヒーロー / ROOMS / ONSEN / CUISINE / About）でトップページの大量フィールドを整理している点、Google マップ埋め込み URL の取得手順を `instructions` に書いている点は、クライアント目線がある。
- ACF・CF7 無効時に fatal にならず fallback 表示する規律、非破壊 bootstrap（既存値を上書きしない）も運用品質として高い。

### 4-2. 編集できない・運用に耐えない点

1. **トップページのギャラリー（`front/gallery.php`）とお客様の声（`front/voices.php`)が完全ハードコード。** 旅館サイトで更新頻度・更新欲求が最も高い部類のコンテンツがコード編集必須。AGENTS.md 自身が「増減可能な一覧には CPT を検討する」と定めているのに、声は固定 3 件・ギャラリーは固定 5 枚。第三者レビューでは「管理画面化が途中で止まっている」と判定される。
2. **客室とお知らせが標準「投稿」に同居**（`docs/archive-cpt-acf-decision.md` に経緯記録あり。方針自体は尊重する）。ただし現状の実装はこの方針の弱点を補っていない：
   - 投稿一覧で客室とお知らせが混在し、クライアントはカテゴリー列で見分けるしかない
   - **カテゴリーを付け忘れると ACF フィールドも出ず、サイトのどこにも表示されない**（気づく手段がない）
   - 並び順を `menu_order` で制御しているが、投稿タイプ `post` は `page-attributes` 非サポートのため**管理画面から並び順を変更する UI が存在しない**（bootstrap スクリプトでしか設定できない。クライアントが客室の表示順を入れ替えられない）
   - カテゴリー方針を続けるなら最低限：新規投稿へのカテゴリー既定値付与、投稿一覧の絞り込みビュー（`views_edit-post` フック等）、管理画面カラム（サムネイル・料金・並び順）、並び順プラグインの導入が必要
3. **`room_gallery_1`〜`4` の固定 4 枠方式**は「5 枚目を足したい」に応えられない。無料 ACF の制約下の妥協としても、熟練者なら ACF PRO の Gallery / Repeater か、標準のアイキャッチ＋添付画像（`get_attached_media`）方式を選ぶ。
4. **フロントページの本文エディタが「書けるのに表示されない」**。front-page はテンプレートが post_content を一切出力しないため、クライアントがブロックエディタに何か書いても反映されず混乱する。ACF のフィールドグループ設定（`hide_on_screen` で the_content を非表示）か `remove_post_type_support` で本文エディタを隠すのが定石。
5. **CF7 フォームを「投稿タイトル文字列」で検索**（`inc/contact-form.php`）。docs に「フォームの投稿タイトルは変更しないこと」と注意書きがあるが、クライアントにタイトル変更させない前提の設計は脆い。フォーム ID を Options（宿泊施設共通情報にフィールド追加）へ持たせるか、固定ページ本文にショートコードを書かせて `the_content()` で出す方式なら注意書き自体が不要になる。
6. **デモコンテンツが 3 箇所に重複**（ACF `default_value` / テンプレート内 fallback 文字列 / bootstrap の seed 値）。文言修正時に 3 箇所の同期が必要で、どれかを直し忘れると「ACF を止めた瞬間に旧文言が蘇る」。fallback 文字列を定数または 1 つの配列に集約すべき。
7. 細かい点：`page_room_tags`「カンマ区切りテキスト」はクライアント入力としてはミスを誘発しやすい（ACF の checkbox / select（複数）か、無料版なら repeater 代替の改行区切り + 明確な instructions が現実的）。「英字キャッチ」「英字コピー」等のラベルは編集者に意図が伝わるが、プレビュー画像との対応（どこに出るか）の説明がないフィールドが多い。フィールドごとに「トップページの◯◯に表示」と instructions を書き切るのが熟練者の仕事。

### 4-3. 推奨する編集方式・プラグイン構成（スタンダード比較）

| 課題 | 現状 | 推奨（第一候補） | 代替 |
| --- | --- | --- | --- |
| 声・ギャラリー等の可変リスト | ハードコード | **ACF PRO**（Repeater / Gallery）。買い切りライセンスで案件横断利用でき、この規模の案件では標準解 | 無料維持なら **Secure Custom Fields**（WP.org 版 ACF フォーク）+ 声は投稿/CPT 化、ギャラリーは標準「ギャラリー」ブロックや添付画像方式 |
| 客室の管理 | 投稿 + `room` カテゴリー | **CPT `room`**（管理メニュー独立・location `post_type` で確実・`page-attributes` で並び順 UI が付く）。「客室」というメニューが左に出ること自体がクライアントの迷いを消す | カテゴリー方針維持なら、既定カテゴリー付与＋一覧絞り込み＋管理カラム追加＋並び順プラグインをテーマ側で実装 |
| 並び順 | `menu_order`（UI なし） | CPT + `page-attributes`、またはドラッグ&ドロップの定番 **Simple Custom Post Order** / **Intuitive Custom Post Order** | 日付順運用に割り切る |
| 投稿一覧の視認性 | 素の投稿一覧 | `manage_posts_columns` でサムネイル・料金・カテゴリー列を追加（テーマ内 30 行程度） | **Admin Columns** プラグイン |
| フォーム | CF7（タイトル検索） | CF7 継続 + **フォーム ID を Options で管理**に修正 | Snow Monkey Forms、WPForms Lite |
| SEO / OGP | なし | **SEO SIMPLE PACK**（国内案件の定番・軽量） | Yoast SEO |
| ブロックエディタ路線 | 未使用（実質） | 現規模ならクラシック + ACF metabox 継続で妥当。**ページ数が本格的に増える段階で ACF Blocks（PRO）によるセクション部品化**を検討するのが現実的なロードマップ | フルサイト編集（FSE）への移行は本案件の設計思想（静的 HTML 忠実再現）と相性が悪く非推奨 |

**結論:** 「ACF をやめるべき」状況ではない。ACF（できれば PRO）+ CPT + 少量の管理画面カスタマイズ（カラム・並び順・本文エディタ非表示）という王道構成に寄せ、ハードコードされた残りのセクションを管理画面へ引き上げるのが最短の改善路線。

---

## 5. ドキュメント整合性（第三者の第一印象を最も損なっている点)

`README.md` と `docs/sansuien.md` は **存在しないファイルを実構成として記載している**：`single-room.php`、`archive-room.php`、`inc/cpt.php`、CPT `room` / `news`、`front-page-content.php` が closing を呼ぶ、等。実装は「標準投稿 + カテゴリー + `category-room.php` + 固定ページ `page-room.php`」へ移行済みで、テスト（`tests/run.php`）は新構成を検証しているのに、ドキュメントだけが旧構成のまま。**コードを読む前に README を読む第三者は、最初の 5 分で「ドキュメントが信用できないリポジトリ」と判断する。** テストが構成を強制しているだけに、README の放置は非常にもったいない。

`docs/archive-cpt-acf-decision.md` に「再設計中」とあるが、再設計（カテゴリー移行）は完了しているように見えるため、この文書のステータス更新も必要。

---

## 6. 優先度付き改善リスト

### P0（不具合・公開前に必須）
1. 客室・お問い合わせページの ACF location 修正（§1-1）— 管理画面で編集項目が出ることを実機確認
2. プライバシーポリシー本文の参照先を Options に修正（§1-2）
3. `page.php` / `index.php` にサイトヘッダー・フッターが出るよう構成修正（§2-1。推奨: site-header / site-footer を `header.php` / `footer.php` へ統合）
4. README / docs/sansuien.md を現行アーキテクチャに全面更新（§5）
5. 公開リポジトリから SSH ホスト・ユーザー・サーバーパス等を除去（§2-5)

### P1（クライアント引き渡し前に）
6. `theme_option()` の ACF 無効時 option キー修正（§1-3）
7. ギャラリー・お客様の声の管理画面化（§4-2-1、方式は §4-3）
8. 客室の並び順 UI の確保（CPT 化 or 並び順プラグイン）と投稿一覧の整理（§4-2-2）
9. フロントページの本文エディタ非表示化（§4-2-4）
10. CF7 のフォーム ID 参照化（§4-2-5）
11. Example 残骸・`top.php` 重複・`docs/theme.example.bak`・無関係な `bootstrap.md` の削除（§2-3, 2-4, 2-5）

### P2（品質向上）
12. `404.php` 追加と `index.php` の役割正常化、`/news/` の受けテンプレート整備（§1-5, 2-2）
13. `<main>` ランドマークと下層 `<h1>` の整備（§2-6）
14. i18n 方針の決着（§3）、custom-logo の実装 or 撤去（§2-7）
15. デモ文言の一元化（§4-2-6）、ヒーロー内お知らせリンク修正（§1-4）

---

## 7. §4-2-1 / §4-2-2 / §4-2-3 の決定事項（ユーザー確認済み）

- **ギャラリー・お客様の声（§4-2-1）／`room_gallery` 固定4枠（§4-2-3）**: ACF 無料版に Repeater / Gallery
  フィールドがないことが直接原因だったため、**Secure Custom Fields**（WordPress.org 公式、無料、ACF 互換の
  同一 API）への切替を採用。コード側は対応済み（`front_gallery_images` / `front_voices` / `room_gallery` /
  `page_room_gallery`）。**SCF プラグインを wp-admin へインストール・有効化する作業はユーザー側で必要**
  （ACF が有効なままだと Gallery/Repeater フィールドは機能しない）。
- **客室の管理方式（§4-2-2）**: カテゴリー方式を維持し、無料の並び順プラグイン（Simple Custom Post Order /
  Intuitive Custom Post Order）を追加する方針を採用。CPT 化は過去に一度ユーザーの意図に反して行われ差し戻された
  経緯があるため見送り。表示側の `theme_get_content_posts()` は既に `menu_order` 順でクエリしているため
  テーマ側の追加実装は不要。**並び順プラグインのインストールもユーザー側の作業**。
