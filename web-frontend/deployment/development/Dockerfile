FROM node

RUN npm install -g http-server
WORKDIR /web-frontend
RUN apt-get update

EXPOSE 8080
ENTRYPOINT [ "deployment/development/entrypoint.sh" ]