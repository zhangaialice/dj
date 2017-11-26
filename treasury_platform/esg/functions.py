import pandas as pd
from decimal import Decimal
from numpy import nan
from treasury_platform.models import IssuerMapping,holding
from esg.models import CarbonMsci,CarbonHolding, CarbonHoldingStack
import numpy as np
#Fossilfuel

class FossilFuel:

    def __init__(self, year='2016'):
    #for testing
        # # get all holding data
        self._year = year
        self.ff = "FossilFuel"
        self.total = "Total"
        self.perc = "Percentage"
# df_t, df_f: load data from mysql, define fossil fuel for equity and fixed income, combine two groups, replace issuer names
    def get_table(self):
        #django object--> list --> dataframe
        data = holding.objects.filter(year=self._year).values()
        list_data = [entry for entry in data]

        # get new_name and old_name as list
        db_new_name = IssuerMapping.objects.values_list('new_name', flat=True)
        new_name = [entry for entry in db_new_name]
        db_old_name = IssuerMapping.objects.values_list('old_name', flat=True)
        old_name = [entry for entry in db_old_name]

        df = pd.DataFrame(list_data)

        # A: get fossil fuel holdings
        # A-1: Define "fossil fuel sectors" and "exception corporation", additional sectors can be manually added
        class_e = ['Oil & Gas Drilling', 'Integrated Oil & Gas', 'Oil & Gas Exploration & Produc',
                   'Oil & Gas Refining & Marketing', 'Oil & Gas Storage & Transporta', 'Coal & Consumable Fuels',
                   'Diversified Metals & Mining', 'Gas Utilities', 'Multi-Utilities',
                   'Independent Power Producers & Energy Traders']
        class_fi = ['Exploration & Production', 'Integrated Oils', 'Oil&Gas', 'Pipelines', 'Refining & Marketing',
                    'Renewable Energy', 'Mining', 'Gas', 'Gas Distribution']
        class_exp = ['CAMECO CORP', 'CAMECO CORPORATION', 'MAJOR DRILLING GROUP INTERNATI']

        df_t = df.filter(items=['category', 'manager', 'security_type', 'name', 'market_value']).fillna(0)

        # A-2: get equity fossil fuel
        df_e = df.loc[df['security_type'].isin(['Canadian Equity', 'International Equity', 'US Equity'])]
        df_e = df_e.loc[df['sub_industry'].isin(class_e)].filter(
            items=['category', 'manager', 'security_type', 'name', 'market_value'])


        # A-3: get fixed income fossil fuel
        df_fi = df.loc[df['security_type'].isin(['Fixed Income'])]
        df_fi = df_fi.loc[df['industry_group'].isin(class_fi)].filter(
            items=['category', 'manager', 'security_type', 'name', 'market_value'])

        # A-4: combine equity and fixed income fossil fuel
        df_f = df_e.append(df_fi)


        # A-5: mapping issuer name
        df_f['name'].replace(old_name, new_name, inplace=True)
        df_f.drop(df_f[df_f['name'].isin(class_exp)].index, inplace=True)
        # return df, df_f, df_t
        self.df = df
        self.df_f = df_f
        self.df_t= df_t



    def f_category(self):
        # B: get fossil fuel table by category
        # B-1: group by category to fossil fuel holdings
        df_category_f = self.df_f.filter(items=['category', 'market_value']).groupby(['category']).sum().reset_index()
        # B-2: group by category to total holdings
        df_category_t = self.df.filter(items=['category', 'market_value']).groupby(['category']).sum().reset_index()
        # B-3: merge fossil fuel and total columns into one table
        df_category = pd.merge(df_category_f, df_category_t, on='category', how='outer').fillna(0)
        df_category.rename(columns={'market_value_x': self.ff, 'market_value_y': self.total},inplace=True)
        # B-4: add percentage columns(fossil fuel/total holding)
        df_category[self.perc] = df_category[self.ff]/df_category[self.total]

        # B-5: adding SUM row, total fossil fuel, total holding, (%fossil fuel/total)
        f_category = sum(df_category[self.ff])
        t_category = sum(df_category[self.total])
        p_category = sum(self.df_f['market_value']) / sum(self.df_t['market_value'])
        df_category.loc[2] = ['Total Portfolio', f_category, t_category, p_category]

        return df_category


    def f_manager(self):
        # C: get fossil fuel table by manager
        # C-1: group by manager to fossil fuel holdings
        df_manager_f =self.df_f.filter(items=['manager', 'market_value']).groupby(['manager']).sum().reset_index()
        # C-2: group by manager to total holdings
        df_manager_t = self.df.filter(items=['manager', 'market_value']).groupby(['manager']).sum().reset_index()
        # C-3: merge fossil fuel and total columns into one table
        df_manager = pd.merge(df_manager_f, df_manager_t, on='manager', how='outer').fillna(0)
        df_manager.rename(columns={'market_value_x': self.ff, 'market_value_y': self.total}, inplace= True)
        # C-4: add percentage columns(fossil fuel/total holding)
        df_manager[self.perc] = df_manager[self.ff] / df_manager[self.total]

        # C-5: get number of fossil issuer for each manager
        df_manager_n = self.df_f.filter(items=['manager', 'name', 'market_value']).groupby(['manager', 'name']).count().reset_index()
        df_manager_n['Number'] = '1'
        df_manager_n = df_manager_n.filter(items=['manager', 'Number']).groupby(['manager']).count().reset_index()

        # C-6: get number of fossil issuer for the whole portfolio
        unique_f = self.df_f['name'].unique()
        uni_f = len(unique_f)
        # C-7: merge number column into the table
        df_manager = pd.merge(df_manager, df_manager_n, on='manager', how='outer').fillna(0)

        # C-8: add sum of fossil fuel, total holding, %ff/total, number of issuers
        n = len(df_manager.index)
        f_manager = sum(df_manager[self.ff])
        t_manager = sum(df_manager[self.total])
        p_manager = f_manager / t_manager
        df_manager.loc[n] = ['Total Portfolio', f_manager, t_manager, p_manager, uni_f]

        return df_manager



    def f_assetclass(self):
        # D: get fossil fuel table by asset class
        #delete the rows with all zeros
        df_t = self.df_t.replace(0, nan)
        df_t = df_t.dropna(how='all', axis=0)
        df_t = df_t.replace(nan, 0)

        df_assetclass_f = self.df_f.filter(items=['security_type','market_value']).groupby(['security_type']).sum().reset_index()

        df_assetclass_t=df_t.filter(items=['security_type','market_value']).groupby(['security_type']).sum().reset_index()

        df_assetclass=pd.merge(df_assetclass_f,df_assetclass_t, on='security_type',how='right').fillna(0)
        df_assetclass.rename(columns={'market_value_x': self.ff,'market_value_y': self.total},inplace=True)
        df_assetclass = df_assetclass[df_assetclass.Total != 0]
        df_assetclass[self.perc]=df_assetclass[self.ff]/df_assetclass[self.total]


        n=len(df_assetclass.index)
        t_sec=sum(df_assetclass[self.total])
        f_sec=sum(df_assetclass[self.ff])
        p_sec=f_sec/t_sec
        df_assetclass.loc[n]=['Total Portfolio',f_sec,t_sec,p_sec]

        df_assetclass_json=df_assetclass.to_json(orient='index')

        return df_assetclass
    def set_variable(self,k):
        self.year= k


