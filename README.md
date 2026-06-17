# API Ministerio de Salud - VJ21002

API REST con Slim Framework para gestionar Doctores y Hospitales.

## Requisitos

- PHP 8.x
- Composer
- MySQL (XAMPP)

## Instalacion local

1. Importar `VJ21002Clave2.sql` en phpMyAdmin.
2. Copiar `.env.example` a `.env` y ajustar credenciales.
3. Ejecutar:

```bash
composer install
composer start
```

La API quedara en `http://localhost:8080`

## Endpoints

| Metodo | Ruta | Descripcion |
|--------|------|-------------|
| GET | /doctores | Listar todos los doctores |
| POST | /doctores | Registrar doctor |
| GET | /hospitales/{id} | Obtener hospital por ID |
| POST | /hospitales | Registrar hospital |

## Ejemplo POST /doctores

```json
{
  "nombre": "Ana",
  "apellido": "Garcia",
  "num_colegiado": "COL-20001",
  "id_hospital": 1
}
```

## Ejemplo POST /hospitales

```json
{
  "nombre_hospital": "Hospital Metropolitano",
  "direccion": "San Salvador",
  "telefono": "2222-4444",
  "id_especialidad": 2
}
```
