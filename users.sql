DROP TABLE IF EXISTS user;

CREATE TABLE user (
    userid integer primary key autoincrement,
    username VARCHAR(255),
    password CHAR(32)
);