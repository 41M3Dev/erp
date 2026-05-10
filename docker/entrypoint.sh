#!/bin/bash
set -e

# ─── En développement : installer les dépendances si nécessaire ──────────────
if [ "$APP_ENV" != "production" ]; then
    if [ ! -d "vendor" ]; then
        echo "Installation des dépendances Composer..."
        composer install --no-interaction
    fi

    if [ ! -d "node_modules" ]; then
        echo "Installation des dépendances Node.js..."
        npm install
    fi
fi

# ─── Générer la clé si absente ───────────────────────────────────────────────
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:" ]; then
    echo "Génération de la clé d'application..."
    php artisan key:generate --force
fi

# ─── Attendre la base de données ─────────────────────────────────────────────
if [ -n "$DB_HOST" ]; then
    echo "Attente de la base de données ($DB_HOST)..."
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
        } catch (Exception \$e) {
            exit(1);
        }
    " 2>/dev/null; do
        tries=$((tries + 1))
        if [ $tries -ge $max_tries ]; then
            echo "Impossible de se connecter à la base de données après $max_tries tentatives."
            exit 1
        fi
        echo "  Tentative $tries/$max_tries..."
        sleep 2
    done
    echo "Base de données disponible."
fi

# ─── Migrations ──────────────────────────────────────────────────────────────
echo "Exécution des migrations..."
php artisan migrate --force

# ─── Seed des rôles si la table est vide ─────────────────────────────────────
ROLE_COUNT=$(php -r "
    require 'vendor/autoload.php';
    \$app = require 'bootstrap/app.php';
    \$kernel = \$app->make(Illuminate\Contracts\Http\Kernel::class);
    try {
        echo \App\Models\Role::count();
    } catch (Exception \$e) {
        echo 0;
    }
" 2>/dev/null || echo "0")

if [ "$ROLE_COUNT" = "0" ]; then
    echo "Initialisation des rôles..."
    php artisan db:seed --class=RoleSeeder --force
fi

# ─── Optimisations production ─────────────────────────────────────────────────
if [ "$APP_ENV" = "production" ]; then
    echo "Mise en cache des configs/routes/vues..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

echo "Démarrage des services..."
exec "$@"
