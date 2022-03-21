FROM node:14.18.1

RUN npm install -g http-server
WORKDIR /web-frontend
RUN apt-get update

EXPOSE 8080
ENTRYPOINT [ "deployment/development/entrypoint.sh" ]
