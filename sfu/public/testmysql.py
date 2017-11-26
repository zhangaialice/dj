import mysql.connector
import pandas as pd
from numpy import nan
import json


# 1. get "holding" data from mysql to "list", convert to DataFrame (panda),
# 2. manipulate data using pd, generate three table, group fossil fuel holdings by category, ,manager, and asset class.
# 3. note that the definition of the fossil fuel holding are differentiate between fixed income and equity, and defined by industry sector by BISC, and with some exceptions

#------------------ link mysql with python, write SQL

cnx = mysql.connector.connect(user='root', password='ai',
                              host='localhost',
                              database='sfu_treasury')
cursor = cnx.cursor(buffered=True)

# except mysql.connector.Error as err:
#   if err.errno == errorcode.ER_ACCESS_DENIED_ERROR:
#     print("Something is wrong with your user name or password")
#   elif err.errno == errorcode.ER_BAD_DB_ERROR:
#     print("Database does not exist")
#   else:
#     print(err)
#   cnx.close()

def fossilfuel(year):


    query = ("SELECT * FROM holding WHERE Year = 2015")


    cursor.execute(query)

    emp_no= cursor.fetchall()
    # print type(emp_no)
    # print emp_no
    row = list(cursor.column_names)

    # print(row)

    # print list(emp_no)
    # print type(emp_no)

    df= pd.DataFrame(list(emp_no), columns=row)
    # print df.head(2)


    #------------------------------
    # Define "fossil fuel sectors" and "exception corporation", additional sectors can be manually added
    class_e = ['Oil & Gas Drilling', 'Integrated Oil & Gas', 'Oil & Gas Exploration & Produc',
               'Oil & Gas Refining & Marketing', 'Oil & Gas Storage & Transporta', 'Coal & Consumable Fuels',
               'Diversified Metals & Mining', 'Gas Utilities', 'Multi-Utilities',
               'Independent Power Producers & Energy Traders']
    class_fi = ['Exploration & Production', 'Integrated Oils', 'Oil&Gas', 'Pipelines', 'Refining & Marketing',
                'Renewable Energy', 'Mining', 'Gas', 'Gas Distribution']
    class_exp = ['CAMECO CORP', 'CAMECO CORPORATION', 'MAJOR DRILLING GROUP INTERNATI']

    df_t = df.filter(items=['Category', 'Manager', 'Security_Type', 'Name', 'Market_Value']).fillna(0)
    # print df_t.head(10)

    # fossil fuel table
    df_e = df.loc[df['Security_Type'].isin(['Canadian Equity', 'International Equity', 'US Equity'])]
    df_e = df_e.loc[df['Sub_Industry'].isin(class_e)].filter(
        items=['Category', 'Manager', 'Security_Type', 'Name', 'Market_Value'])
    sum_fuel_e = sum(df_e['Market_Value'])
    df_fi = df.loc[df['Security_Type'].isin(['Fixed Income'])]
    df_fi = df_fi.loc[df['Industry_Group'].isin(class_fi)].filter(
        items=['Category', 'Manager', 'Security_Type', 'Name', 'Market_Value'])
    sum_fuel_fi = sum(df_fi['Market_Value'])

    df_f = df_e.append(df_fi)
    #
    # print df_f.head(10)

    #------------get fossil fuel issuer mapping and replace

    query = ("SELECT old_name FROM fossilfuel_issuermapping")

    cursor.execute(query)
    emp_no= cursor.fetchall()
    COLUMN = 0
    old_name =[elt[COLUMN] for elt in emp_no]
    # print old_name

    query = ("SELECT new_name FROM fossilfuel_issuermapping")

    cursor.execute(query)
    emp_no= cursor.fetchall()
    COLUMN = 0
    new_name =[elt[COLUMN] for elt in emp_no]
    # print new_name



    df_f['Name'].replace(old_name,new_name, inplace=True)


    # df_test= df_f.loc[df_f['Name']=="ENBRIDGE INC"]

    # print df_test.head(50)


    # print df_f.head(30)
    # print list(emp_no)
    # print type(emp_no)



    #---------exclude some issuers from fossil fuel list, identified by the list below

    # Define "fossil fuel sectors" and "exception corporation", additional sectors can be manually added
    class_e = ['Oil & Gas Drilling', 'Integrated Oil & Gas', 'Oil & Gas Exploration & Produc',
               'Oil & Gas Refining & Marketing', 'Oil & Gas Storage & Transporta', 'Coal & Consumable Fuels',
               'Diversified Metals & Mining', 'Gas Utilities', 'Multi-Utilities',
               'Independent Power Producers & Energy Traders']
    class_fi = ['Exploration & Production', 'Integrated Oils', 'Oil&Gas', 'Pipelines', 'Refining & Marketing',
                'Renewable Energy', 'Mining', 'Gas', 'Gas Distribution']
    class_exp = ['CAMECO CORP', 'CAMECO CORPORATION', 'MAJOR DRILLING GROUP INTERNATI']


    #remove exception rows
    df_f.drop(df_f[df_f['Name'].isin(class_exp)].index, inplace=True)

    #----------------generate table1 : fossil fuel - by category -- fossilfuel$, total$, (fossilfuel/total %)
    # table 1:sorted by category, percentage(fossil/total), and add a "Total" row
    str_a = 'FossilFuel_'+year
    str_b = 'Total_'+year
    str_perc='Percentage_'+year
    # df_one_test = df_f.filter(items=['Category', 'Market_Value']).groupby(['Category']).sum()
    # print df_one_test.head(10)
    df_one_f = df_f.filter(items=['Category', 'Market_Value']).groupby(['Category']).sum().reset_index()
    # print df_one_f.head(10)
    df_one_t = df.filter(items=['Category', 'Market_Value']).groupby(['Category']).sum().reset_index()
    # print df_one_t.head(10)
    df_one = pd.merge(df_one_f, df_one_t, on='Category', how='outer').fillna(0).rename(
        columns={'Market_Value_x': str_a, 'Market_Value_y': str_b})
    print df_one.head(10)

    # print df_one.head(3)
    df_one[str_perc] = df_one[str_a] / df_one[str_b]
    # print df_one.head(10)


    ##adding the last sum row
    f_category = sum(df_one[str_a])
    t_category = sum(df_one[str_b])
    p_category = sum(df_f['Market_Value']) / sum(df_t['Market_Value'])
    df_one.loc[2] = ['Total Portfolio', f_category, t_category, p_category]
    pd.options.display.float_format = '{:20,.2f}'.format

    # print df_one.head(10)

    #-------------------generate table2 : fossil fuel - by manager - fossilfuel$, total$, percentage %, number of issuers

    # table 2: sorted by manager, percentage (fossil/total), counts of issuers
    df_two_f = df_f.filter(items=['Manager', 'Market_Value']).groupby(['Manager']).sum().reset_index()
    df_two_t = df.filter(items=['Manager', 'Market_Value']).groupby(['Manager']).sum().reset_index()
    df_two = pd.merge(df_two_f, df_two_t, on='Manager', how='outer').fillna(0).rename(
        columns={'Market_Value_x': str_a, 'Market_Value_y': str_b})
    df_two[str_perc] = df_two[str_a] / df_two[str_b]

    ## get number of fossil issuer for each manager
    df_two_n = df_f.filter(items=['Manager', 'Name', 'Market_Value']).groupby(['Manager', 'Name']).count().reset_index()
    df_two_n['Number'] = '1'
    # print df_two_n.head(20)
    df_two_n = df_two_n.filter(items=['Manager', 'Number']).groupby(['Manager']).count().reset_index()

    ## get number of fossil issuer for the whole portfolio
    unique_f = df_f['Name'].unique()
    uni_f = len(unique_f)

    df_two = pd.merge(df_two, df_two_n, on='Manager', how='outer').fillna(0)
    ## add the row with sum
    n = len(df_two.index)
    f_manager = sum(df_two[str_a])
    t_manager = sum(df_two[str_b])
    p_manager = f_manager / t_manager
    df_two.loc[n] = ['Total Portfolio', f_manager, t_manager, p_manager, uni_f]
    # np.round(df_two, decimals=2)
    pd.options.display.float_format = '{:20,.2f}'.format
    # print df_two.head(30)



    #--------------------------generate table3: fossil fuel - by category - fossilfuel$, total$, percentage %
    # table 3: sorted by security type, percentage(fossil/total)
    query = ("SELECT class_old FROM class_mapping")

    cursor.execute(query)
    emp_no= cursor.fetchall()
    COLUMN = 0
    old_class =[elt[COLUMN] for elt in emp_no]
    # print old_class

    query = ("SELECT class_new FROM class_mapping")

    cursor.execute(query)
    emp_no= cursor.fetchall()
    COLUMN = 0
    new_class =[elt[COLUMN] for elt in emp_no]
    # print new_class


    df_f['Security_Type'].replace(old_class,new_class, inplace=True)

    df_t['Security_Type'].replace(old_class, new_class, inplace=True)

    ##delete the rows with all zeros
    df_t = df_t.replace(0, nan)
    df_t = df_t.dropna(how='all', axis=0)
    df_t = df_t.replace(nan, 0)

    df_three_f = df_f.filter(items=['Security_Type','Market_Value']).groupby(['Security_Type']).sum().reset_index()

    df_three_t=df_t.filter(items=['Security_Type','Market_Value']).groupby(['Security_Type']).sum().reset_index()
    df_three=pd.merge(df_three_f,df_three_t, on='Security_Type',how='right').fillna(0).rename(columns={'Market_Value_x': str_a,'Market_Value_y': str_b})
    print df_three.head(10)
    df_three[str_perc]=df_three[str_a]/df_three[str_b]
    # pd.options.display.float_format = '{:20,.2f}'.format

    n=len(df_three.index)
    t_sec=sum(df_three[str_b])
    f_sec=sum(df_three[str_a])
    p_sec=f_sec/t_sec
    df_three.loc[n]=['Total Portfolio',f_sec,t_sec,p_sec]

    #-----------------------------------------------------------------------------------------------------------------------
    #convert dataframe to dictionary
    dict_three_list=df_three.to_dict(orient='list')
    dict_three_dict=df_three.to_dict(orient='dict')
    dict_three_series=df_three.to_dict(orient='series')
    dict_three_split=df_three.to_dict(orient='split')
    dict_three_records=df_three.to_dict(orient='records')
    dict_three_index=df_three.to_dict(orient='index')
    print df_three.head(10)
    # print dict_three_list,"\n","\n", dict_three_split,"\n","\n", dict_three_series,"\n","\n",dict_three_split,"\n","\n",dict_three_records,"\n","\n",dict_three_index,"\n","\n"

    #combine all tables and generate a dictionary
    dict_three_list=df_three.to_dict(orient='list')
    dict_two_list=df_two.to_dict(orient='list')
    combine_dict={"by assetclass":dict_three_list,"by manager":dict_two_list}

    #convert dictionary to json, adding function to fix that json.dumps cannot handle decimal
    from decimal import Decimal

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

    df_combine_json = json.dumps(combine_dict, default=defaultencode)
    # savefile = open('test.json', 'a')
    savefile.write("\"%s\": "%year)
    # savefile = open('test.json', 'a')
    savefile.write(df_combine_json)



def fossilfuel_multiyear(year1,year2):
    global savefile
    savefile = open('test.json','w')
    savefile.write("{")
    fossilfuel(year1)
    savefile.write(",")
    fossilfuel(year2)
    savefile.write("}")


fossilfuel_multiyear('2015','2016')

cursor.close()

cnx.close()



