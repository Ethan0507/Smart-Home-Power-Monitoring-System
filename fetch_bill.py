import mysql.connector
from mysql.connector import Error

try:
    conn = mysql.connector.connect(host='localhost', user='root', passwd='' , database='IOT_test')
    
    if conn.is_connected():
        db_Info = conn.get_server_info()
        print("Connected to ",db_Info)
        cursor = conn.cursor()
        cursor.execute("select sum(Current) from tabulate;")
        for i in cursor:
            total = float(i[0])
            print("Total Power Consumption at home is: "+str(total)+"A")
            print("Current Electricity Bill: Rs."+str(float(float(float(total * 220)/1000)*0.4)))
except Error as e:
    print(e)
finally:
    cursor.close()
    conn.close()
    print("database conncection closed")