FROM nginx:1.21.3-alpine

RUN apk update \
    && apk add bash \
    && rm -f /etc/nginx/conf.d/*.conf

COPY deployment/development/nginx.conf  etc/nginx/nginx.conf
COPY deployment/development/site.conf   etc/nginx/conf.d/site.conf
#COPY deployment/development/site.conf   etc/nginx/conf.d/default.conf
