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
df = df[df['Class Stat'] == 'Active']
df = df[df['Building'] != 'WEB']
df = df[df['Building'] != 'OFFCMP']
df = df[df['Building'] != '']
df = df.dropna(subset=['Building'])
df = df.drop(columns=['Class Stat'])

df.to_csv('cleaned_classes.csv')

class_inserts = """"""
building_inserts = """"""
inside_inserts = """"""
buildings = []
for row in df.itertuples():
    class_query = """INSERT INTO Classes (ClassNumber, TotalEnrolled, StartDate, EndDate, StartTime, EndTime) VALUES ({}, {}, '{}', '{}', '{}', '{}');\n""".format(row[1], row[2], row[3], row[4], row[5], row[6])
    class_inserts += class_query
    
    # only adds unique buildings
    if row[14] not in buildings:
        building_query = """INSERT INTO Buildings (BuildingName) VALUES ('{}');\n""".format(row[14])
        building_inserts += building_query
        buildings.append(row[14])

    # since buildings are only appended to the buildings array and concatentated to the buidling_inserts string by order of appearance in the df, 
    # the first building to be appended has the building_id of 1, the second building to be appended has the building_id of 2, and so forth
    # so when looking at the class # and building of a row, we can get the id of the building by searching for its index+1 within the buildings array
    # with the class # and the building_id found, we can create the insert statement for the 'Is In' relational table

    for index, building in enumerate(buildings):
        if row[14] is building:
            inside_query = """INSERT INTO Inside (ClassNumber, BuildingID) VALUES ({}, {});\n""".format(row[1], index+1)
            inside_inserts += inside_query

#print(class_inserts)
#print(building_inserts)
#print(inside_inserts)
all_inserts = class_inserts + building_inserts + inside_inserts
#print(all_inserts)

with open('../results.sql', 'w') as file:
  file.write(all_inserts)
