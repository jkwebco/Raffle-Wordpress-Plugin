
#change this to fit you needs


#!/usr/bin/python
import MySQLdb

db = MySQLdb.connect(host="localhost",    # your host, usually localhost
                     user="username",         # your username
                     passwd="passwd",  # your password
                     db="wordpress")        # name of the data base

# you must create a Cursor object. It will let
#  you execute all the queries you need
cur = db.cursor()

# Use all the SQL you like
cur.execute("SELECT * FROM wp_wooraffle_tickets_customer_to_tickets")

# print all the first cell of all the rows
for row in cur.fetchall():
    print row[0],row[1],row[2],row[3],row[4],row[5]

db.close()
