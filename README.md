# Halcon - Sistema de Gestión de Pedidos

Este es un proyecto Laravel para la gestión de pedidos en un sistema de almacén. Incluye funcionalidades para usuarios registrados y no registrados, con módulos para usuarios, pedidos y pedidos archivados.

## Vistas

### Vistas para Usuarios No Registrados

- **Página principal (Home)**: Incluye un formulario de búsqueda por número de factura.
  - Si el pedido está en estado "entregado", se muestra la foto de entrega.
  - Si el pedido está en estado "en proceso", se muestra el nombre del proceso y la fecha.

### Vistas para Usuarios Registrados (Protegidas)

- **Dashboard**:
  - Panel principal con enlaces de navegación a:
    - Usuarios
    - Pedidos
    - Pedidos archivados

- **Módulo de Usuarios**:
  - Lista general de usuarios (activos e inactivos).
  - Creación de usuarios con opción de asignar rol o departamento.
  - Edición de usuarios para modificar datos básicos, cambiar departamento o estado (activo/inactivo).

- **Módulo de Pedidos**:
  - Lista general de pedidos ordenados.
  - Creación de pedidos.
  - Actualización de pedidos.
  - Cambio de estado del pedido.
  - Visualización del pedido.
  - Eliminación lógica de pedidos.

- **Pedidos Archivados**:
  - Lista de pedidos eliminados lógicamente.
  - Opción para restaurar pedidos archivados.
