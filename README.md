# API REST de Ventas

Este proyecto es una API RESTful desarrollada con Laravel para la gestión de ventas, productos y generación de reportes.


# 📌 Características principales

✅ Autenticación y autorización con JWT ✅ 
Gestión de usuarios y roles (Administrador y Vendedor) 
✅ CRUD de productos con control de stock 
✅ Registro de ventas con cálculo automático del monto total 
✅ Generación de reportes en JSON y XLSX 
✅ Seguridad con validaciones, cifrado de contraseñas y control de permisos

## Instrucciones de Instalación y Ejecución 
1. **Requisitos:** 
	* Asegúrate de tener instalado XAMPP, PHP 8.1, Composer, MySql. 
	* Clona el repositorio: `git clone https://github.com/RenatoDesarrollo1/reto-tecnico.git` 
	* Accede al directorio del proyecto: `cd reto-tecnico` 
	* Copia el archivo `.env.example` a `.env` y configura las variables de entorno necesarias para la conexión a la base de datos.
2. **Instalación de dependencias:** 
	* Instala las dependencias de Composer: `composer install`
3. **Configuración:**
	 * Genera la clave de la aplicación: `php artisan key:generate` 
	 * Ejecuta las migraciones de la base de datos: `php artisan migrate`
4. **Configuraciones adicionales:** 
	* **JWT:** 
		 * Genera la clave secreta: `php artisan jwt:secret`  
5. **Ejecución:**
	 * Inicia el servidor de desarrollo: `php artisan serve` 

## Diseño y Decisiones Técnicas 
 * **Arquitectura:** 
 	* **MVC (Modelo-Vista-Controlador):** 
		 El proyecto sigue la arquitectura MVC estándar de Laravel, separando la lógica de negocio, la presentación y el acceso a datos en componentes distintos. 
	* **API RESTful:** La aplicación expone una API RESTful para la comunicación entre el frontend y el backend, utilizando 		los principios de REST para una interfaz uniforme y escalable.
 * **Tecnologías:** 
	 * Framework: [Laravel 10] 
	 * Base de datos: [MySQL] 
	 * Autenticación: [JWT] 
	 * Autorización: [Spatie Permission] 
	* Generación de reportes: [Laravel Excel] 
* **Patrones de diseño:** 
	 * **Servicio:** Los servicios contienen la lógica de negocio de la aplicación. Esto mejora la organización del código y promueve la reutilización de la lógica de negocio, no se implementaron Repositorios debido a que Eloquent proporciona los métodos necesarios para el acceso a la base de datos, de esta manera evitamos repetir código.
* **Decisiones técnicas:** 
	* **Autenticación JWT:** Se eligió JWT para la autenticación debido a su seguridad, escalabilidad y facilidad de uso en APIs RESTful. JWT permite que el cliente reciba un token después de iniciar sesión y lo utilice para acceder a rutas protegidas. 
	* **Autorización con Spatie Permission:** Se utiliza Spatie Permission para gestionar roles y permisos en la aplicación. Esto permite definir roles (ej: "administrador", "vendedor") y asignar permisos a esos roles, controlando quién tiene acceso a qué funcionalidades. 
	* **Generación de reportes con Laravel Excel:** Se implementó Laravel Excel para la generación de reportes en diferentes formatos (ej: Excel, CSV). Esto simplifica la creación de reportes personalizados con datos de la aplicación. 
	* **Transacciones de base de datos:** Se utilizan transacciones de base de datos para asegurar la integridad de los datos en operaciones que involucran múltiples consultas. Si alguna consulta falla, se revierte toda la operación, evitando inconsistencias en la base de datos. 
	*  **Validación de Requests:** Se utilizan `Request` en Laravel para validar los datos que llegan desde las solicitudes del usuario antes de que sean procesados por la aplicación. Esto ayuda a prevenir errores y a garantizar que los datos cumplan con ciertos criterios. 
	* **Manejo de excepciones:** Se ha implementado un buen manejo de excepciones, lo que permite capturar errores y mostrar mensajes informativos al usuario o realizar acciones específicas en caso de error. (Exception/Handler.php)
	* **Uso de índices** Se ha implementado indices en ciertas consultas como el login y el reporte de ventas, esto optimizará dichas las consultas.

[Diagrama Entidad Relación](https://imgur.com/OGxQv7T)
[Video explicación](https://youtu.be/apKXbZvrKWk)