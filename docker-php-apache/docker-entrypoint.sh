#!/bin/bash
set -e

echo "[$(date -u +%d-%m-%Y_%H-%S-%N)][${0}] Starting API Hacienda Configuration"

setUpCryptoKey() {
    SETTINGS_FILE_PATH=/var/www/html/settings.php
    SETTINGS_TEMPLATE_FILE_PATH=/var/www/html/settings_original_docker.php.dist
    LOCALHOSTNAME=localhost
    CRLIBRE_API_HACIENDA_CRYPTO_KEY="non-set"

    if [ -e "${SETTINGS_FILE_PATH}" ]; then
        echo "[$(date -u +%d-%m-%Y_%H-%S-%N)][${0}] *** Found ${SETTINGS_FILE_PATH}, checking if cryptoKey exists ***"

        if grep -q "'cryptoKey'" "${SETTINGS_FILE_PATH}"; then
            echo "[$(date -u +%d-%m-%Y_%H-%S-%N)][${0}] CryptoKey already exists. Skipping key generation."
            return
        fi
    fi

    echo "[$(date -u +%d-%m-%Y_%H-%S-%N)][${0}] Generating new settings.php"

    cat "${SETTINGS_TEMPLATE_FILE_PATH}" \
    | sed "s/{dbName}/${CRLIBRE_API_HACIENDA_DB_NAME}/g" \
    | sed "s/{dbPss}/${CRLIBRE_API_HACIENDA_DB_PASSWORD}/g" \
    | sed "s/{dbUser}/${CRLIBRE_API_HACIENDA_DB_USER}/g" \
    | sed "s/{dbHost}/${CRLIBRE_API_HACIENDA_DB_HOST}/g" \
    > "${SETTINGS_FILE_PATH}"

    echo "Waiting on Database Server to be ready"
    while ! nc -z ${CRLIBRE_API_HACIENDA_DB_HOST} 3306; do
        echo "[$(date -u +%d-%m-%Y_%H-%S-%N)][${0}] Sleeping 1 sec.. waiting on MySQL"
        sleep 1
    done
    echo "[$(date -u +%d-%m-%Y_%H-%S-%N)][${0}] MySQL Is Up"

    echo "Waiting on Web Server to be ready"
    while ! nc -z ${LOCALHOSTNAME} 80; do
        echo "[$(date -u +%d-%m-%Y_%H-%S-%N)][${0}] Sleeping 1 sec... waiting on Apache"
        sleep 1
    done
    echo "[$(date -u +%d-%m-%Y_%H-%S-%N)][${0}] Apache is Up"

    echo "[$(date -u +%d-%m-%Y_%H-%S-%N)][${0}] Trying to retrieve CryptoKey"
    CRLIBRE_API_HACIENDA_CRYPTO_KEY_JSON=$(curl -s "http://${LOCALHOSTNAME}:80/api.php?w=crypto&r=makeKey" -o /var/www/html/cryptoKey.json)
    
    CRLIBRE_API_HACIENDA_CRYPTO_KEY=$(cat /var/www/html/cryptoKey.json | awk -F'"' '/"resp"/ {print $4}')
    echo "[$(date -u +%d-%m-%Y_%H-%S-%N)][${0}] CryptoKey set to: ${CRLIBRE_API_HACIENDA_CRYPTO_KEY}"

    sed -i "s/{cryptoKey}/${CRLIBRE_API_HACIENDA_CRYPTO_KEY}/g" "${SETTINGS_FILE_PATH}"
    echo "[$(date -u +%d-%m-%Y_%H-%S-%N)][${0}] Created ${SETTINGS_FILE_PATH} with CryptoKey ***"
}

if [ "${1#-}" != "$1" ]; then
    echo "[$(date -u +%d-%m-%Y_%H-%S-%N)][${0}] Starting Apache Web Server"
    set -- apache2-foreground "$@"
fi

setUpCryptoKey &

# Fix MPM conflict
rm -f /etc/apache2/mods-enabled/mpm_event.conf \
      /etc/apache2/mods-enabled/mpm_event.load \
      /etc/apache2/mods-enabled/mpm_worker.conf \
      /etc/apache2/mods-enabled/mpm_worker.load
ln -sf /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf
ln -sf /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load

exec "$@"