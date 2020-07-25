import mysql.connector
from mysql.connector import Error

try:
    conn = mysql.connector.connect(host='localhost', user='root', passwd='' , database='IOT_test')
    
    if conn.is_connected():
        db_Info = conn.get_server_info()
        print("Connected to ",db_Info)
        cursor = conn.cursor()
        f = open("readings.txt","r")
        final = 0
        insert_query = ''
        while True:
            for x in f.readlines():
                row = {}
                row['Date'] = x.split(" ")[0]
                row['Time'] = x.split(" ")[1].split("\t")[0]
                row['Current'] = float(x.split("\t")[1].split(" ")[0])
                row['Flag_value'] = x.split("\t")[1].split(" ")[1]
                row['Sensor_id'] = x.split("\t")[1].split(" ")[2].split("\n")[0]
                insert_query = "insert into tabulate values ('"
                insert_query += row['Date']
                insert_query += "','"
                insert_query += row['Time']
                insert_query += "',"
                insert_query += str(row['Current'])
                insert_query += ",'"
                insert_query += row['Flag_value']
                insert_query += "','"
                insert_query += row['Sensor_id']
                insert_query += "');"
                try:
                    cursor.execute(insert_query)
                    conn.commit()
                    print("Inserted")
                except Error:
                    print("Error")

except Error as e:
    print(e)
finally:
    cursor.close()
    conn.close()
    print("Connection closed")