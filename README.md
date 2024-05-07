
![Cafeteria CIFP Zonzamas Logo](https://github.com/BladyPeralta24/Cafeteria-Zonzamas/blob/master/public/img/icono_zonzamas.png)


# Cafetería CIFP Zonzamas

La cafeteria CIFP Zonzamas es una página web pensada para que puedas reservar tus pedidos de una manera rápida y sencilla, en el que te puedes ahorrar largas colas en el recreo. Con una reserva a través de la página web, lo tienes al alcance de tu mano.


## Tech Stack

**Client:** Laravel, TailwindCSSc, HTML, CSS, JavaScript

**Server:** Apache

**Data Base:** MySQL


## Documentation

- [Diagrama de Casos de Uso](https://drive.google.com/file/d/1H1SB62LLIsXH8r6WTEqhV6zp4fsPGVxN/view)

- [Diagrama de clases](https://drive.google.com/file/d/14njVhY5L0fJG6HE8CO76VXTRE7yrurhR/view)

- [Diagrama entidad-relacion](https://drive.google.com/file/d/1K3RWbVlmt7kfZEdwHYgP5kt1_eRnrFj-/view)

- [Modelo Relacional](https://drive.google.com/file/d/1mNgM-8kYAtrGdFcehyGeBXp6lsehDW6a/view)

- [Video del proyecto](https://youtu.be/JnE8jBE4Z0Q)

## 🚀 About Me
Soy alumno de Desarrollo de aplicaciones web, especializado en entorno cliente y entorno servidor (Full Stack).


## 🛠 Skills
Javascript, HTML, CSS...

FrameWorks: Laravel, Vue.js


## Installation

Clonar el repositorio

```bash
  git clone https://github.com/BladyPeralta24/Cafeteria-Zonzamas.git
```

Moverse al directorio Cafeteria-Zonzamas
```bash
  cd Cafeteria-Zonzamas
```

Instalar las dependencias con Composer
```bash
  composer install
```

Instale las dependencias de npm
```bash
  npm install
```

Hacer una copia de .env.example y renombrarlo como .env
```bash
  cp .env.example .env
```

Genere una nueva clave
```bash
  php artisan key:generate
```

Configurar la base de datos con los siguientes parámetros para el archivo .env
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cafeteria_zonzamas
DB_USERNAME=root
DB_PASSWORD=
```

Ejecute las migraciones
```bash
  php artisan migrate
```

Ejecutar los seeders globales
```bash
  php artisan db:seed
```

Inicie el servidor
```bash
  php artisan serve
```

En otra consola inicie tambien las dependencias de npm
```bash
npm run dev
```
## Used By

Este proyecto a sido creado por:

- Bladimir Peralta Herrera


## License

[MIT](https://choosealicense.com/licenses/mit/)

