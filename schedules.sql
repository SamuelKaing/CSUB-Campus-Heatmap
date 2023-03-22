DROP TABLE IF EXISTS 'Buildings';
CREATE TABLE Buildings (
    BuildingID integer primary key auto_increment,
    BuildingName text not null,
    ClosestLot text not null
);

DROP TABLE IF EXISTS 'Classes';
CREATE TABLE Classes (
    ClassNumber integer primary key,
    StartTime text not null,
    EndTime text not null,
    StartDate text not null,
    EndDate text not null,
    TotalEnrolled integer not null
);

DROP TABLE IF EXISTS 'Inside';
CREATE TABLE Inside (
    ClassNumber integer not null,
    BuildingID integer not null,
    foreign key (ClassNumber) references Classes(ClassNumber),
    foreign key (BuildingID) references Buildings(BuildingID),
    primary key (ClassNumber, BuildingID)
);