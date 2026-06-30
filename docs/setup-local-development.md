## Optional: Nginx Proxy Manager Integration

Create docker-compose.local.yml

```yaml
services:
  nginx:
    networks:
      - default
      - web-gateway

networks:
  web-gateway:
    external: true