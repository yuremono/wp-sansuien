# `inc/enqueue.php` の解説

このファイルは、フロントエンドで必要な CSS と JavaScript を WordPress に読み込ませるための処理をまとめたものです。

WordPress では、HTML に `<link>` や `<script>` を直接書き込むのではなく、`wp_enqueue_style()` と `wp_enqueue_script()` を使って資産を登録します。  
そうすると、読み込み順や依存関係を WordPress 側で管理でき、テーマ全体の保守がしやすくなります。

---

## このファイルの役割

このファイルがやっていることは大きく 3 つです。

1. どのページでどの CSS を使うか決める
2. 共通の CSS / JavaScript を読み込む
3. WordPress の `wp_enqueue_scripts` フックに登録する

つまり、「フロントで使う見た目と動きを、必要な順番でまとめて読み込む司令塔」です。

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

## `theme_page_stylesheet()`

```php
function theme_page_stylesheet(): string
```

この関数は「今見ているページに応じて、どの CSS ファイルを使うか」を返します。

### 何をしているか

```php
$pages = array( 'genshu', 'shochu', 'other', 'otsumami', 'insta', 'info' );
```

ここでは、ページテンプレートごとのページ種別を配列で持っています。

```php
if ( is_page_template( "page-templates/{$page}.php" ) ) {
	return "{$page}_html.css";
}
```

この部分で、現在のページが該当テンプレートかどうかを判定しています。  
たとえば `page-templates/genshu.php` が使われていれば、`genshu_html.css` を返します。

### 戻り値

- 特定テンプレートに一致した場合: `genshu_html.css` など
- どれにも一致しない場合: `index_html.css`

### 役割の意味

このテーマは、ページごとに見た目がかなり違う構成です。  
そのため、共通 CSS だけでなく、ページ単位の CSS を切り替えています。

---

## `theme_enqueue_assets()`

```php
function theme_enqueue_assets(): void
```

この関数が、実際に CSS / JavaScript を読み込む本体です。

### 先頭の分岐

```php
if ( ! theme_is_custom_view() ) {
	return;
}
```

ここで、対象ページ以外では何も読み込まないようにしています。  
つまり、全ページ一律ではなく「このテーマで管理したい表示だけ」に限定して資産を載せています。

これは無駄な読み込みを減らすのに有効です。

---

## CSS の読み込み順

このファイルは、依存関係を考えて順番に CSS を積んでいます。

### 1. 外部ライブラリ

```php
theme-font-awesome
theme-line-awesome-all
theme-line-awesome
```

これらはアイコン用の外部 CSS です。

- Font Awesome
- Line Awesome

### 2. テーマ内の機能系 CSS

```php
theme-magnific-popup
theme-slick-theme
theme-slick
```

これはテーマの見た目や UI 挙動に関わる CSS です。

### 3. ページ別 CSS

```php
$page_stylesheet = theme_page_stylesheet();
```

ここでページごとの CSS を選びます。

### 4. 共通 CSS

```php
theme-common
theme-style
```

最後に共通スタイルを足しています。

---

## JavaScript の読み込み順

JavaScript も依存関係を意識して順番に読み込んでいます。

### 1. jQuery

```php
wp_enqueue_script( 'jquery' );
wp_add_inline_script( 'jquery', 'window.$ = window.jQuery;', 'after' );
```

まず WordPress 標準の `jquery` を読み込みます。  
そのあとで `window.$ = window.jQuery;` を入れて、`$` で jQuery を使えるようにしています。

これは古い jQuery ベースのコードを動かしやすくするための設定です。

### 2. 外部・機能系スクリプト

```php
theme-magnific-popup
theme-slick
theme-function
theme-flipsnap
theme-viewport-extra
```

この順番は依存関係に沿っています。

たとえば:

- `theme-function` は `jquery`、`theme-magnific-popup`、`theme-slick` に依存

依存関係を設定すると、WordPress が自動で正しい順番に並べてくれます。

---

## `theme_source_uri()` と `theme_asset_version()`

このファイルでは、パスを直接ベタ書きする代わりに補助関数を使っています。

### `theme_source_uri()`

テーマ内の資産 URL を組み立てる関数です。

例:

```php
theme_source_uri( 'css/common.css' )
```

### `theme_asset_version()`

キャッシュ対策用のバージョン文字列を返す関数です。  
ファイル更新時に古いキャッシュが残りにくくなります。

---

## WordPress 未経験者向けの理解のしかた

このファイルをかなり単純化すると、やっていることは次の通りです。

1. 今のページ種類を判定する
2. 必要な CSS を順番に読み込む
3. 必要な JavaScript を順番に読み込む
4. WordPress の決まったタイミングで自動実行する

React でいうと「import して使う部品の管理」に近いですが、WordPress ではそれをテンプレートの外側で `enqueue` という仕組みでやります。

---

## このファイルを触るときの注意

- CSS / JS の順番は壊さない
- 依存関係があるものは `array( ... )` で明示する
- 外部 CDN を追加するときは、ネットワーク障害時の影響を考える
- 使っていない資産を増やすとページが重くなる
- 同じファイルを別ハンドルで二重に読んでいないか確認する

---

## まとめ

`inc/enqueue.php` は、テーマの表示に必要な CSS / JavaScript を管理する中心ファイルです。  
WordPress の標準的な enqueue 方式に従っていて、ページ別の CSS 切り替えも入っています。

WordPress 未経験者がまず押さえるべきポイントは次の 3 つです。

1. `enqueue` は「読み込み予約」の仕組み
2. `add_action( 'wp_enqueue_scripts', ... )` で実行タイミングを登録する
3. 依存関係を指定すると、読み込み順を WordPress に任せられる
