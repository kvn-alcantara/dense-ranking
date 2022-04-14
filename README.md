
### Setup do projeto

### Opcao 1 - Sail

Requerimentos:
- [Docker](https://www.docker.com/get-started/)
- [WSL2](https://docs.microsoft.com/en-us/windows/wsl/install)
- [Git](https://www.atlassian.com/git/tutorials/install-git#linux)

Acesse a sua distro por WSL, e clone o repositorio do projeto e entre na pasta criada:
```bash
git clone https://github.com/kvn-alcantara/dense-ranking.git && cd dense-ranking
```

Subir container para usar o composer
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php74-composer:latest \
    composer install --ignore-platform-reqs
```

Subir o container do app:
```bash
./vendor/bin/sail up -d
```

### Opcoa 2 - Local

Requerimentos:
- [PHP >= 7.3](https://www.php.net/downloads)
- [MySQL](https://dev.mysql.com/downloads/mysql/)
- [Composer](https://getcomposer.org/download/)
- [Git](https://www.atlassian.com/git/tutorials/install-git#linux)
- Descomentar essas linhas no arquivo `[diretorio_php]/php.ini`:
  - extension=pdo_sqlite
  - extension=mbstring
  - extension=fileinfo
  - extension=pdo_mysql
  - extension=openssl

Clone o repositorio e instale as dependencias:
```bash
git clone https://github.com/kvn-alcantara/dense-ranking.git && cd dense-ranking && composer install
```
