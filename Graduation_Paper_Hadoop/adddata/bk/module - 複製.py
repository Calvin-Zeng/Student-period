# -*- coding: UTF-8 -*-
import MySQLdb
from urllib import urlretrieve

def addsinger(table,arg1,arg2,arg3):
	db = MySQLdb.connect(host="127.0.0.1", user="root", passwd="mustcsie", db="hadoop", charset='utf8')
	cursor = db.cursor()
	cursor.execute("INSERT INTO "+ table +" VALUES("+str(arg1)+",'"+arg2+"',"+str(arg3)+")")
	db.commit()
	cursor.close()
	db.close()
	return "新增歌手成功!!"
def searchid(table,name):
	db = MySQLdb.connect(host="127.0.0.1", user="root", passwd="mustcsie", db="hadoop", charset='utf8')
	cursor = db.cursor()
	cursor.execute("SELECT id FROM "+ table +" Where singer= '"+name+"' ")
	result = cursor.fetchall()
	# 輸出結果
	#for record in result:
	#	print record[0]
	cursor.close()
	db.close()
	return int(result[0][0])
def addindex(table,arg4):
	db = MySQLdb.connect(host="127.0.0.1", user="root", passwd="mustcsie", db="hadoop", charset='utf8')
	cursor = db.cursor()
	#輸出歌手ID
	cursor.execute("SELECT `index` FROM "+ table +" Where singer= '"+arg4+"' ")
	result = cursor.fetchall()
	#存入歌手INDEX
	cursor.execute("UPDATE `"+ table+"` SET `index` = "+str(result[0][0]+1)+" WHERE  `singer` ='" +arg4  +"'")
	db.commit()
	cursor.close()
	db.close()
	return "index+1!"
def download(fileurl):
	extension= fileurl[len(fileurl)-3:]
	if cmp("mp3", extension)==0 :
		path_name = "file"
	else:
		path_name = "image"
		# For Windows 'C:\\test\\'+path_name+'\\1.'+extension
	try:
		urlretrieve(fileurl, '../download/'+path_name+'/1.'+extension)
	except IOError as IOE :
		print 'fault'
	return "OK"