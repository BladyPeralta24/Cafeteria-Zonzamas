# Cafetería CIFP Zonzamas

Web (Laravel 10 + Breeze + Tailwind/Alpine + Bootstrap en la portada) para **reservar productos de la cafetería** del centro y recogerlos a una hora concreta sin hacer cola.

## Qué hace

- **Portada pública** con la explicación del servicio.
- **Registro / login** (los que se registran son siempre *clientes*).
- **Carta** agrupada por categorías, con ventana de detalle (descripción, precio, stock) y botón *Añadir a mi reserva*.
- **Mi reserva** (carrito): cambiar cantidades, quitar productos, ver el desglose con IGIC y elegir la **hora de recogida**.
- **Confirmar reserva**: se descuenta el stock y se vacía el carrito (todo en una transacción).
- **Mis reservas**: historial del cliente; puede cancelar las pendientes (se devuelve el stock).
- **Gestión** (solo admin/empleados): reservas del día, marcar *preparada*, *recogida* o *cancelada*.

## Instalación

Requisitos: PHP 8.1+, Composer, Node 18+ y MySQL (XAMPP sirve).

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Crea una base de datos vacía llamada `cafeteria_zonzamas` y revisa `DB_*` en `.env`.
(Si prefieres SQLite: `DB_CONNECTION=sqlite`, borra el resto de `DB_*`, y crea el archivo `database/database.sqlite`.)

```bash
php artisan migrate:fresh --seed   # crea las tablas y la carta de ejemplo
npm install
npm run build                      # o "npm run dev" mientras desarrollas
php artisan serve
```

Abre http://localhost:8000.

> **Importante:** sin `npm run build` (o `npm run dev` en marcha) las páginas de dentro dan el error *"Vite manifest not found"*.

### Usuarios de prueba (contraseña de todos: `password`)

| Correo | Rol |
|---|---|
| admin@admin.es | admin |
| gerente@zonzamas.es | empleado |
| camarero@zonzamas.es | empleado |
| cliente@zonzamas.es | cliente |

**Cámbialas si publicas la web.**

## Configuración

`config/cafeteria.php` (valores en `.env`): horario de recogida (`CAFETERIA_APERTURA`, `CAFETERIA_CIERRE`), minutos mínimos de antelación e IGIC. Los precios de la carta **ya incluyen** el IGIC; solo se desglosa en el resumen.

Los productos de ejemplo (nombres, precios y stock **inventados**) están en `database/seeders/ProductosTableSeeder.php`: edítalos con los reales y vuelve a ejecutar `php artisan migrate:fresh --seed`.

## Tests

```bash
php artisan test
```

Usan SQLite en memoria (ver `phpunit.xml`), así que **no tocan tu base de datos**. Necesitan la extensión `pdo_sqlite` de PHP.

## Qué se arregló respecto a la versión anterior

**Base de datos**
- `DatabaseSeeder` estaba vacío: `db:seed` no hacía nada. Ahora llama a todos los seeders en orden.
- Los seeders no eran coherentes entre sí (estanterías/productos apuntaban a almacenes que no existían, empleados a usuarios inexistentes). Reescritos.
- Migración `Empleado` con mayúscula (fallaba en Linux) y `reserva.id_empleado` obligatorio aunque el cliente aún no tiene empleado asignado.
- `users.tipo` no tenía valor por defecto → el registro fallaba.
- Faltaban `producto.descripcion`, `reserva.hora_recogida` y `reserva.estado`.
- Rutas de imagen con `\` (rotas) y `m&m.png`; imágenes de hasta 3 MB reducidas (de 15 MB a 1,8 MB en total).

**Funcionamiento**
- Registro: el campo se llamaba distinto en el formulario y en el servidor, no se guardaban teléfono ni tipo, y cualquiera podía registrarse como «Empleado».
- Carrito: la ruta `/cart` estaba duplicada y apuntaba a una vista inexistente; el usuario se leía del formulario (manipulable); no había stock ni confirmación de reserva.
- Modal de producto: usaba jQuery/Bootstrap que no estaban cargados en esa página, un id duplicado y variables fuera de su bucle. Sustituido por un modal con Alpine.
- Se había sobrescrito el componente `modal` de Breeze (rompía «Borrar cuenta»); restaurado.
- Contraseñas cifradas dos veces (`Hash::make` + cast `hashed`).
- Faltaba la carpeta `lang/`: errores como `auth.failed`. Añadido el español.
- Portada: HTML sin cerrar y posiciones absolutas en píxeles (`top: 1250px`) que rompían el diseño; ahora es responsive.
- Eliminado código muerto (`UserController`, vistas y JS sin uso, archivos basura `datetime,` y `hashed,`).
