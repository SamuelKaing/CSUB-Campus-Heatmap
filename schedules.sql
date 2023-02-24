CREATE TABLE Buildings (
    BuildingID integer primary key autoincrement,
    BuildingName text not null,
    ClosestLot text not null
);

CREATE TABLE Classes (
    ClassID integer primary key autoincrement,
    StartTime text not null
);