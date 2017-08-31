FROM nginx

#COPY ./bonjourausy.com /etc/nginx/sites-available/bonjourausy.com
#RUN ln -s /etc/nginx/sites-available/bonjourausy.com /etc/nginx/sites-enabled/bonjourausy.com 

#COPY ./nginx.conf /etc/nginx/nginx.conf
#COPY ./proxy.conf /etc/nginx/conf.d/proxy.conf
COPY ./php7_fpm.conf /etc/nginx/conf.d/default.conf
COPY ./bonjourausy.conf /etc/nginx/conf.d/bonjourausy.conf