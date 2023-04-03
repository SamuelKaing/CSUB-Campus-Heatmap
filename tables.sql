DROP TABLE IF EXISTS Buildings;
CREATE TABLE Buildings (
    BuildingID integer primary key auto_increment,
    BuildingName text not null,
    ClosestLot text default null
);

DROP TABLE IF EXISTS Classes;
CREATE TABLE Classes (
    ClassID integer not null,
    ClassNumber integer not null,
    StartTime text not null,
    EndTime text not null,
    StartDate text not null,
    EndDate text not null,
    TotalEnrolled integer not null,
    Mon boolean not null,
    Tues boolean not null,
    Wed boolean not null,
    Thur boolean not null,
    Fri boolean not null,
    primary key (ClassID, ClassNumber)
);

DROP TABLE IF EXISTS Inside;
CREATE TABLE Inside (
    ClassID integer not null,
    ClassNumber integer not null,
    BuildingID integer not null,
    foreign key (ClassID, ClassNumber) references Classes(ClassID, ClassNumber),
    foreign key (BuildingID) references Buildings(BuildingID),
    primary key (ClassID, ClassNumber, BuildingID)
);