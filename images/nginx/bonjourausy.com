server {
  listen 8000;
  server_name www.bonjourausy.com;
  
  root /usr/src/app;
  index index.html;

  location / {
    try_files $uri $uri/ /index.html;

    proxy_pass http://angular4;
    proxy_http_version 1.1;
    proxy_set_header Host $host;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header X-Forwarded-Proto $scheme;

    if($request_method = 'OPTIONS') {
      add_header 'Access-Control-Allow-Origin' '*';
      add_header 'Access-Control-Allow-Origin' 'GET, POST, OPTIONS';

      add_header 'Access-Control-Allow-Headers' 'DNT, X-CustomHeader,Keep-Alive, User-Agent, X-Requested-With, If-Modified-Since, Cache-Control, Content-Type, Content-Range, Range';

      add_header 'Access-Control_Max_Age' 1728000;
      add_header 'Content_Type' 'text/plain;charset=utf-8';
      add_header 'Content-Length' 0;
      return 204;
    }

    if($request_method = 'POST') {
      add_header 'Access-Control-Allow-Origin' '*';
      add_header 'Access-Control-Allow-Methods' 'GET,POST,OPTIONS';
      
      add_header 'Access-Control-Allow-Headers' 'DNT,X-CustomHeader,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,Content-Range,Range';
          
      add_header 'Access-Control-Expose-Headers' 'DNT,X-CustomHeader,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cahce-Control,Content-Type,Content-Range,Range';
    }

    if($request_method = 'GET') {
      add_header 'Access-Control-Allow-Origin' '*';
      add_header 'Access-Control-Allow-Methods' 'GET,POST,OPTIONS';
      
      add_header 'Access-Control-Allow-Headers' 'DNT,X-CustomHeader,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,Content-Range,Range';
          
      add_header 'Access-Control-Expose-Headers' 'DNT,X-CustomHeader,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cahce-Control,Content-Type,Content-Range,Range';
    }
  }
}