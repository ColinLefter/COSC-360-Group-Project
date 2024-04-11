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
    accountAge VARCHAR(30), -- This is a string for now, but will be changed to a date
    password VARCHAR(255), -- We are storing hashed passwords and these can be up to 255 characters long.
    PRIMARY KEY (userId)
);

CREATE TABLE userActivity ( -- This is to track whenever a user performs an action
    activityId INT NOT NULL AUTO_INCREMENT,
    userId INT NOT NULL,
    activityDate DATE NOT NULL,
    activityType VARCHAR(30) NOT NULL,
    PRIMARY KEY(activityId),
    FOREIGN KEY(userId) REFERENCES user(userId)
    ON DELETE CASCADE
);

CREATE TABLE adminAnnouncement(
    announcementId INT NOT NULL AUTO_INCREMENT,
    announcementTitle VARCHAR(50),
    announcementDate TIMESTAMP DEFAULT NOW(),
    announcementAuthor VARCHAR(30),
    announcementContent VARCHAR(250),
    PRIMARY KEY(announcementId)
);

CREATE TABLE userDetails (
    userId int NOT NULL,
    useLightMode boolean DEFAULT 0,
    userAuthority int DEFAULT 0, -- For now, 0 = normal user, 1 = moderator, 2 = admin
    isBanned boolean DEFAULT 0,
    accountDate TIMESTAMP NOT NULL DEFAULT NOW(),
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
    ON DELETE CASCADE
);

-- Modify as necessary
CREATE TABLE statistic (
    statisticDate DATE,
    dailyVisitors int
);

-- Sample data (users)
-- Does not matter that the password is hashed, since its only for consistency
INSERT INTO user (userName, firstName, lastName, email, accountAge, password) VALUES ('jsmith', 'John', "Smith", 'john@smith.com', '3 days', 'password1');
INSERT INTO user (userName, firstName, lastName, email, accountAge, password) VALUES ('jparish', 'Jarod', "Parish", 'jparish@example.com', '30 days', 'password2');
INSERT INTO user (userName, firstName, lastName, email, accountAge, password) VALUES ('jdoe', 'Jane', "Doe", 'jane@doe.com', '1 day', 'password3');
INSERT INTO user (userName, firstName, lastName, email, accountAge, password) VALUES ('tcruise', 'Tom', "Cruise", 'tom@gmail.com', '12 days', 'password4');
INSERT INTO user (userName, firstName, lastName, email, accountAge, password) VALUES ('rmcdonald', 'Ronald', "Mcdonald", 'ronald@mcdonald.com', '30 days', 'password5');
INSERT INTO user (userName, firstName, lastName, email, accountAge, password) VALUES ('jjjschmidt', 'John', "Schmidt", 'john@gmail.com', '10 days', 'hisnameismynametoo');
INSERT INTO user (userName, firstName, lastName, email, accountAge, password) VALUES ('dmartinez', 'David', "Martinez", 'david@militech.com', '9 days', 'punkcyber');
INSERT INTO user (userName, firstName, lastName, email, accountAge, password) VALUES ('roppenheimer', 'Robert', "Oppenheimer", 'rob@boom.com', '8 days', 'Iambecomedeath');
INSERT INTO user (userName, firstName, lastName, email, accountAge, password) VALUES ('bross', 'Bob', "Ross", 'Bob@gmail.com', '4 days', 'illaddafunnylittlecloud');

-- Sample Data (userDetails) 
-- Fills in default, needed for profile pic
INSERT INTO userDetails (userId) VALUES (1);
INSERT INTO userDetails (userId) VALUES (2);
INSERT INTO userDetails (userId) VALUES (3);
INSERT INTO userDetails (userId) VALUES (4);
INSERT INTO userDetails (userId) VALUES (5);
INSERT INTO userDetails (userId) VALUES (6);
INSERT INTO userDetails (userId) VALUES (7);
INSERT INTO userDetails (userId) VALUES (8);
INSERT INTO userDetails (userId) VALUES (9);