class fakefloat(float):
    def __init__(self, value):
        self._value = value
    def __repr__(self):
        return str(self._value)

def defaultencode(o):
    if isinstance(o, Decimal):
        # Subclass float with custom repr?
        return fakefloat(o)
    raise TypeError(repr(o) + " is not JSON serializable")



# tobacco and military
class Industry:

    def __init__(self, year='2016',sector='Tobacco'):
    #for testing
    #for testing
        # # get all holding data
        self._year = year
        self.total = "Total"
        self.perc = "Percentage"
        self.sector = sector

    def get_table(self):
        data = holding.objects.filter(year=self._year).values()
        list_data = [entry for entry in data]
        df = pd.DataFrame(list_data)

        class_e=[self.sector]

        # get new_name and old_name as list
        db_new_name = IssuerMapping.objects.values_list('new_name', flat=True)
        new_name = [entry for entry in db_new_name]
        db_old_name = IssuerMapping.objects.values_list('old_name', flat=True)
        old_name = [entry for entry in db_old_name]

        df_t = df.filter(items=['category', 'manager', 'security_type', 'name', 'market_value']).fillna(0)

        # get all tobacco holdings in equities, from "Sub-industry" column
        df_e = df.loc[df['security_type'].isin(['Canadian Equity', 'International Equity', 'US Equity'])]
        df_e = df_e.loc[df['sub_industry'].isin(class_e)].filter(
            items=['category', 'manager', 'security_type', 'name', 'market_value'])
        df_f = df_e

        df_f['name'].replace(old_name, new_name, inplace=True)

        self.df_f=df_f
        self.df_t=df_t

    def f_category(self):
    # table by category: group by category for both total holding and tobacco holding, and merge two column on category, and calculate % percentage column

        df_category_f = self.df_f.filter(items=['category', 'market_value']).groupby(['category']).sum().reset_index()
        df_category_t = self.df_t.filter(items=['category', 'market_value']).groupby(['category']).sum().reset_index()
        df_category = pd.merge(df_category_f, df_category_t, on='category', how='outer').fillna(0)
        df_category.rename(columns={'market_value_x': self.sector, 'market_value_y': self.total}, inplace=True)
        df_category[self.perc] = df_category[self.sector] / df_category[self.total]

    #adding the last sum row
        f_category = sum(df_category[self.sector])
        t_category = sum(df_category[self.total])
        p_category = sum(self.df_f['market_value']) / sum(self.df_t['market_value'])
        df_category.loc[2] = ['Total Portfolio', f_category, t_category, p_category]
        pd.options.display.float_format = '{:20,.2f}'.format


        return df_category

    def f_manager(self):
        df_manager_f = self.df_f.filter(items=['manager', 'market_value']).groupby(['manager']).sum().reset_index()
        df_manager_t = self.df_t.filter(items=['manager', 'market_value']).groupby(['manager']).sum().reset_index()
        df_manager = pd.merge(df_manager_f, df_manager_t, on='manager', how='outer').fillna(0)
        df_manager.rename(columns={'market_value_x': self.sector, 'market_value_y': self.total},inplace=True)
        df_manager[self.perc] = df_manager[self.sector]/df_manager[self.total]

        ## get table of [manager, number of issuers]
        df_manager_n = self.df_f.filter(items=['manager', 'name', 'market_value']).groupby(
            ['manager', 'name']).count().reset_index()
        df_manager_n['number'] = '1'
        df_manager_n = df_manager_n.filter(items=['manager', 'number']).groupby(['manager']).count().reset_index()

        ## get total number of issuers for the last sum row
        unique_f = self.df_f['name'].unique()
        uni_f = len(unique_f)

        df_manager = pd.merge(df_manager, df_manager_n, on='manager', how='outer').fillna(0)

        ## add the last sum row
        n = len(df_manager.index)
        f_manager = sum(df_manager[self.sector])
        t_manager = sum(df_manager[self.total])
        p_manager = f_manager / t_manager
        df_manager.loc[n] = ['Total Portfolio', f_manager, t_manager, p_manager, uni_f]
        pd.options.display.float_format = '{:20,.2f}'.format
        return df_manager

