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
    StartTime time not null,
    EndTime time not null,
    StartDate date not null,
    EndDate date not null,
    TotalEnrolled integer not null,
    Monday boolean not null,
    Tuesday boolean not null,
    Wednesday boolean not null,
    Thursday boolean not null,
    Friday boolean not null,
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