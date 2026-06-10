
---

# 💸 GestorGastos

Un proyecto de aplicación web diseñado para registrar, administrar y visualizar gastos personales mediante un sistema de usuarios. Está construido con un stack de PHP y MariaDB, utilizando Docker para facilitar su despliegue y desarrollo.

---

## 🚀 Características Principales

* **Registro Intuitivo de Gastos:** Permite a los usuarios ingresar el monto exacto, seleccionar una categoría de un menú desplegable, añadir una descripción o nota, y establecer la fecha del gasto.
* **Visualización y Gráficos:** Incluye un panel de resumen que muestra el gasto total del usuario y un gráfico interactivo (tipo "doughnut" mediante Chart.js) para analizar visualmente la distribución del dinero por categoría.
* **Gestión de Sesiones:** Sistema de protección de rutas y cierre de sesión para asegurar que los datos del usuario se mantengan privados.
* **Interfaz Moderna e Intuitiva:** Diseño adaptable, limpio y responsivo, construido sobre Bootstrap 5.3 e integrado con Bootstrap Icons.

---

## 🛠️ Tecnologías Utilizadas

* **Frontend:** HTML5, CSS (Bootstrap 5.3), JavaScript (Chart.js para renderizado de gráficos).
* **Backend:** PHP 8+ utilizando PDO (PHP Data Objects) para manejar conexiones seguras a la base de datos mediante sentencias preparadas.
* **Base de Datos:** MariaDB (última versión).
* **Infraestructura:** Docker y Docker Compose para orquestar los servicios del servidor web, la base de datos y la interfaz de administración.

---

## ⚙️ Requisitos y Ejecución

Gracias a Docker Compose, levantar el entorno completo (servidor web, base de datos y gestor de BD) es un proceso directo.

### 1. Requisitos Previos

* Tener **Docker** y **Docker Compose** instalados en tu sistema.

### 2. Puesta en marcha

Abre una terminal en la raíz de tu proyecto (donde se encuentra el archivo `docker-compose.yml`) y ejecuta el siguiente comando:

```bash
docker-compose up -d --build

```

### 3. Accesos

Una vez que los contenedores estén en ejecución, podrás acceder a los servicios a través de tu navegador:

* **Aplicación Web:** `http://localhost` (Mapeado al puerto 80).
* **phpMyAdmin (Gestor de Base de Datos):** `http://localhost:8081`.

> **Nota importante sobre la Base de Datos:**
> La aplicación está configurada para conectarse al host `mariadb-dam` con el usuario `root` y contraseña `root`, buscando específicamente una base de datos llamada `GestorGastos`. Para que la aplicación funcione en su totalidad, es necesario importar o crear la estructura de las tablas correspondientes (`usuarios`, `categorias` y `gastos`) utilizando phpMyAdmin u otro cliente SQL.