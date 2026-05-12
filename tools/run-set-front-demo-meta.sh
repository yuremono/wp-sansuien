#!/usr/bin/env bash
# エージェント用: PATH に php が無くても Local 同梱の PHP で set-front-demo-meta.php を実行する。
# 前提: Local で対象サイトが「起動（Start）」済みで、MySQL が動いていること。
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PHP_BIN="${PORTFOLIO_LOCAL_PHP:-}"

discover_local_php() {
	shopt -s nullglob
	local c
	for c in \
		"${HOME}/Library/Application Support/Local/lightning-services"/php-*/bin/darwin-arm64/bin/php \
		"${HOME}/Library/Application Support/Local/lightning-services"/php-*/bin/darwin-x86_64/bin/php \
		"/Applications/Local.app/Contents/Resources/extraResources/lightning-services"/php-*/bin/darwin-arm64/bin/php \
		"/Applications/Local.app/Contents/Resources/extraResources/lightning-services"/php-*/bin/darwin-x86_64/bin/php; do
		if [[ -x "$c" ]]; then
			printf '%s\n' "$c"
			return 0
		fi
	done
	return 1
}

if [[ -z "$PHP_BIN" ]]; then
	if command -v php >/dev/null 2>&1; then
		PHP_BIN="$(command -v php)"
	elif discovered="$(discover_local_php)"; then
		PHP_BIN="$discovered"
	else
		echo "run-set-front-demo-meta.sh: php が見つかりません。Local をインストールするか、PORTFOLIO_LOCAL_PHP に php のフルパスを指定してください。" >&2
		exit 127
	fi
fi

set +e
out="$("$PHP_BIN" "${SCRIPT_DIR}/set-front-demo-meta.php" "$@" 2>&1)"
st=$?
set -e

if [[ "$st" -ne 0 ]]; then
	printf '%s\n' "$out"
	exit "$st"
fi
if printf '%s' "$out" | grep -qE 'wp-die-message|データベース接続確立エラー|Error establishing a database connection'; then
	echo "run-set-front-demo-meta.sh: WordPress が DB に接続できませんでした。Local で該当サイトを Start し、再度実行してください。" >&2
	exit 1
fi
if ! printf '%s' "$out" | grep -q '^OK:'; then
	printf '%s\n' "$out" >&2
	echo "run-set-front-demo-meta.sh: 想定外の出力です。wp-load のパス（local-wp-load.path または WP_LOAD_PATH）を確認してください。" >&2
	exit 1
fi

printf '%s\n' "$out"
