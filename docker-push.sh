#!/usr/bin/env bash

set -euo pipefail

default_source="${APP_NAME:-reservation-salles}-app:${APP_VERSION:-latest}"
source_image="${1:-$default_source}"

if [[ "$source_image" == */* ]]; then
    source_name="${source_image##*/}"
else
    source_name="$source_image"
fi

if [[ "$source_name" == *:* ]]; then
    default_tag="${source_name##*:}"
else
    default_tag="latest"
fi

target_repository="${DOCKERHUB_REPOSITORY:-${DOCKERHUB_USERNAME:-alsudais23}/${APP_NAME:-reservation-salles}-app}"
target_tag="${2:-$default_tag}"
target_image="$target_repository:$target_tag"

if [[ "$source_image" == "$target_image" ]]; then
    target_image="$source_image"
else
    docker image inspect "$source_image" >/dev/null
    docker tag "$source_image" "$target_image"
fi

printf 'Publication de %s vers %s\n' "$source_image" "$target_image"
docker push "$target_image"