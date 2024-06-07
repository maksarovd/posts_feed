# Feed of the posts


info: This is example of realization testing job, make for DzenCode
     
vendor: [Maksarov Dmitriy](https://github.com/maksarovd)

##how to deploy:

 1 **clone** this project to **you local folder**
  
   ```
   git clone git@github.com:maksarovd/posts_feed.git
   ``` 
 2 **run deployment** via docker-compose **from you local folder**
   
   ```
   docker-compose up -d --build
   ```  
3 cut  **.env** file from **.env,example**  to project root (remember **host name - is service name** into docker-compose.yaml)

  DB_CONNECTION=mysql
  
  DB_HOST=mysql
  
  DB_PORT=3306
  
  DB_DATABASE=database
  
  DB_USERNAME=maksarovd
  
  DB_PASSWORD=1

4 **run deploy command from you php container**

  ```
  composer install && php artisan migrate && npm install && npm run build && npm run dev  
  ```   
5 get permission to project **run deploy command from you php container**
 ```
  chown -R www-data:www-data vendor && chown -R www-data:www-data storage && php artisan key:generate
  
  ``` 
6 run  **npm run dev** and exit to load vite breeze frontend and link media folder
```
php artisan storage:link

``` 


##instructions:
  
  - To **testing functionality** go to [this VPS](http://bloogger.space/) or **deploy you local copy** 
  
  - **User** need be logged, with field homepage
    
  - **User** can create  **Comment**
    
  - **User** can **Sort Comments** by **User Name | E-mail | Created_at (ASC/DESC)**
    
  - **User** can add a **Picture** to **Comments**  or text file
  
  - **User** can add accessible **HTML** tags like **a | code | strong | i** via **Buttons**
  
  - **User** can check out **markdown mode** to **text mode** to seen how will **Comments** look
  
  - **User** can **edit and delete** own **Comments**
  
 
    