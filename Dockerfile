FROM node:12.3.1-alpine
ARG DIRECTORY

ADD package.json package-lock.json /tmp/
RUN cd /tmp && npm install
RUN mkdir -p /webpack && cd /webpack && ln -s /tmp/node_modules && ln -s /tmp/package.json && ln -s /tmp/package-lock.json
WORKDIR /webpack
COPY webpack.config.js .
COPY tsconfig.json .
COPY assets ./assets