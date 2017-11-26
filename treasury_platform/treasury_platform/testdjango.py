from esg.models import CarbonMsci,CarbonHolding
import pandas as pd
import xlrd
from numpy import nan
import os
import datetime
import xlsxwriter
import numpy as np
import matplotlib.pyplot as plt
import numpy.random
import sys
import matplotlib
import re



# get holding table and filter year, filter columns
# from django:
data = CarbonHolding.objects.values()
list_data = [entry for entry in data]
df = pd.DataFrame(list_data)

# from excel
# df = pd.read_excel("C:/Users/a.zhang/Desktop/SFU/input/carbon.xlsx", 'holding')
df = df.loc[df['year'].isin([self._year])]
df = df.filter(items=['isin', 'manager', 'category', 'country', 'security_type', 'sector', 'market_value'])
total_mv = sum(df['market_value'])

# get msci table, filter year, replace nan with 0, and group by isin, sum two carbon columms
# from django
data_msci = CarbonMsci.objects.values()
list_data_msci = [entry for entry in data_msci]
df_msci = pd.DataFrame(list_data_msci)

# from excel
# df_msci = pd.read_excel("C:/Users/a.zhang/Desktop/SFU/input/carbon.xlsx", 'MSCI')

df_msci = df_msci.loc[df_msci['year'].isin([self._year])].filter(
  items=['isin', 'issuer_market_cap', 'carbon_emissions'])
df_msci['issuer_market_cap'].fillna(0, inplace=True)
df_msci['carbon_emissions'].fillna(0, inplace=True)
df_msci = df_msci.filter(items=['isin', 'issuer_market_cap', 'carbon_emissions']).groupby(
  ['isin']).sum().reset_index()

# merge holding and msci with isin
df_carbon = pd.merge(df, df_msci, on='isin', how='left').fillna(0)
df_carbon = df_carbon[(df_carbon['issuer_market_cap'] != 0)]
# print df_carbon.head(40)

df_carbon[self.one] = (df_carbon['market_value'] / df_carbon['issuer_market_cap']) * df_carbon['carbon_emissions']
df_carbon['emission'].fillna(0, inplace=True)
# print sum(df_carbon['emission'])

df_group = df_carbon.filter(items=[self._group, self.one, 'market_value']).groupby([self._group]).sum().reset_index()
df_group[self.two] = df_group[self.one] / df_group['market_value'] * 1000000
df_group[self.three] = df_group[self.one] / total_mv * 1000000
df_group = df_group[df_group.emission != 0]
return df_group
