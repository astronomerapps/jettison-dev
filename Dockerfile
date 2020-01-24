FROM node:12.3.1-alpine
ARG DIRECTORY

ADD package.json package-lock.json /tmp/
RUN cd /tmp && npm install
RUN mkdir -p /webpack
WORKDIR /webpack
COPY . .
RUN ln -s /tmp/node_modules /webpack/node_modules