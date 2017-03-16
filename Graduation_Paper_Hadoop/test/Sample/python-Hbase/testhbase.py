import happybase
connection = happybase.Connection('120.105.81.163')

#def add(x, y):
#    return x + y


#print connection.tables()


connection.open()
table = connection.table('test0816')

row = table.row('s1')
print row['info:null']   # prints the value of cf1:col1
connection.close()