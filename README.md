# Instalación
- Añadir el trait `Bloggable` en la entidad que puede poseer el blog.
- Añadir el trait `BlogAuthor` en el modelo que puede crear publicaciones del blog.
- Bloggable debe definir elmétodo createBlogPolicy o en su defecto el metodo createBlog para personalizar la creación del blog


# Despliegue LAMBDA
En el directorio de .lambda encontrará algunos scripts que deberá poner en su propio servidor lambda para incluir funcionalidades de IA y procesamiento.