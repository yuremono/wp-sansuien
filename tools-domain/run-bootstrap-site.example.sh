#!/usr/bin/env bash
# Run bootstrap-site.example.php with a Local-compatible PHP binary.
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PHP_BIN="${THEME_LOCAL_PHP:-${DEPLOY_PHP:-}}"
PHP_INI="${THEME_LOCAL_PHP_INI:-}"
export WP_LOAD_PATH="${WP_LOAD_PATH:-/Users/yanoseiji/Local Sites/izakaya/app/public/wp-load.php}"
EXPECTED_CONFIRMATION="izakaya-local"

if [[ "${THEME_BOOTSTRAP_CONFIRM:-}" != "$EXPECTED_CONFIRMATION" ]]; then
	echo "実行確認がありません。THEME_BOOTSTRAP_CONFIRM=${EXPECTED_CONFIRMATION} を指定してください。" >&2
	exit 1
fi

if [[ -z "$PHP_BIN" ]]; then
	PHP_BIN="$(command -v php || true)"
fi

if [[ -z "$PHP_BIN" ]]; then
	echo "PHP が見つかりません。THEME_LOCAL_PHP に PHP のフルパスを指定してください。" >&2
	exit 127
fi

if [[ -n "$PHP_INI" ]]; then
	"$PHP_BIN" -c "$PHP_INI" "${SCRIPT_DIR}/bootstrap-site.example.php" "$@"
else
	"$PHP_BIN" "${SCRIPT_DIR}/bootstrap-site.example.php" "$@"
fi
