# Espera o banco estar disponível
until nc -z db 5432; do
    echo "Aguardando o banco de dados iniciar..."
    sleep 2
done

# Permissões
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Instala dependências do PHP
composer install || true

# Gera key se necessário
php artisan key:generate || true

# Executa migrações
php artisan migrate --force || true

# Inicia o PHP-FPM
exec php-fpm
