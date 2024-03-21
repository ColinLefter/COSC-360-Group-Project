-- NEEDS REVIEW
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
    postCount int,
    description VARCHAR(250),
    PRIMARY KEY(communityId)
);

CREATE TABLE post (
    postId int NOT NULL AUTO_INCREMENT,
    authorId int,
    authorName VARCHAR(30),
    communityId int,
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