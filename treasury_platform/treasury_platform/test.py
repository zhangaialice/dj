# import json
# from decimal import Decimal
#
# class fakefloat(float):
#     def __init__(self, value):
#         self._value = value
#     def __repr__(self):
#         return str(self._value)
#
# def defaultencode(o):
#     if isinstance(o, Decimal):
#         # Subclass float with custom repr?
#         return fakefloat(o)
#     raise TypeError(repr(o) + " is not JSON serializable")
#
# print json.dumps([10.20, "10.20", Decimal('10.20')], default=defaultencode)



# from random import randint
#
# colors = [1,2,3]
# for i in range(13):
#     colors.append('%06X' % randint(0, 0xFFFFFF))
#
# print repr(colors)
#
#
#
# def get_spaced_colors(n):
#     max_value = 16581375  # 255**3
#     interval = int(max_value / n)
#     colors = [hex(I)[2:].zfill(6) for I in range(0, max_value, interval)]
#
#     print [(int(i[:2], 16), int(i[2:4], 16), int(i[4:], 16)) for i in colors]
# get_spaced_colors(5)
#
# import pandas as pd
# import numpy as np
#
#
#
# sales = [{'account': 'Jones LLC', 'Jan': 150, 'Feb': 200, 'Mar': 140},
#          {'account': 'Alpha Co',  'Jan': 200, 'Feb': 210, 'Mar': 215},
#          {'account': 'Blue Inc',  'Jan': 50,  'Feb': 90,  'Mar': 95 }]
#
# sales2 = [{'account': 'Jones LLC', 'Apr': 150},
#          {'account': 'Alpha Co',  'Apr': 200},
#          {'account': 'Blue Inc',  'Apr': 50}]
#
# sales3 = [{'account': 'Jones LLC', 'Aug': 150},
#          {'account': 'Alpha Co',  'Aug': 200},
#          {'account': 'Blue Inc',  'Aug': 50}]
# df=[]
#
# df0 = pd.DataFrame(sales)
# df1 = pd.DataFrame(sales2)
# df2 = pd.DataFrame(sales3)
#
# dfs = [df0, df1,df2]
# df_final = reduce(lambda left,right: pd.merge(left,right,on='account'), dfs)
# print df_final.head(3)



from itertools import chain

# A = [1,2, 3,4]
# print str(A).strip('[]')
#
# #
# # print list(chain(*A))
#
# # print sum(A,[])
# # print A[0]
# import numpy as np
# from numpy import inf
#
# x = np.array([inf, inf, 0]) # Create array with inf values
#
# print x # Show x array
#
# x[x == inf] = 0 # Replace inf by 0
#
# print x # Show the result
# print x[0]

import pandas as pd
df = pd.DataFrame({'a':[0,0,1,1], 'b':[0,1,0,1]})
df = df[(df.T != 0).any()]
print df.head(2)