# Manager
class Manager:
    def __init__(self, manager="BEAM", category='Endowment'):
        self._manager = manager
        self._category = category
        self.a = 'Manager'
        self.b = 'Portfolio'
        self.perc = 'Percentage'

    def get_data(self):

        data = holding.objects.filter(year=self._year).values()
        list_data = [entry for entry in data]
        df = pd.DataFrame(list_data)

        # df = pd.read_excel("C:/Users/a.zhang/Desktop/SFU/input/holding1.xlsx", 'holding')
        df_t = df.filter(
            items=['manager', 'category', 'name', 'security_type', 'sector', 'industry_sector', 'market_value'])
        if self._category is 'All':
            df_manager = df_t.loc[df_t['manager'].isin([self._manager])].loc[
                df_t['category'].isin(['Non_Endowment', 'Endowment'])]
        else:
            df_manager = df_t.loc[df_t['manager'].isin([self._manager])].loc[
                df_t['category'].isin([self._category])]

        self.df_t = df_t
        self.df_manager = df_manager

    def output_class(self):

        df_f_class = self.df_manager.filter(items=['security_type', 'market_value']).groupby(
            ['security_type']).sum().reset_index()
        df_t_class = self.df_t.filter(items=['security_type', 'market_value']).groupby(
            ['security_type']).sum().reset_index()
        df_class = pd.merge(df_f_class, df_t_class, on='security_type', how='outer').fillna(0)
        df_class.rename(columns={'market_value_x': self.a, 'market_value_y': self.b}, inplace=True)
        df_class[self.perc] = df_class[self.a] / df_class[self.b]
        df_class = df_class[df_class.Portfolio != 0]

        sum_manager = sum(df_class[self.a])
        sum_portfolio = sum(df_class[self.b])
        sum_percentage = sum_manager / sum_portfolio
        n = len(df_class.index)
        df_class.loc[n] = ['Total Portfolio', sum_manager, sum_portfolio, sum_percentage]
        return df_class

    def output_fi(self):
        df_fi = self.df_t.loc[
            self.df_t['security_type'].isin(['Fixed Income', 'Canadian Fixed Income', 'US Fixed Income'])]
        df_manager_fi = self.df_manager.loc[
            self.df_manager['security_type'].isin(['Fixed Income', 'Canadian Fixed Income', 'US Fixed Income'])]

        df_manager_fi = df_manager_fi.filter(items=['industry_sector', 'market_value']).groupby(
            ['industry_sector']).sum().reset_index()
        df_fi = df_fi.filter(items=['industry_sector', 'market_value']).groupby(
            ['industry_sector']).sum().reset_index()
        df_fixedincome = pd.merge(df_manager_fi, df_fi, on='industry_sector', how='outer').fillna(0)
        df_fixedincome.rename(columns={'market_value_x': self.a, 'market_value_y': self.b}, inplace=True)
        df_fixedincome[self.perc] = df_fixedincome[self.a] / df_fixedincome[self.b]
        df_fixedincome = df_fixedincome[df_fixedincome.Portfolio != 0]

        sum_manager = sum(df_fixedincome[self.a])
        sum_portfolio = sum(df_fixedincome[self.b])
        sum_percentage = sum_manager / sum_portfolio
        n = len(df_fixedincome.index)
        df_fixedincome.loc[n] = ['Total Portfolio', sum_manager, sum_portfolio, sum_percentage]
        return df_fixedincome

    def output_ce(self):
        df_ce = self.df_t.loc[self.df_t['security_type'].isin(['Canadian Equity'])]
        df_manager_ce = self.df_manager.loc[self.df_manager['security_type'].isin(['Canadian Equity'])]

        df_manager_ce = df_manager_ce.filter(items=['sector', 'market_value']).groupby(
            ['sector']).sum().reset_index()
        df_ce = df_ce.filter(items=['sector', 'market_value']).groupby(['sector']).sum().reset_index()
        df_ce = pd.merge(df_manager_ce, df_ce, on='sector', how='outer').fillna(0)
        df_ce.rename(columns={'market_value_x': self.a, 'market_value_y': self.b}, inplace=True)
        df_ce[self.perc] = df_ce[self.a] / df_ce[self.b]
        df_ce = df_ce[df_ce.Portfolio != 0]

        sum_manager = sum(df_ce[self.a])
        sum_portfolio = sum(df_ce[self.b])
        sum_percentage = sum_manager / sum_portfolio
        n = len(df_ce.index)
        df_ce.loc[n] = ['Total Portfolio', sum_manager, sum_portfolio, sum_percentage]
        return df_ce

    def output_ge(self):
        df_ge = self.df_t.loc[
            self.df_t['security_type'].isin(['International Equity', 'Emerging Market', 'US Equity'])]
        df_manager_ge = self.df_manager.loc[
            self.df_manager['security_type'].isin(['International Equity', 'Emerging Market', 'US Equity'])]

        df_manager_ge = df_manager_ge.filter(items=['sector', 'market_value']).groupby(
            ['sector']).sum().reset_index()
        df_ge = df_ge.filter(items=['sector', 'market_value']).groupby(['sector']).sum().reset_index()
        df_ge = pd.merge(df_manager_ge, df_ge, on='sector', how='outer').fillna(0)
        df_ge.rename(columns={'market_value_x': self.a, 'market_value_y': self.b}, inplace=True)
        df_ge[self.perc] = df_ge[self.a] / df_ge[self.b]
        df_ge = df_ge[df_ge.Portfolio != 0]

        sum_manager = sum(df_ge[self.a])
        sum_portfolio = sum(df_ge[self.b])
        sum_pergentage = sum_manager / sum_portfolio
        n = len(df_ge.index)
        df_ge.loc[n] = ['Total Portfolio', sum_manager, sum_portfolio, sum_pergentage]
        return df_ge

    def output_te(self):
        df_te = self.df_t.loc[self.df_t['security_type'].isin(
            ['Canadian Equity', 'International Equity', 'Emerging Market', 'US Equity'])]
        df_manager_te = self.df_manager.loc[self.df_manager['security_type'].isin(
            ['Canadian Equity', 'International Equity', 'Emerging Market', 'US Equity'])]

        df_manager_te = df_manager_te.filter(items=['sector', 'market_value']).groupby(
            ['sector']).sum().reset_index()
        df_te = df_te.filter(items=['sector', 'market_value']).groupby(['sector']).sum().reset_index()
        df_te = pd.merge(df_manager_te, df_te, on='sector', how='outer').fillna(0)
        df_te.rename(columns={'market_value_x': self.a, 'market_value_y': self.b}, inplace=True)
        df_te[self.perc] = df_te[self.a] / df_te[self.b]
        df_te = df_te[df_te.Portfolio != 0]

        sum_manager = sum(df_te[self.a])
        sum_portfolio = sum(df_te[self.b])
        sum_pergentage = sum_manager / sum_portfolio
        n = len(df_te.index)
        df_te.loc[n] = ['Total Portfolio', sum_manager, sum_portfolio, sum_pergentage]
        return df_te

