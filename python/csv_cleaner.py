################################################################
# Author:   Samuel Kaing
# Purpose:  Reads a csv file, cleans out uneeded values, 
#           then creates a sql file containing INSERT statements 
#           using the cleaned csv file 
################################################################

import pandas as pd

#dataset = str(input("File to clean: "))
#df = pd.read_csv(dataset)
df = pd.read_csv('uncleaned_classes.csv')

# Define unwanted columns
unwanted = ['Term', 'Session', 'Acad Group', 'Subject', 'Course Number', 'Section', 'Min Units', 'Max Units', 'Enrl Stat', 'Cap Enrl', 
            'Req Rm Cap', 'Wait Cap', 'Wait Tot', 'Auto Enrol', 'Start', 'End', 'Pat', 'Room', 'Course Title', 'Instructor Name', 'Room Char', 'Mode', 'Email']

# Drop unwanted columns
for column in unwanted:
    df = df.drop(columns=[column])

# Filters Rows
df = df[df['Class Stat'] == 'Active']       # delete cancelled classes
df = df.drop(columns=['Class Stat'])        # column not needed anymore
df = df[df['Building'] != 'WEB']
df = df[df['Building'] != 'OFFCMP']
df = df[df['Building'] != '']
df = df[df['Building'] != 'CSUB-AV']
df = df[df['Building'] != 'AVC']
df = df.dropna(subset=['Building'])
df = df.drop_duplicates()

# TODO: Delete this, only used for debugging purposes
df.to_csv('cleaned_classes.csv')

# Create tables
tables = """
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
"""

class_inserts = """"""
building_inserts = """"""
inside_inserts = """"""
buildings = []
for row in df.itertuples():
    days = []
    
    # checks what days class occurs on 
    for index in range(5):
        #check row[index], if not empty, append true, else append false
        if pd.isna(row[index+7]):
            days.append(False)
        else:
            days.append(True)

    # class_query will prepare an INSERT statement with dataframe values
    # needed convertions for datatypes are implemented in the string
    class_query = """INSERT INTO Classes (ClassID, ClassNumber, TotalEnrolled, StartDate, EndDate, StartTime, EndTime, Monday, Tuesday, Wednesday, Thursday, Friday) 
    VALUES ({}, {}, {}, STR_TO_DATE('{}', '%m/%d/%Y'), STR_TO_DATE('{}', '%m/%d/%Y'), STR_TO_DATE('{}', '%h:%i:%s %p'), STR_TO_DATE('{}', '%h:%i:%s %p'), {}, {}, {}, {}, {});\n""".format(row[0], row[1], row[2], row[3], row[4], row[5], row[6], days[0], days[1], days[2], days[3], days[4])
    class_inserts += class_query
    
    # only adds unique buildings
    if row[14] not in buildings:
        building_query = """INSERT INTO Buildings (BuildingName) VALUES ('{}');\n""".format(row[14])
        building_inserts += building_query
        buildings.append(row[14])

    # relational table queries
    for index, building in enumerate(buildings):
        if row[14] is building:
            inside_query = """INSERT INTO Inside (ClassID, ClassNumber, BuildingID) VALUES ({}, {}, {});\n""".format(row[0], row[1], index+1)
            inside_inserts += inside_query

all_inserts = tables + class_inserts + building_inserts + inside_inserts

# writes queries to a sql file in overhead folder
with open('../results.sql', 'w') as file:
  file.write(all_inserts)
