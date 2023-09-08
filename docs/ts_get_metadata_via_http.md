## 取得 meta data 通过 http 端口
#### 参考 IPN Media Data Manual.pdf， 23页

## Sample Code (Python 3)
```python
import os, time, sys
from http.client import HTTPConnection
from http.server import BaseHTTPRequestHandler, HTTPServer
import base64, re
import xml.etree.ElementTree as elemTree

import socket
import threading
import sqlite3

path = ''
device_ip = ''
userid = 'root'
userpw = 'pass'

hostName = ""
serverPort = 8080

string = (base64.b64encode(((userid + ':' + userpw).encode('ascii')))).decode('ascii')
authkey = "Basic " + (string)

def getAVStream(ip_addr):
	global authkey
	err = 0

	server = (ip_addr, 80)
	conn = HTTPConnection(*server)
	
	db_con = sqlite3.connect("Metadata")
	cur = db_con.cursor()
	
	# conn.putrequest("GET","/nvc-cgi/admin/mediastream.cgi?streamno=first&streamreq=meta")
	conn.putrequest("GET","/nvc-cgi/admin/avstream.cgi?streamno=first&streamreq=meta")
	conn.putheader("Authorization", authkey)
	conn.endheaders()

	rs = conn.getresponse()
#	print rs
	body = b''
	num = 0

	# for i in range(10000) :
	while True:
		# data = rs.read(1024)
		# print(rs.status)
		data = rs.readline()
		data = data.strip()
		if not data:
			print ("no data")
			err += 1
			if err >5:
				conn.close()
				time.sleep(1)
				conn = HTTPConnection(*server)
				conn.putrequest("GET","/nvc-cgi/admin/avstream.cgi?streamno=first&streamreq=meta")
				conn.putheader("Authorization", authkey)
				conn.endheaders()
				rs = conn.getresponse()
				err = 0
				print ("reconnected")
			time.sleep(1)
			continue
		
		if data.find(b'<?xml version="1.0" encoding="utf-8" ?>') >=0 :
			body = parseMeta(body)
			if body:
				# with open("aa%04d.txt" %num, "w+", encoding="utf8") as f:
				# f.write(body['meta'])
				# print (i, body['event'])
				regdate = time.strftime("%Y-%m-%d %H:%M:%S")
				sq = "insert into meta(ip_addr, regdate, meta, frame_id, vca_status, track_mode, flag) \
				values('%s', '%s', '%s', %d, %d, %d, %d)" %(ip_addr, regdate, body['meta'], body['frame_id'], body['vca_status'], body['trk_mode'], 0) 
				cur.execute(sq)
   
				for event in body['event']:
					duration = event['end_time']- event['start_time']
					sq = "insert into event(ip_addr, regdate, event_id, rule_id, obj_id, status, start_time, end_time, duration)  values('%s', '%s', %d, %d, %d, %d, %d, %d, %d)" 	%(ip_addr, regdate, event['id'], event['rule_id'], event['obj_id'], event['status'], event['start_time'], event['end_time'], duration)
					# sq = "insert into event(regdate, event_id, rule_id, obj_id, status, start_time, end_time, duration)  values(%s, %d, %d, %d, %d, %d, %d, %d)"  %(regdate. event['event_id'], event['rule_id'], event['obj_id'], event['status'], event['start_time'], event['end_time'], duration)

					print (sq)
					cur.execute(sq)
				db_con.commit()
			
			# i += 1
			body = b''
			num += 1

		body += data
	
	cur.close()
	db_con.close()
	conn.close()

def parseMeta(strings):
	rs = dict()
	regex_meta = re.compile(b"<vca schema_version=\"1.6\">(.*)</vca>", re.IGNORECASE)
	meta = regex_meta.search(strings)
	rs['meta'] = meta.group(0).decode('utf-8') if meta else ''
	
	try:
		tree = elemTree.fromstring(rs['meta'])
	except:
		print (rs['meta'])
		return ''

	vca_header = tree.find('./vca_hdr') 
	frame_id = vca_header.find('frame_id')
	rs['frame_id'] = int(vca_header.find('frame_id').text) 
	rs['vca_status'] = int(vca_header.find('vca_status').text) 
	rs['trk_mode'] = int(vca_header.find('trk_mode').text) 
	
	vca_object = tree.find('./objects')
	rs['object'] =[]
	for obj in vca_object.findall('object') :
		idt = int(obj.find('id').text)
		ch = int(obj.find('ch').text)
		cs = int(obj.find('cs').text)
		ca = int(obj.find('ca').text)
		clst= int(obj.find('cls').text)
		cls_name = obj.find('cls_name').text
		bb = obj.find('bb')
		bound = (int(bb.find('x').text), int(bb.find('y').text), int(bb.find('w').text), int(bb.find('h').text) )

		rs['object'].append({'id':idt, 'ch':ch, 'cs':cs, 'ca':ca, 'cls':clst, 'cls_name':cls_name, 'bb':bound} )
	
	vca_event = tree.find('./events')
	rs['event'] = []
	for event in vca_event.findall('event') :
		idt = int(event.find('id').text)
		typet = event.find('type').text
		rule_id = int(event.find('rule_id').text)
		rule_name = event.find('rule_name').text
		rule_type = event.find('rule_type').text
		zone_id = int(event.find('zone_id').text)
		zone_name = event.find('zone_name').text
		obj_id = int(event.find('obj_id').text) if event.find('obj_id') != None else 0
		obj_cls_name = event.find('obj_cls_name').text if event.find('obj_cls_name') != None else ''
		status = int(event.find('status').text)
		start_time = int(event.find('start_time').find('s').text)
		end_time = int(event.find('end_time').find('s').text)
		bb = event.find('bb') 
		bound = (int(bb.find('x').text), int(bb.find('y').text), int(bb.find('w').text), int(bb.find('h').text)) if bb != None else (0,0,0,0)

		rs['event'].append({'id':idt, 'type':typet, 'rule_id':rule_id, 'rule_name':rule_name, 'rule_type':rule_type, 'zone_id':zone_id, 'zone_name':zone_name, 'obj_id':obj_id, 'obj_cls_name':obj_cls_name, 'status':status, 'start_time':start_time, 'end_time':end_time, 'bb':bound })
		
	vca_count = tree.find('./counts')
	rs['count'] = []
	for count in vca_count.findall('count') :
		idt = int(count.find('id').text)
		name = count.find('name').text
		val = int(count.find('val').text)

		rs['count'].append({'id':idt, 'name':name, 'val':val })
	
	# print (rs)
	return rs


def view_db(db_name, pk_s = 0, pk_e =100):
	db_con = sqlite3.connect("Metadata")
	cur = db_con.cursor()
	sq = "select * from " + db_name + " where pk >= %d and pk<= %d order by pk asc " %(pk_s, pk_e)
	print (sq)
	# strb = "pk\tregdate\t\t\t\tunitname\tusn\t\tip\tevent_type\ttimestamp\tcounter_id\tcounter_name\tcounter_value"

	if db_name == 'meta':
		strb = "<tr><td>pk</td><td>IP</td><td>regdate</td><td>meta</td><td>frame_id</td><td>vca_status</td><td>track_mode</td><td>flag</td></tr>"
		
	else :
		strb = "<tr><td>pk</td><td>IP</td><td>regdate</td><td>event_id</td><td>rule_id</td><td>obj_id</td><td>status</td><td>start_time</td><td>end_time</td><td>duration</td></tr>"
	
	for row in cur.execute(sq):
		# print (row)
		# strb += "\n"
		strb += "<tr>"
		for col in row:
			if type(col) == int:
				# print("%d" %col)
				strb += "<td style='border-style: solid; border-width: 1px; padding:0px 10px 0px 10px;'>%d</td>" %col
			elif col.find('<vca') == 0:
				strb += "<td style='border-style: solid; border-width: 1px; padding:0px 10px 0px 10px;'><textarea rows=5 cols=100>%s

```