# asset class analysis: by manager, by sector for equity and industry sector for fixed income

class AssetClass:
  def __init__(self, yr= 2016, category='Endowment', assetclass='Total Fixed Income'):
    self._year=yr
    self._category = category
    self.perc = 'Percentage'
    self._assetclass = assetclass


  def get_data(self):
      data = holding.objects.filter(year=self._year).values()
      list_data = [entry for entry in data]
      df = pd.DataFrame(list_data)

    # df = pd.read_excel("C:/Users/a.zhang/Desktop/SFU/input/holding1.xlsx", 'holding')
      df = df.filter(items=['year','manager', 'category', 'name', 'security_type', 'sector', 'industry_sector', 'market_value'])
      if self._category == 'All':
        df = df.loc[df['year'].isin([self._year])].loc[df['category'].isin(['Non_Endowment', 'Endowment'])]
      else:
        df = df.loc[df['year'].isin([self._year])].loc[df['category'].isin([self._category])]
      if self._assetclass == 'Total Equity':
        df_assetclass = df.loc[df['security_type'].isin(['International Equity','Emerging Market','US Equity','Canadian Equity'])]
      elif self._assetclass == 'Global Equity':
        df_assetclass= df.loc[df['security_type'].isin(['International Equity','Emerging Market','US Equity'])]
      elif self._assetclass == 'Total Fixed Income':
        df_assetclass= df.loc[df['security_type'].isin(['Fixed Income','Canadian Fixed Income','US Fixed Income'])]
      else:
        df_assetclass = df.loc[df['security_type'].isin([self._assetclass])]

      self.df_assetclass=df_assetclass


  def by_manager(self):
    df_manager = self.df_assetclass.filter(items=['manager', 'market_value']).groupby(['manager']).sum().reset_index()
    total = sum(df_manager['market_value'])
    df_manager[self.perc] = df_manager['market_value']/total
    total_perc = sum(df_manager[self.perc])
    n = len(df_manager.index)
    df_manager.loc[n] = ['Total Portfolio', total, total_perc]
    df_manager.rename(columns={'market_value': self._assetclass}, inplace=True)
    return df_manager
    # print type(self._assetclass)


  def by_sector(self):
    if 'Equity' in self._assetclass or 'Emerging' in self._assetclass:
      df_sector = self.df_assetclass.filter(items=['sector', 'market_value']).groupby(['sector']).sum().reset_index()
    elif 'Fixed' in self._assetclass:
      df_sector = self.df_assetclass.filter(items=['industry_sector', 'market_value']).groupby(['industry_sector']).sum().reset_index()
      # df_sector.rename(columns={'industry_sector': 'sector'}, inplace=True)
    else:
      df_sector = self.df_assetclass.filter(items=['security_type', 'market_value']).groupby(['security_type']).sum().reset_index()

    total = sum(df_sector['market_value'])
    df_sector[self.perc] = df_sector['market_value'] / total
    total_perc = sum(df_sector[self.perc])
    n = len(df_sector.index)
    df_sector.loc[n] = ['Total Portfolio', total, total_perc]
    df_sector.rename(columns={'market_value': self._assetclass}, inplace=True)
    a= df_sector
    return a



