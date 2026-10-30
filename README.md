# app-http

Aplicación didáctica para analizar peticiones y respuestas HTTP mediante Telnet, curl, Wireshark y las herramientas de desarrollo del navegador.

## Estructura del repositorio

```text
app-http/
|-- app/          # Aplicación publicada por el servidor web
|-- compose.yaml  # Despliegue con Docker Compose
|-- .gitignore
`-- README.md
```

## Despliegue con Docker Compose

Clona el repositorio publicado en GitHub:

```bash
git clone https://github.com/alvarogarcialdv/app-http.git
cd app-http
docker compose up -d
docker compose ps
```

La aplicación queda publicada en el puerto 80:

```text
http://IP_DEL_SERVIDOR/index.html
```

Para consultar los registros o retirar el contenedor:

```bash
docker compose logs --tail=20
docker compose down
```

## Publicación directa con Apache

En un servidor de laboratorio dedicado también se puede publicar el contenido de `app/` directamente:

```bash
sudo apt update
sudo apt install -y apache2 php libapache2-mod-php
sudo cp -a app/. /var/www/html/
sudo chmod -R a+rX /var/www/html
sudo systemctl enable --now apache2
sudo systemctl restart apache2
```

### Servidor Apache y PHP ya preparado mediante SSH

Si el servidor ya tiene Apache y PHP instalados y configurados, puedes transferir la aplicación desde el equipo donde clonaste el repositorio. Ejecuta estos comandos desde la carpeta `app-http` y sustituye `USUARIO` y `SERVIDOR` por los datos de acceso SSH:

```bash
ssh USUARIO@SERVIDOR "mkdir -p ~/app-http-upload"
scp -r app/. USUARIO@SERVIDOR:~/app-http-upload/
ssh USUARIO@SERVIDOR
sudo cp -a ~/app-http-upload/. /var/www/html/
sudo chmod -R a+rX /var/www/html
sudo systemctl reload apache2
exit
```

La cuenta SSH debe poder utilizar `sudo`. Si el sitio utiliza un `DocumentRoot` distinto de `/var/www/html/`, sustituye esa ruta en los comandos.
