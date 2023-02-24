import pandas as pd

# first delete columns we dont need
# then delete row that do not have reqs

dataset = str(input("File to clean: "))
df = pd.read_csv(dataset)

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



