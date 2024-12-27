FROM php:8.2-cli-alpine

RUN apk --no-cache add \
    wget \
    bash \
    && wget https://phpdoc.org/phpDocumentor.phar -O /usr/local/bin/phpdoc \
    && chmod +x /usr/local/bin/phpdoc

WORKDIR /data

ENTRYPOINT ["phpdoc"]
