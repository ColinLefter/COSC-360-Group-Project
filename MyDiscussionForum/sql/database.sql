-- NEEDS REVIEW
-- NOTE: if you have extra data, make sure to save it!
DROP DATABASE mydiscussionforum;
CREATE DATABASE mydiscussionforum;

USE mydiscussionforum;

CREATE TABLE user (
    userId int NOT NULL AUTO_INCREMENT,
    userName VARCHAR(30),
    firstName VARCHAR(30),
    lastName VARCHAR(30),
    email VARCHAR(30),
    password VARCHAR(32), -- Password is always 32 hex values long, (128-bit md5)
    PRIMARY KEY (userId)
);

CREATE TABLE userDetails (
    userId int NOT NULL,
    useLightMode boolean,
    userAuthority int DEFAULT 0, -- For now, 0 = normal user, 1 = moderator, 2 = admin
    isBanned boolean DEFAULT 0,
    accountDate DATE DEFAULT CAST(NOW() AS DATE),
    dateOfBirth DATE,
    bio VARCHAR(250),
    profilePicName VARCHAR(50) DEFAULT 'default.png',
    FOREIGN KEY(userId) REFERENCES user(userId)
    ON DELETE CASCADE
);

CREATE TABLE community (
    communityId int NOT NULL AUTO_INCREMENT,
    communityName VARCHAR(30),
    postCount int DEFAULT 0,
    description VARCHAR(250),
    PRIMARY KEY(communityId)
);

-- TODO: FIX THIS TRIGGER
-- CREATE TRIGGER incrementPostCount 
--     AFTER INSERT ON post
--     FOR EACH ROW
--     UPDATE community SET postCount = postCount + 1 WHERE post.communityId == community.communityId;

CREATE TABLE post (
    postId int NOT NULL AUTO_INCREMENT,
    authorId int,
    authorName VARCHAR(30),
    communityId int,
    postTitle VARCHAR(100),
    postContent TEXT, -- BLOB stores as binary data, but can store images and such, otherwise change this to TEXT
    creationDate DATETIME DEFAULT NOW(),
    PRIMARY KEY(postId),
    FOREIGN KEY(authorId) REFERENCES user(userId),
    FOREIGN KEY(communityId) REFERENCES community(communityId)
);

CREATE TABLE comment (-- Basically the same 
    postId int NOT NULL,
    commentId int NOT NULL AUTO_INCREMENT,
    parentId int, -- if NULL, postId is the parent
    authorId VARCHAR(30),
    commentContent BLOB,
    creationDate DATETIME DEFAULT NOW(),
    PRIMARY KEY(commentId),
    FOREIGN KEY(postId) REFERENCES post(postId)
    ON DELETE CASCADE,
    FOREIGN KEY(parentId) REFERENCES comment(commentId)
);

CREATE TABLE tag (
    postId int NOT NULL,
    tagName VARCHAR(10) NOT NULL,
    tagDesc VARCHAR(100),
    FOREIGN KEY(postId) REFERENCES post(postId)
);

-- Sample data (users)
-- Does not matter that the password is hashed, since its only for consistency
INSERT INTO user (userName, firstName, lastName, email, password) VALUES ('jsmith', 'John', "Smith", 'john@smith.com', 'password1');
INSERT INTO user (userName, firstName, lastName, email, password) VALUES ('jparish', 'Jarod', "Parish", 'jparish@example.com', 'password2');
INSERT INTO user (userName, firstName, lastName, email, password) VALUES ('jdoe', 'Jane', "Doe", 'jane@doe.com', 'password3');
INSERT INTO user (userName, firstName, lastName, email, password) VALUES ('tcruise', 'Tom', "Cruise", 'tom@gmail.com', 'password4');
INSERT INTO user (userName, firstName, lastName, email, password) VALUES ('rmcdonald', 'Ronald', "Mcdonald", 'ronald@mcdonald.com', 'password5');
INSERT INTO user (userName, firstName, lastName, email, password) VALUES ('jjjschmidt', 'John', "Schmidt", 'john@gmail.com', 'hisnameismynametoo');
INSERT INTO user (userName, firstName, lastName, email, password) VALUES ('dmartinez', 'David', "Martinez", 'david@militech.com', 'punkcyber');
INSERT INTO user (userName, firstName, lastName, email, password) VALUES ('roppenheimer', 'Robert', "Oppenheimer", 'rob@boom.com', 'Iambecomedeath');
INSERT INTO user (userName, firstName, lastName, email, password) VALUES ('bross', 'Bob', "Ross", 'Bob@gmail.com', 'illaddafunnylittlecloud');

-- Sample data (community)
INSERT INTO community (communityName, description) VALUES ('general', 'A place for general topics, ideas, and such.');

-- Sample data (posts)
INSERT INTO post (authorId, authorName, communityId, postTitle, postContent) VALUES ('1', 'jsmith,', '1', 'This is my first post', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
INSERT INTO post (authorId, authorName, communityId, postTitle, postContent) VALUES ('2', 'jparish,', '1', 'Should I get training before I base jump?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
INSERT INTO post (authorId, authorName, communityId, postTitle, postContent) VALUES ('3', 'jdoe,', '1', 'Why does everyone think my name sounds funny', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
INSERT INTO post (authorId, authorName, communityId, postTitle, postContent) VALUES ('4', 'tcruise,', '1', 'I accidently dropped my database. What do?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
INSERT INTO post (authorId, authorName, communityId, postTitle, postContent) VALUES ('5', 'rmcdonald,', '1', 'Hot take: McChickens are better than big macs.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
INSERT INTO post (authorId, authorName, communityId, postTitle, postContent) VALUES ('6', 'jjjschmidt,', '1', 'Everyone thinks my name is a joke', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
INSERT INTO post (authorId, authorName, communityId, postTitle, postContent) VALUES ('7', 'dmartinez', '1', 'I got to moon :)', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
INSERT INTO post (authorId, authorName, communityId, postTitle, postContent) VALUES ('8', 'roppenheimer', '1', 'Everyone is comparing me to barbie', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
INSERT INTO post (authorId, authorName, communityId, postTitle, postContent) VALUES ('9', 'bross', '1', 'Nature is beautiful.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');