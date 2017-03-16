# -*- coding: UTF-8 -*-
import MySQLdb
import eyed3
from urllib import urlretrieve
from bs4 import BeautifulSoup
import cookielib,urllib, urllib2
def addid(table,arg1,arg2,arg3):
	db = MySQLdb.connect(host="127.0.0.1", user="root", passwd="mustcsie", db="hadoop", charset='utf8')
	cursor = db.cursor()
	cursor.execute("INSERT INTO "+ table +" VALUES("+str(arg1)+",'"+arg2+"',"+str(arg3)+")")
	db.commit()
	cursor.close()
	db.close()
	return "新增歌手成功!!"
def search(table,name,input):
	db = MySQLdb.connect(host="127.0.0.1", user="root", passwd="mustcsie", db="hadoop", charset='utf8')
	cursor = db.cursor()
	cursor.execute("SELECT `"+ input +"` FROM `"+ table +"` Where `name`= '"+name+"' ")
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
	cursor.execute("SELECT `index` FROM `"+ table +"` Where `name`= '"+arg4+"' ")
	result = cursor.fetchall()
	#存入歌手INDEX
	cursor.execute("UPDATE `"+ table+"` SET `index` = "+str(result[0][0]+1)+" WHERE  `name` ='" +arg4  +"'")
	db.commit()
	cursor.close()
	db.close()
	return "index+1!"
def download(fileurl,input):
	extension= fileurl[len(fileurl)-3:]
	if cmp("mp3", extension)==0 :
		path_name = "file"
	else:
		path_name = "images"
		# For Windows 'C:\\test\\'+path_name+'\\1.'+extension
	try:
		#urlretrieve(fileurl, '../mfs/'+path_name+'/'+input+'.'+extension)
		urlretrieve(fileurl, '../mfs/'+path_name+'/'+input+'.'+extension)
	except IOError as IOE :
		print 'fault'
	return "OK"
def addlistid(table,arg1,arg2,arg3):
	db = MySQLdb.connect(host="127.0.0.1", user="root", passwd="mustcsie", db="hadoop", charset='utf8')
	cursor = db.cursor()
	audiofile = eyed3.load('../mfs/user/'+arg2+'/'+arg3)
	if audiofile.tag.artist:
		cursor.execute("INSERT INTO "+ table +" VALUES("+str(arg1)+",'"+arg2+"','"+audiofile.tag.album+"','"+audiofile.tag.artist+"','"+audiofile.tag.title+"','"+str(arg3)+"','"+'no_list'+"')")
	else:
		cursor.execute("INSERT INTO "+ table +" VALUES("+str(arg1)+",'"+arg2+"','"+'未輸入'+"','"+arg3.split('-')[0]+"','"+arg3.split('-')[1].rstrip('.mp3')+"','"+str(arg3)+"','"+'no_list'+"')")
		audiofile.tag.artist = unicode(arg3.split('-')[0])
		audiofile.tag.title = unicode(arg3.split('-')[1].rstrip('.mp3'))
		audiofile.tag.save()
	db.commit()
	cursor.close()
	db.close()
	return "上傳歌曲OK"
def search(arg1,arg2):
	login = arg1
	password = arg2

	# Enable cookie support for urllib2
	cookiejar = cookielib.CookieJar()
	urlOpener = urllib2.build_opener(urllib2.HTTPCookieProcessor(cookiejar))

	# Send login/password to the site and get the session cookie
	values = {'url':login}
	data = urllib.urlencode(values)
	request = urllib2.Request("http://miniqr.com/api/read.php"+"?"+ data)
	url = urlOpener.open(request)
	#print url.read()
	soup = BeautifulSoup(url.read())
	tag=soup.find(id="contentdisplay")
	#print(tag.string)
	content =tag.string
	return content.encode('utf8')