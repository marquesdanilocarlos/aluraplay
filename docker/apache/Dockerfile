ARG APACHE_VERSION=""
FROM httpd:${APACHE_VERSION:+${APACHE_VERSION}-}alpine
RUN apk update; \
    apk upgrade;
RUN apk add \
  bash \
  apache2 \
  php${PHP_VERSION}-apache2 \
  curl \
  ca-certificates \
  openssl \
  tzdata \
  openntpd;
RUN sed -i "s/#LoadModule\ rewrite_module/LoadModule\ rewrite_module/" /usr/local/apache2/conf/httpd.conf;
#COPY ~/.bashrc /root/.bashrc
# Copy apache vhost file to proxy php requests to php-fpm container
COPY demo.apache.conf /usr/local/apache2/conf/demo.apache.conf
RUN echo "Include /usr/local/apache2/conf/demo.apache.conf" \
    >> /usr/local/apache2/conf/httpd.conf
