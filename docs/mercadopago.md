Revocar y rotar token de MercadoPago

Pasos recomendados para revocar un Access Token de MercadoPago y reemplazarlo por uno nuevo:

1. Ingresar al panel de MercadoPago: https://www.mercadopago.com.ar/
2. Ir a la sección de credenciales / integraciones (Mi cuenta -> Credenciales o Developers -> Credenciales).
3. Identificar la aplicación que está usando el access token actual.
4. Revocar o regenerar el token desde el panel (opción "Regenerar" o "Revocar").
5. Actualizar el archivo `.env` local reemplazando `MERCADO_PAGO_ACCESS_TOKEN=` con el nuevo token.
6. Nunca subir el token a un repositorio público. Agregar la variable a `.env.example` con valor vacío.
7. Para producción, usar un gestor de secretos del hosting (no poner tokens en repositorios).

Comandos útiles (local):

- Editar `.env` y dejar la variable vacía o con el nuevo valor.

Si querés, puedo:
- Quitar cualquier token existente del `.env` en este repo (si hay alguno),
- Añadir una validación que falle si `MERCADO_PAGO_ACCESS_TOKEN` no está configurado en entornos `production`,
- O crear una tarea en `README.md` explicando cómo configurar MercadoPago.