-- Admin Account
INSERT INTO user (userName, firstName, lastName, email, accountAge, password) VALUES ('admin', 'user', "admin", 'admin@mydiscussionforum.com', '90 days', '$2y$10$.sok79XTfH2Bj/ekkFMeRedU.8tp2SK2dUo.2eSNSueyjGTtIPeZW');
INSERT INTO userDetails (userId, userAuthority) VALUES (10, 2);

-- Moderator Account
INSERT INTO user (userName, firstName, lastName, email, accountAge, password) VALUES ('moderator', 'user', "moderator", 'moderator@mydiscussionforum.com', '90 days', '$2y$10$LT4neTsMY/QUQGFxkKR3buSxbZPl/U9M8aOCFKdvZV7z0EM4dPkHq');
INSERT INTO userDetails (userId, userAuthority) VALUES (11, 1);

-- Sample data (userActivity)
INSERT INTO userActivity (userId, activityDate, activityType) VALUES (3, '2024-03-04', 'LOGIN');
INSERT INTO userActivity (userId, activityDate, activityType) VALUES (4, '2024-03-06', 'RESET_PASSWORD');
INSERT INTO userActivity (userId, activityDate, activityType) VALUES (9, '2024-03-05', 'ADD_COMMENT');
INSERT INTO userActivity (userId, activityDate, activityType) VALUES (6, '2024-03-21', 'LOGIN');
INSERT INTO userActivity (userId, activityDate, activityType) VALUES (1, '2024-03-14', 'SEARCH_POSTS');
INSERT INTO userActivity (userId, activityDate, activityType) VALUES (3, '2024-03-07', 'LOGIN');
INSERT INTO userActivity (userId, activityDate, activityType) VALUES (8, '2024-03-17', 'RESET_PASSWORD');
INSERT INTO userActivity (userId, activityDate, activityType) VALUES (7, '2024-03-01', 'ACCOUNT_CREATED');
INSERT INTO userActivity (userId, activityDate, activityType) VALUES (8, '2024-03-09', 'ADD_COMMENT');
INSERT INTO userActivity (userId, activityDate, activityType) VALUES (5, '2024-03-15', 'SEARCH_POSTS');
INSERT INTO userActivity (userId, activityDate, activityType) VALUES (4, '2024-03-16', 'ADD_COMMENT');
INSERT INTO userActivity (userId, activityDate, activityType) VALUES (2, '2024-03-02', 'LOGIN');
INSERT INTO userActivity (userId, activityDate, activityType) VALUES (8, '2024-03-12', 'LOGOUT');
INSERT INTO userActivity (userId, activityDate, activityType) VALUES (1, '2024-03-25', 'ADD_COMMENT');
INSERT INTO userActivity (userId, activityDate, activityType) VALUES (9, '2024-03-26', 'ACCOUNT_CREATED');
INSERT INTO userActivity (userId, activityDate, activityType) VALUES (2, '2024-03-03', 'LOGIN');
INSERT INTO userActivity (userId, activityDate, activityType) VALUES (6, '2024-03-23', 'UPDATE_ACCOUNT');
INSERT INTO userActivity (userId, activityDate, activityType) VALUES (7, '2024-03-11', 'LOGOUT');
INSERT INTO userActivity (userId, activityDate, activityType) VALUES (5, '2024-03-19', 'SEARCH_POSTS');
INSERT INTO userActivity (userId, activityDate, activityType) VALUES (4, '2024-03-27', 'LOGIN');

-- sample data (adminAnnouncement)
INSERT INTO adminAnnouncement (announcementTitle, announcementAuthor, announcementContent) VALUES
('Site Maintenance', 'Admin', 'We will be performing scheduled maintenance this Saturday at 10 PM.'),
('Feature Update', 'DevTeam', 'Exciting new features have been added to enhance your experience.'),
('Security Notice', 'SecurityTeam', 'Please update your passwords regularly to enhance security.'),
('Community Guidelines Update', 'Moderator', 'Our community guidelines have been updated. Please review them.'),
('Holiday Schedule', 'HR', 'Our support team will be operating on a reduced schedule this holiday.'),
('New Forum Section', 'Admin', 'Check out the new forum section dedicated to frequently asked questions.');


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

