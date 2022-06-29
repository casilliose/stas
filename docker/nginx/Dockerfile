FROM nginx:1.21.4

USER root

RUN apt-get update && apt-get -y --no-install-recommends install \
    wget  \
    make  \
    build-essential  \
    manpages-dev  \
    libpcre3-dev  \
    zlib1g-dev  \
    libssl-dev  \
    libxslt-dev  \
    libgd-dev  \
    libgeoip-dev  \
    libperl-dev

CMD ["/bin/sh", "-c", "nginx -g 'daemon off;'"]