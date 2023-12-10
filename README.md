```sh
cp .env.example .env
docker compose up --build
docker compose exec php composer dump-autoload
docker compose exec -T mysql mysql -uroot -proot pizza < schema.sql
```
