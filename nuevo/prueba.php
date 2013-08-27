
1000 usuarios conectados no es lo mismo 1000 conexiones simultáneas (aunque lo parezca)

Apache de paquete solo soporta hasta 256 conexiones simultáneas, pero tus 1000 usuarios no van a estar recargando las páginas cada segundo, por lo que el apache bien optimizado puede funcionar.

Donde debes ser cuidadoso es con MySQL, es generalmente el que más recursos demanda, de ser posible y económicamente factible yo recomendaría dos servidores uno solo para MySQL y otro para el resto.

Sugerencias:

Dividir la carga en 2 servidores de no ser posible dividir la carga por discos duros, un disco en donde solo pondrás la partición usada por MySQL y el otro disco para el resto.

Apache compilado para soportar más de 256 conexiones (por si acaso)
Cache de PHP, recomiendo eaccelerator

En cuanto al hardware, cualquier servidor de gama alta será suficiente o dos de gama medía.

Mi sugerencia en hardware sería

2 Dual XEON o 1 QuadCore XEON (si puedes con un dual quadcore mucho mejor)
2 Discos Duros
4 GB en ram



