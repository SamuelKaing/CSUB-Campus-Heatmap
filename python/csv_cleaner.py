import pandas as pd

# first delete columns we dont need
# then delete row that do not have reqs

#dataset = str(input("File to clean: "))
#df = pd.read_csv(dataset)
df = pd.read_csv('classes_unclean.csv')

# Define unwanted columns
unwanted = ['Term', 'Session', 'Acad Group', 'Subject', 'Course Number', 'Section', 'Min Units', 'Max Units', 'Enrl Stat', 'Cap Enrl', 
            'Req Rm Cap', 'Wait Cap', 'Wait Tot', 'Auto Enrol', 'Start', 'End', 'Room', 'Course Title', 'Instructor Name', 'Room Char', 'Mode']

# Drop unwanted columns
for column in unwanted:
    df = df.drop(columns=[column])

# Filters Rows
df = df[df['Class Stat'] == 'Active']       # delete cancelled classes
df = df.drop(columns=['Class Stat'])        # column not needed anymore
df = df[df['Building'] != 'WEB']
df = df[df['Building'] != 'OFFCMP']
df = df[df['Building'] != '']
df = df.dropna(subset=['Building'])
df = df.drop_duplicates()

df.to_csv('cleaned_classes.csv')

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

    class_query = """INSERT INTO Classes (ClassID, ClassNumber, TotalEnrolled, StartDate, EndDate, StartTime, EndTime, Mon, Tues, Wed, Thur, Fri) 
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

all_inserts = class_inserts + building_inserts + inside_inserts

with open('../results.sql', 'w') as file:
  file.write(all_inserts)
