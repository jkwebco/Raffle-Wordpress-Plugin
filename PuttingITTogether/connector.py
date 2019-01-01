
#change this to fit you needs


    import mysql.connector
    from mysql.connector import Error
    try:
       mySQLconnection = mysql.connector.connect(host='localhost',
                                 database='wordpress',
                                 user='username',
                                 password='password')
       sql_select_Query = "select * from wooraffle_tickets_customer_to_tickets"
       cursor = mySQLconnection .cursor()
       cursor.execute(sql_select_Query)
       records = cursor.fetchall()
       print("Total number of rows is - ", cursor.rowcount)
       print ("Printing each row's column values - ")
       for row in records:
           print("ticket_number = ", row[0], )
           print("ticket_hash = ", row[1])
           print("ticket_numb  = ", row[2])
           print("ticket_file  = ", row[3], "\n")
       cursor.close()
       
    except Error as e :
        print ("Error while connecting to MySQL", e)
    finally:
        #closing database connection.
        if(mySQLconnection .is_connected()):
            connection.close()
            print("MySQL connection is closed")
