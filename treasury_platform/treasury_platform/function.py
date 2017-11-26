import pandas as pd
from numpy import nan
from .models import IssuerMapping,holding
import json
from decimal import Decimal


def fossil_fuel():

#for testing
    # # get all holding data
    data = holding.objects.filter(year=2015).values()
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
    sum_fuel_e = sum(df_e['market_value'])
    
    # A-3: get fixed income fossil fuel
    df_fi = df.loc[df['security_type'].isin(['Fixed Income'])]
    df_fi = df_fi.loc[df['industry_group'].isin(class_fi)].filter(
        items=['category', 'manager', 'security_type', 'name', 'market_value'])
    
    # A-4: combine equity and fixed income fossil fuel
    df_f = df_e.append(df_fi)

    # A-5: mapping issuer name
    df_f['name'].replace(old_name, new_name, inplace=True)
    df_f.drop(df_f[df_f['name'].isin(class_exp)].index, inplace=True)
    
    # B: get fossil fuel table by category
    ff = "FossilFuel"
    total = "Total"
    perc= "Percentage"
    # B-1: group by category to fossil fuel holdings
    df_category_f = df_f.filter(items=['category', 'market_value']).groupby(['category']).sum().reset_index()
    # B-2: group by category to total holdings
    df_category_t = df.filter(items=['category', 'market_value']).groupby(['category']).sum().reset_index()
    # B-3: merge fossil fuel and total columns into one table 
    df_category = pd.merge(df_category_f, df_category_t, on='category', how='outer').fillna(0)
    df_category.rename(columns={'market_value_x': ff, 'market_value_y': total},inplace=True)
    # B-4: add percentage columns(fossil fuel/total holding) 
    df_category[perc] = df_category[ff]/df_category[total]

    # B-5: adding SUM row, total fossil fuel, total holding, (%fossil fuel/total)
    f_category = sum(df_category[ff])
    t_category = sum(df_category[total])
    p_category = sum(df_f['market_value']) / sum(df_t['market_value'])
    df_category.loc[2] = ['Total Portfolio', f_category, t_category, p_category]

    return df_category
    
    # C: get fossil fuel table by manager
    # C-1: group by manager to fossil fuel holdings
    df_manager_f = df_f.filter(items=['manager', 'market_value']).groupby(['manager']).sum().reset_index()
    # C-2: group by manager to total holdings
    df_manager_t = df.filter(items=['manager', 'market_value']).groupby(['manager']).sum().reset_index()
    # C-3: merge fossil fuel and total columns into one table
    df_manager = pd.merge(df_manager_f, df_manager_t, on='manager', how='outer').fillna(0)
    df_manager.rename(columns={'market_value_x': ff, 'market_value_y': total}, inplace= True)
    # C-4: add percentage columns(fossil fuel/total holding)
    df_manager[perc] = df_manager[ff] / df_manager[total]
    
    # C-5: get number of fossil issuer for each manager
    df_manager_n = df_f.filter(items=['manager', 'name', 'market_value']).groupby(['manager', 'name']).count().reset_index()
    df_manager_n['Number'] = '1'
    df_manager_n = df_manager_n.filter(items=['manager', 'Number']).groupby(['manager']).count().reset_index()
    
    # C-6: get number of fossil issuer for the whole portfolio
    unique_f = df_f['name'].unique()
    uni_f = len(unique_f)
    # C-7: merge number column into the table
    df_manager = pd.merge(df_manager, df_manager_n, on='manager', how='outer').fillna(0)

    # C-8: add sum of fossil fuel, total holding, %ff/total, number of issuers
    n = len(df_manager.index)
    f_manager = sum(df_manager[ff])
    t_manager = sum(df_manager[total])
    p_manager = f_manager / t_manager
    df_manager.loc[n] = ['Total Portfolio', f_manager, t_manager, p_manager, uni_f]

    return df_manager
    
    # D: get fossil fuel table by asset class
    #delete the rows with all zeros
    df_t = df_t.replace(0, nan)
    df_t = df_t.dropna(how='all', axis=0)
    df_t = df_t.replace(nan, 0)
    
    df_assetclass_f = df_f.filter(items=['security_type','market_value']).groupby(['security_type']).sum().reset_index()

    df_assetclass_t=df_t.filter(items=['security_type','market_value']).groupby(['security_type']).sum().reset_index()

    df_assetclass=pd.merge(df_assetclass_f,df_assetclass_t, on='security_type',how='right').fillna(0)
    df_assetclass.rename(columns={'market_value_x': ff,'market_value_y': total},inplace=True)
    df_assetclass = df_assetclass[df_assetclass.Total != 0]
    df_assetclass[perc]=df_assetclass[ff]/df_assetclass[total]

    
    n=len(df_assetclass.index)
    t_sec=sum(df_assetclass[total])
    f_sec=sum(df_assetclass[ff])
    p_sec=f_sec/t_sec
    df_assetclass.loc[n]=['Total Portfolio',f_sec,t_sec,p_sec]
    
    df_assetclass_json=df_assetclass.to_json(orient='index')
    
    print df_assetclass.head(20)
    return df_category, df_manager, df_assetclass



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







# def ff_manager(df):

#
#
# def ff_category(df):
#
#
# def ff_assetclass(df):
#


