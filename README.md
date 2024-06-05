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
3 **run deploy command from you php container**

  ```
  docker-compose exec php bash
  
  composer install && php artisan migrate && npm install && npm run build && npm run dev  
  ```   
4 add  **.env** file to project root (remember **host name - is service name** into docker-compose.yaml)

##instructions:
  
  - To **testing functionality** go to [this VPS](http://bloogger.space/) or **deploy you local copy** todo//add httpasswd
  
  - **User** need be logged, so a added some users and give they credentials
    
  - **User** can create **Posts** or create **Comment** to answer to **Post** 
    
  - **User** can **Sort Posts** by **User Name | E-mail | Created_at (ASC/DESC)**
    
  - **User** can add a **Picture** to **Post** text field
  
  - **User** can add accessible **HTML** tags like **a | code | strong | i** via **Buttons**
  
  - **User** can check out **markdown mode** to **text mode** to seen how will **Post** look
  
  - **User** can **edit and delete** own **Post**
  
 
    