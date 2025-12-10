# DrPitbike Platform

## Configuración rápida
1. Clona el repositorio en el hosting compartido.
2. Sube el contenido a la carpeta pública del hosting y apunta el dominio a `public/`.
3. Ejecuta el script `database_schema.sql` en la base de datos MySQL proporcionada.
4. Configura el archivo `config/config.local.php` (no versionado) con las credenciales definitivas o exporta las variables de entorno:

```php
<?php
return [
    'database' => [
        'host' => 'database-5019176865.webspace-host.com',
        'name' => 'dbs15058228',
        'user' => 'dbu5603976',
        'password' => '4Ntr4c1t4!',
    ],
];
```

> **Importante:** Mantén la contraseña fuera del repositorio:
> - Define las variables de entorno `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASSWORD`.
> - O utiliza `config/config.local.php`, que está en `.gitignore`, asegurando permisos restringidos.

## Requisitos
- PHP 8.0+ con extensiones PDO MySQL, cURL y JSON.
- Servidor web con soporte para `.htaccess` o reglas de rewrite equivalentes.
- MySQL 8.0.

## Próximos pasos
- Integrar Stripe Checkout y webhook real.
- Añadir pruebas automáticas y validación CSRF antes de producción.
- Configurar despliegue automatizado con copia de backup de la base de datos.
