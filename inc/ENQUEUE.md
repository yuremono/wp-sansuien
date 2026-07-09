# `inc/enqueue.php` の解説

このファイルは、フロントエンドで必要な CSS と JavaScript を WordPress に読み込ませるための処理をまとめたものです。

WordPress では、HTML に `<link>` や `<script>` を直接書き込むのではなく、`wp_enqueue_style()` と `wp_enqueue_script()` を使って資産を登録します。
そうすると、読み込み順や依存関係を WordPress 側で管理でき、テーマ全体の保守がしやすくなります。

---

## このファイルの役割

このファイルがやっていることは大きく 2 つです。

1. 全ページ共通の CSS / JavaScript を読み込む
2. WordPress の `wp_enqueue_scripts` フックに登録する

つまり、「フロントで使う見た目と動きを、必要な順番でまとめて読み込む司令塔」です。

トップページ・客室個別（`single-room.php`）・客室一覧（`archive-room.php`）が同一のデザインシステム（静的サイト `tmp/sansuien/preview/style.css` を移植したもの）で完結するため、旧居酒屋テーマにあったページ別 CSS 切り替え（`theme_page_stylesheet()`）は廃止し、単一の資産セットを無条件で読み込む構成にしています。

---

## 全体の流れ

このファイルは最後に次の処理で動きます。

```php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_assets' );
```

WordPress はページ表示の準備中に `wp_enqueue_scripts` というタイミングを用意しています。
そこに `theme_enqueue_assets()` を登録しておくと、WordPress が適切なタイミングでこの関数を呼び出します。

---

## 最初の安全確認

```php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
```

これは WordPress 以外の場所からこのファイルが直接実行されるのを防ぐための保護です。

- `ABSPATH` は WordPress が起動したときに定義されます
- これが存在しないなら、WordPress の外で直接読まれている可能性があります
- その場合は `exit;` で即終了します

セキュリティと安定性の基本です。

---

## `theme_enqueue_assets()`

```php
function theme_enqueue_assets(): void
```

この関数が、実際に CSS / JavaScript を読み込む本体です。全ページで無条件に実行されます（旧テーマにあった対象ページ判定 `theme_is_custom_view()` は、山水園ではサイト全体が同じデザインで完結するため廃止しました）。

---

## CSS の読み込み順

### 1. Google Fonts

```php
theme-google-fonts
```

`Shippori Mincho`（見出し用の明朝体）、`Zen Kaku Gothic New`（本文用のゴシック体）、`IBM Plex Mono` を読み込みます。

### 2. テーマ本体 CSS

```php
theme-style  →  assets/css/style.css
```

静的サイトのクラス名（snake_case）をそのまま維持したテーマ本体スタイルです。`wp_nav_menu()` が出力する `<ul><li>` を `display:contents` で吸収する調整ルールのみ追加しています。

---

## JavaScript の読み込み順

```php
theme-main  →  assets/js/theme.js
```

依存ライブラリ（jQuery、Slick、Magnific Popup など）は使用しません。静的サイトの `<script>` 内ロジック（reveal 演出、ヘッダースクロール、ギャラリーマーキー、feature セクションの scroll-scrub 演出）を素の JavaScript のまま `assets/js/theme.js` へ切り出しています。要素が存在しないページ（例: 客室個別ページにはギャラリーマーキー用の `#gTrack` がない）では、各初期化関数が早期リターンするよう防御的に実装しています。

---

## `theme_source_uri()` と `theme_asset_version()`

このファイルでは、パスを直接ベタ書きする代わりに補助関数を使っています。

### `theme_source_uri()`

テーマ内の資産 URL を組み立てる関数です。

例:

```php
theme_source_uri( 'css/style.css' )
```

### `theme_asset_version()`

キャッシュ対策用のバージョン文字列を返す関数です。
ファイル更新時に古いキャッシュが残りにくくなります。

---

## WordPress 未経験者向けの理解のしかた

このファイルをかなり単純化すると、やっていることは次の通りです。

1. 共通の CSS を読み込む
2. 共通の JavaScript を読み込む
3. WordPress の決まったタイミングで自動実行する

React でいうと「import して使う部品の管理」に近いですが、WordPress ではそれをテンプレートの外側で `enqueue` という仕組みでやります。

---

## このファイルを触るときの注意

- CSS / JS の順番は壊さない
- 依存関係があるものは `array( ... )` で明示する
- 外部 CDN（Google Fonts）を追加するときは、ネットワーク障害時の影響を考える
- 使っていない資産を増やすとページが重くなる
- 同じファイルを別ハンドルで二重に読んでいないか確認する

---

## まとめ

`inc/enqueue.php` は、テーマの表示に必要な CSS / JavaScript を管理する中心ファイルです。
WordPress の標準的な enqueue 方式に従っていて、山水園ではページ別の CSS 切り替えを行わず単一の資産セットに統一しています。

WordPress 未経験者がまず押さえるべきポイントは次の 3 つです。

1. `enqueue` は「読み込み予約」の仕組み
2. `add_action( 'wp_enqueue_scripts', ... )` で実行タイミングを登録する
3. 依存関係を指定すると、読み込み順を WordPress に任せられる
