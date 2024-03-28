-- NEEDS REVIEW
-- NOTE: if you have extra data, make sure to save it!
-- DROP DATABASE mydiscussionforum;
CREATE DATABASE mydiscussionforum;
USE mydiscussionforum;

-- If you are importing onto cosc360.ok.ubc.ca, change the number to your student number.
-- USE db_20286563;

CREATE TABLE user (
    userId int NOT NULL AUTO_INCREMENT,
    userName VARCHAR(30),
    firstName VARCHAR(30),
    lastName VARCHAR(30),
    email VARCHAR(30),
    password VARCHAR(255), -- We are storing hashed passwords and these can be up to 255 characters long.
    PRIMARY KEY (userId)
);

CREATE TABLE userDetails (
    userId int NOT NULL,
    useLightMode boolean DEFAULT 1,
    userAuthority int DEFAULT 0, -- For now, 0 = normal user, 1 = moderator, 2 = admin
    isBanned boolean DEFAULT 0,
    accountDate TIMESTAMP NOT NULL DEFAULT NOW(),
    dateOfBirth DATE,
    bio VARCHAR(250),
    profilePicFileName VARCHAR(50) DEFAULT 'default.png',
    FOREIGN KEY(userId) REFERENCES user(userId)
    ON DELETE CASCADE
);

CREATE TABLE community (
    communityId int NOT NULL AUTO_INCREMENT,
    communityName VARCHAR(30),
    postCount int DEFAULT 0,
    communityViews int DEFAULT 0,
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
    -- authorName VARCHAR(30), -- Removed, can pull from user
    communityId int,
    postTitle VARCHAR(100),
    postContent TEXT, -- BLOB stores as binary data, but can store images and such, otherwise change this to TEXT
    creationDate TIMESTAMP DEFAULT NOW(),
    postViews int DEFAULT 0,
    PRIMARY KEY(postId),
    FULLTEXT INDEX (postTitle),
    FULLTEXT INDEX (postContent),
    FOREIGN KEY(authorId) REFERENCES user(userId),
    FOREIGN KEY(communityId) REFERENCES community(communityId)
);

CREATE TABLE comment (-- Comments belong to a parent post
    postId int NOT NULL,
    commentId int NOT NULL AUTO_INCREMENT,
    userId int NOT NULL,
    parentId int, -- if NULL, postId is the parent
    -- authorId VARCHAR(30),
    commentContent BLOB,
    creationDate TIMESTAMP DEFAULT NOW(),
    PRIMARY KEY(commentId),
    FOREIGN KEY(postId) REFERENCES post(postId)
    ON DELETE CASCADE, -- Only delete a comment if its post is deleted. If the parent comment is deleted, keep the comment.
    FOREIGN KEY(parentId) REFERENCES comment(commentId),
    FOREIGN KEY(userId) REFERENCES user(userId)
);

CREATE TABLE topic (
    postId int NOT NULL,
    topicName VARCHAR(10) NOT NULL,
    topicDesc VARCHAR(100),
    FOREIGN KEY(postId) REFERENCES post(postId)
);

-- Modify as necessary
CREATE TABLE statistic (
    statisticDate DATE,
    dailyVisitors int
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
INSERT INTO community (communityName, description) VALUES ('sports', 'Football, soccer, baseball, et cetera.');
INSERT INTO community (communityName, description) VALUES ('computer science', 'Discussion for computer science topics.');

-- Sample data (posts)
INSERT INTO post (authorId, communityId, postTitle, postContent) VALUES ('1', '1', 'This is my first post', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
INSERT INTO post (authorId, communityId, postTitle, postContent) VALUES ('3', '1', 'Why does everyone think my name sounds funny', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
INSERT INTO post (authorId, communityId, postTitle, postContent) VALUES ('2', '1', 'Should I get training before I base jump?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
INSERT INTO post (authorId, communityId, postTitle, postContent) VALUES ('4', '1', 'I accidently dropped my database. What do?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
INSERT INTO post (authorId, communityId, postTitle, postContent) VALUES ('5', '1', 'Hot take: McChickens are better than big macs.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
INSERT INTO post (authorId, communityId, postTitle, postContent) VALUES ('6', '1', 'Everyone thinks my name is a joke', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
INSERT INTO post (authorId, communityId, postTitle, postContent) VALUES ('7', '1', 'I got to moon :)', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
INSERT INTO post (authorId, communityId, postTitle, postContent) VALUES ('8', '1', 'Everyone is comparing me to barbie', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
INSERT INTO post (authorId, communityId, postTitle, postContent) VALUES ('9', '1', 'Nature is beautiful.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');

-- Sample comments (comment)
INSERT INTO comment (postId, userId, parentId, commentContent) VALUES ('1', '3', NULL, 'I am your first comment!');
INSERT INTO comment (postId, userId, parentId, commentContent) VALUES ('1', '5', NULL, 'I am your second comment :)');
INSERT INTO comment (postId, userId, parentId, commentContent) VALUES ('1', '6', '1', 'Is it your first comment, though?');
INSERT INTO comment (postId, userId, parentId, commentContent) VALUES ('1', '4', '3', 'Must be. Their comment Id is 1.');