# def test():
#   sample = AssetClass()
#   # # sample._manager = 'Bissett'
#   # sample._year=2015
#   # sample._category = 'All'
#   # sample._assetclass = 'Cash'
#   sample.get_data()
#   sample.by_sector()
#
# test()
# choose: year, group=[sector, category, manager, country, security_type],
# output =[emission, emission per million, selection contribution]
class Carbon:
  def __init__(self, year=2017, group='sector', output='emission'):
    self._year = year
    self._group = group
    self._output = output
    self.one = 'emission'
    self.two = 'emission per million'
    self.three = 'selection contribution'

  def get_data(self):
    data = CarbonHolding.objects.values()
    list_data = [entry for entry in data]
    df = pd.DataFrame(list_data)

    df = df.loc[df['year'].isin([self._year])]
    df = df.filter(items=['isin', 'manager', 'category', 'country', 'security_type', 'sector', 'market_value'])
    total_mv = sum(df['market_value'])
    float_total_mv = float(total_mv)

    data_msci = CarbonMsci.objects.values()
    list_data_msci = [entry for entry in data_msci]
    df_msci = pd.DataFrame(list_data_msci)

    df_msci = df_msci.loc[df_msci['year'].isin([self._year])].filter(items=['isin', 'issuer_market_cap', 'carbon_emissions'])
    df_msci = df_msci.filter(items=['isin', 'issuer_market_cap', 'carbon_emissions']).groupby(
      ['isin']).sum().reset_index()

    df_carbon = pd.merge(df, df_msci, on='isin', how='left').fillna(0)

    df_carbon["emission"] = ""
    df_carbon_a = df_carbon.loc[df_carbon['issuer_market_cap'].isin([0])]
    df_carbon_b = df_carbon.loc[df_carbon['issuer_market_cap'] != 0]
    df_carbon_a['emission'] = 0
    df_carbon_b['emission'] = (df_carbon_b['market_value'] / df_carbon_b['issuer_market_cap']) * df_carbon_b[
      'carbon_emissions']
    df_carbon_combine = df_carbon_a.append(df_carbon_b)

    df_carbon_combine['emission2'] = listToFloat(df_carbon_combine['emission'])
    df_carbon_combine['issuer_market_cap2'] = listToFloat(df_carbon_combine['issuer_market_cap'])
    df_carbon_combine['market_value2'] = listToFloat(df_carbon_combine['market_value'])
    df_carbon_combine['carbon_emission2'] = listToFloat(df_carbon_combine['carbon_emissions'])

    df_group = df_carbon_combine.filter(items=[self._group, 'emission2', 'market_value2']).groupby(
      [self._group]).sum().reset_index()
    df_group[self.two] = df_group['emission2'] / df_group['market_value2'] * 1000000
    df_group[self.three] = df_group['emission2'] / float_total_mv * 1000000
    df_group=df_group.fillna(0)

    # n = len(df_group.index)
    # sum_emission = sum(df_group['emission2'])
    # sum_mv = sum(df_group['market_value2'])
    # sum_two = sum(df_group[self.two])
    # sum_three = sum(df_group[self.three])
    # df_group.loc[n] = ['Total Portfolio', sum_emission, sum_mv, sum_three, sum_two]

    return df_group

