import mysql.connector
from mysql.connector import Error

try:
    conn = mysql.connector.connect(host='localhost', user='root', passwd='' , database='IOT_test')
    
    if conn.is_connected():
        db_Info = conn.get_server_info()
        cursor = conn.cursor()
        cursor.execute("select sum(Current) from tabulate where sensor_id = 'LED';")
        for i in cursor:
            total = float(i[0])
            print("Total Power Consumed by the appliance is: "+str(total)+"A")
            print("Contribution to Electricity Bill: Rs."+str(float(float(float(total * 220)/1000)*0.4)))
        cursor.execute("select @sdate := date_of_use , @stime := time_of_use from tabulate where flag_value = '2' and sensor_id = 'LED' order by time_of_use desc limit 1;")
        for i in cursor:
            print("The device was last turned on on "+i[0]+" at "+i[1])
        cursor.execute("select @edate := date_of_use , @etime := time_of_use , @fv := flag_value from tabulate where sensor_id = 'LED' order by time_of_use desc limit 1;")
        for i in cursor:
            if (i[2] == '0'):
                print("And was turned off on "+i[0]+" at "+i[1])
            else:
                print("Still running...")
except Error as e:
    print(e)
finally:
    cursor.close()
    conn.close()