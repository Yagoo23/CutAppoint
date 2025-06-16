# CutAppoint - Sistema de Gestión de Citas

## 🚀 Arquitectura de la Aplicación

### Descripción General

CutAppoint implementa una arquitectura MVC (Modelo-Vista-Controlador) que proporciona una clara separación de responsabilidades y un código mantenible.
Esta separación de responsabilidades facilita el mantenimiento del código, su escalabilidad y la reutilización de componentes, ya que cada parte tiene una función bien definida y los cambios en una no afectan directamente a las demás. Por lo tanto, la arquitectura MVC proporciona una base sólida y mantenible para el desarrollo.

### Estructura del Proyecto
```
📁 CutAppoint/
├── 📁 controllers/     # Controladores que manejan la lógica de negocio
├── 📁 models/         # Modelos que interactúan con la base de datos
├── 📁 views/          # Vistas que renderizan la interfaz de usuario
├── 📁 public/         # Archivos públicos accesibles (CSS, JS, imágenes)
└── 📁 includes/       # Utilidades y configuraciones del sistema
```

### Flujo de la Aplicación

1. **Entrada**: El usuario accede a una URL específica
2. **Enrutamiento**: El Router analiza la URL y dirige la petición
3. **Procesamiento**: El Controlador maneja la petición utilizando los Modelos
4. **Datos**: Los Modelos interactúan con la base de datos MySQL
5. **Presentación**: El Controlador envía datos a la Vista correspondiente
6. **Respuesta**: La Vista genera el HTML final para el usuario

### Tecnologías Principales

- **Backend**: 
  - PHP con arquitectura MVC
  - MySQL como sistema de base de datos
  - Composer para gestión de dependencias

- **Frontend**:
  - HTML5 para estructura
  - SCSS para estilos
  - JavaScript para interactividad
  - Gulp como herramienta de construcción

Esta arquitectura está diseñada para facilitar:
- Desarrollo modular
- Mantenibilidad del código
- Escalabilidad del proyecto
- Testing efectivo
- Separación clara de responsabilidades



### Diagrama de componentes
![alt text](image.png)


