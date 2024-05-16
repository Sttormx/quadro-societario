# Quadro Societário
Repositorio do desafio tecnico da Vox.

## Front End
Acesse a pasta web
```bash
cd web
```

Instale as dependencias e rode em modo de desenvolvimento
```bash
npm install
npm run dev
```

O serviço estará disponível na URL http://localhost:3000

## Back End
Acesse a pasta server
```bash
cd server
```

Rode utilizando docker compose:
```bash
SERVER_NAME=http://localhost MERCURE_PUBLIC_URL=http://localhost/.well-known/mercure TRUSTED_HOSTS='^localhost|php$' docker compose up --pull always -d --build
```

Em seguida, execute as migrations:
```bash
docker exec -it server-php-1 bash
php bin/console doctrine:migrations:migrate
yes
```

O serviço estará disponível na URL http://localhost

## Observações
- O front end foi implementado utilizando React com Next.js.
- Não precisa realizar configurações de .env, certificados, chaves ssh. Eu já deixei tudo commitado para facilitar a execução do projeto. Eu NÃO faria isso em um projeto real.
- Faltou finalizar o CRUD dos sócios no front e uma pequena parte lógica no back. Infelizmente não consegui finalizar tudo a tempo.