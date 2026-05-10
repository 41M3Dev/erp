#!/bin/bash
set -e

# ─── Vérifier que la clé est définie ─────────────────────────────────────────
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:" ]; then
    echo "[entrypoint] ERREUR : APP_KEY non définie. Définissez-la dans les variables d'environnement."
    exit 1
fi

# ─── Attendre la base de données ─────────────────────────────────────────────
if [ -n "$DB_HOST" ]; then
    echo "[entrypoint] Attente de la base de données ($DB_HOST:${DB_PORT:-3306})..."
    max_tries=30
    tries=0
    until php -r "
        try {
            new PDO(
                'mysql:host=${DB_HOST};port=${DB_PORT:-3306};dbname=${DB_DATABASE}',
                '${DB_USERNAME}',
                '${DB_PASSWORD}'
            );
            exit(0);
        } catch (Exception \$e) { exit(1); }
    " 2>/dev/null; do
        tries=$((tries + 1))
        if [ "$tries" -ge "$max_tries" ]; then
            echo "[entrypoint] ERREUR : base de données inaccessible après $max_tries tentatives."
            exit 1
        fi
        echo "[entrypoint] Tentative $tries/$max_tries, nouvel essai dans 2s..."
        sleep 2
    done
    echo "[entrypoint] Base de données disponible."
fi

# ─── Migrations ──────────────────────────────────────────────────────────────
echo "[entrypoint] Migrations..."
php artisan migrate --force

# ─── Seed des rôles (firstOrCreate = idempotent, sans risque) ────────────────
echo "[entrypoint] Initialisation des rôles..."
php artisan db:seed --class=RoleSeeder --force

# ─── Optimisations production ─────────────────────────────────────────────────
if [ "$APP_ENV" = "production" ]; then
    echo "[entrypoint] Mise en cache config / routes / vues..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

echo "[entrypoint] Démarrage des services..."
exec "$@"
