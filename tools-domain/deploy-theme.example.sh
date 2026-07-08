#!/usr/bin/env bash
# Sansuien theme deploy wrapper. Remote sync still requires a confirmed path.
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

export DEPLOY_THEME_SLUG="${DEPLOY_THEME_SLUG:-sansuien}"
export DEPLOY_ZIP_NAME="${DEPLOY_ZIP_NAME:-sansuien-theme.zip}"

exec "${SCRIPT_DIR}/../tools/deploy.sh" "$@"