def listToFloat(l):
  return [float(i) for i in l]

class CarbonStack:
  def __init__(self, year=2016, manager='BEAM'):
    self._year = year
    self._manager = manager

  def get_data(self):
    data = CarbonHoldingStack.objects.values()
    list_data = [entry for entry in data]
    df = pd.DataFrame(list_data)

    data_msci = CarbonMsci.objects.values()
    list_data_msci = [entry for entry in data_msci]
    df_msci = pd.DataFrame(list_data_msci)

    year_l = [self._year]
    manager_l = [self._manager]
    df_msci = df_msci.loc[df_msci['year'].isin(year_l)].filter(
      items=['isin', 'issuer_market_cap', 'carbon_emissions', 'issuer'])

    df_msci['issuer'] = map(lambda x: x.capitalize(), df_msci['issuer'])
    # print df_msci.head(30)
    # print df_msci.head(30)
    # either grouping the msci table or deleting 0 zeros, grouping is better, since deleting the row will delete ETF with market cap=0 and carbon=0
    df_msci['issuer_market_cap'].fillna(0, inplace=True)
    df_msci['carbon_emissions'].fillna(0, inplace=True)
    # print df_msci.head(30)


    df_msci['issuer_market_cap1'] = listToFloat(df_msci['issuer_market_cap'])
    df_msci['carbon_emissions1'] = listToFloat(df_msci['carbon_emissions'])

    df_msci = df_msci.filter(items=['isin', 'issuer_market_cap1', 'carbon_emissions1', 'issuer']).groupby(['isin', 'issuer']).sum().reset_index()
    # print df_msci.dtypes
    # print df_msci.head(10)

    df_t = df.loc[df['year'].isin(year_l)].loc[df['manager'].isin(manager_l)].filter(items=['isin', 'manager', 'sector', 'total_mv'])
    print df_t.dtypes
    # test = sum(df_t['total_mv'])
    # print test
    df_t['total_mv1'] = listToFloat(df_t['total_mv'])
    df_isin = df_t.filter(items=['isin', 'total_mv1', 'sector']).groupby(['isin', 'sector']).sum().reset_index()
    # print df_isin.dtypes
    # print df_isin.head(10)
    # print df_isin.head(10)
    # print df_msci.head(10)
    df_merge = pd.merge(df_isin, df_msci, on=['isin'], how='left').fillna(0)
    # print df_merge.head(30)

    df_merge['emission_owned'] = (df_merge['total_mv1'] / df_merge['issuer_market_cap1'] * df_merge['carbon_emissions1'])
    df_merge['emission_owned'].fillna(0, inplace=True)
    sum_mv = sum(df_merge['total_mv1'])
    df_merge['emission_per_mil'] = df_merge['emission_owned'] / sum_mv * 1000000
    # print df_merge.head(10)
    sum_carbon = sum(df_merge['emission_owned'])
    sum_emissionpermil = sum(df_merge['emission_per_mil'])
    df_merge['per_emission'] = df_merge['emission_per_mil'] / sum_emissionpermil
    df_merge['per_mv'] = df_merge['total_mv1'] / sum_mv
    # delete the issuer can't be found in msci
    df_merge = df_merge[df_merge["issuer"] <> 0]
    sum_mv1 = sum(df_merge['total_mv1'])
    # df_merge.to_csv("C:\\Users\\a.zhang\Desktop\SFU\input\\test.csv")
    # print df_merge.head(10)
    # print sum_carbon
    # print sum_mv
    # print df_merge.head(10)
    # print df_isin.head(2)
    # print df_msci.head(3)
    df_sector = df_merge.filter(items=['sector', 'emission_per_mil']).groupby('sector').sum().reset_index()
    sum_t = sum(df_sector['emission_per_mil'])
    # print sum_t
    print df_sector.head(10)
    print df_sector.dtypes
    return df_sector





