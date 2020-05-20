FROM php:7.4-fpm-alpine
# this dockerfile has been optimized for build time on your local machine
# you may want to use https://github.com/google/mtail/blob/master/Dockerfile for production
RUN wget https://github.com/google/mtail/releases/download/v3.0.0-rc16/mtail_v3.0.0-rc16_linux_amd64 -O mtail && \
    chmod +x mtail && \
    mkdir /etc/mtail && \
    mv mtail /usr/bin/ && \
    apk add --no-cache libc6-compat
COPY ./application_logs.mtail /etc/mtail/
COPY ./run.sh .
RUN chmod +x run.sh

ENTRYPOINT ["./run.sh"]

