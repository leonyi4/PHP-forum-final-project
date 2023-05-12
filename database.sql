CREATE TABLE posts (
  postId int(10) unsigned NOT NULL AUTO_INCREMENT,
  parentId int(10) unsigned DEFAULT NULL,
  title varchar(50) NOT NULL,
  postedDate date NOT NULL,
  message varchar(2000) NOT NULL,
  posterName varchar(30) NOT NULL,
  PRIMARY KEY (postId)
) 
--- change the
-------
INSERT INTO posts(title,message,posterName,postedDate) values('testTitle',"testMessage",'leo',2020-04-27);
INSERT INTO posts(title,message,parentId,posterName,postedDate,parentId) values('testComment','testCommentMessage','leo',2020-04-27,1);

-----
CREATE TABLE users (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  username varchar(30) NOT NULL,
  email varchar(5000) NOT NULL,
  password varchar(50) NOT NULL,
  createdDate date NOT NULL,
  comments int(11) NOT NULL DEFAULT 0,
  posts int(11) NOT NULL DEFAULT 0,
  profilePic varchar(9999) NOT NULL DEFAULT 'images/happy_ye.gif',
  PRIMARY KEY (id)
)
--- added any picture to the images folder and change the name to set any default picture
----
INSERT INTO users (email,username,password) VALUE('admin@nimda','admin','password');
INSERT INTO users (email,username,password) VALUE('leo@gmail.com','leo','leo123');
INSERT INTO users (email,username,password) VALUE('test@co','testuser1','test123');
INSERT INTO users (id, username, email, password, createdDate, comments, posts, profilePic) VALUES ('elon', 'twitter@co', 'twitter', '2023-05-13', '0', '0', 'images/happy_ye.gif');


