#!c:/Python27/python.exe

import cgi
form = cgi.FieldStorage()
year1 =  form.getvalue('year1')
year2 =  form.getvalue('year2')


print("Content-type: text/html")
print("""
<html lang="en"><head></head>
<body>zheshiwpo"""+ year1+year2+ """</body></html>""")