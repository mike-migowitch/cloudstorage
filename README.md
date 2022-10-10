# Облачное хранилище

REST API сервис облачного хранилища на Laravel 9

## Развертывание

- Собрать контейнер
```
sail build --no-cache
```
- Запустить контейнер
```
sail up
```
- Установить зависимости через composer
```
composer install --no-cache
```
- Если нужна отладка по XDebug, то перед запуском сборки установить в env
```
XDEBUG=true
XDEBUG_PORT=9003
```
