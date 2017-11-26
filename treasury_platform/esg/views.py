from django.shortcuts import render
from django.template.response import TemplateResponse
from esg.forms import Year, MilitaryForm, ManagerYearCategory, YearCategoryAssetclass, MultiYear, CarbonDropdown, Carbonstack
from esg.functions import FossilFuel, defaultencode, Industry, Manager, AssetClass,Carbon,CarbonStack
import json
import numpy as np
from numpy import inf

# from esg.models import CarbonMsci, CarbonHolding
import pandas as pd
import colorsys
# from decimal import Decimal

def index(request):

    return render(request, 'esg/index.html')


# year1: 2015
# year2: 2016
# output table: Manager, Category, Asset Class
def fossil(request):
    #get user input from web
    if request.method == 'POST':
        # create a form instance and populate it with data from the request:
        form = MultiYear(request.POST)

        if form.is_valid():  # All validation rules pass
            yr1 = form.cleaned_data['your_year1']
            yr2 = form.cleaned_data['your_year2']
            output = form.cleaned_data['your_output']
        # get dataframe from two input years
        test1 = FossilFuel()
        test2 = FossilFuel()
        test1._year = int(yr1)
        test2._year = int(yr2)
        test1.get_table()
        test2.get_table()
        if output =='category':
            df1 = test1.f_category()
            df2 = test2.f_category()
        elif output=='manager':
            df1 = test1.f_manager()
            df2 = test2.f_manager()
        elif output=='security_type':
            df1 = test1.f_assetclass()
            df2 = test2.f_assetclass()
        #merge two dataframes from two years
        df_merge = pd.merge(df1, df2, on=output, how='outer').fillna(0)
        #if dataframe has the sum value in the last row, get two sums and delete the sum row
        a = df_merge.loc[df_merge[output] == 'Total Portfolio','Percentage_x'].iloc[0]
        b = df_merge.loc[df_merge[output] == 'Total Portfolio','Percentage_y'].iloc[0]
        df_merge.drop(df_merge[df_merge[output] =='Total Portfolio'].index,inplace=True)
        #delete rows with all zeros
        df_merge = df_merge.drop(df_merge[(df_merge.Percentage_x == 0) & (df_merge.Percentage_y == 0)].index)

        #convert the dataframe object to dict[list]
        d_merge = df_merge.to_dict(orient='list')
        #get three list: m_items, m_output1, m_output2
        m_items=d_merge[output]
        m_items.append('Total Portfolio')
        m_output1=d_merge['Percentage_x']
        m_output2 = d_merge['Percentage_y']
        #append the sum to the three lists
        m_output1.append(a)
        m_output2.append(b)
        # change float format to percentage in the list, to display in tables
        m_output1 = [round(elem, 2) for elem in m_output1]
        m_output2 = [round(elem, 2) for elem in m_output2]
        p_output1=listToPercent(m_output1)
        p_output2=listToPercent(m_output2)


        #chartjs takes json, drop" u decimal" in list and convert to json
        js_output1 = json.dumps(m_output1, default=defaultencode)
        js_output2 = json.dumps(m_output2, default=defaultencode)
        js_manager = json.dumps(m_items)
        #table takes zip list, no need pass in json
        list = zip(m_items, p_output1, p_output2)
        #form + json (columns)+ list (columns)+ inputs(year1, year2, group)
        if output == 'security_type':
            output = 'Asset Class'
        return TemplateResponse(request, 'esg/fossil.html',{'form': form, 'manager': js_manager,'list':list,'data1':js_output1,'data2':js_output2,'year1':yr1,'year2':yr2, 'group':output})

    else:
        form = MultiYear()

        return render(request, 'esg/fossil.html', {'form': form})

def listToPercent(l):
  return ["%.2f%%" %(i * 100) for i in l]



# ESG: tobacco
# year1: 2015
# year2: 2016
# output table: Category, Manager
def tobacco(request):
    # get year from form in webpage
    if request.method == 'POST':
        # create a form instance and populate it with data from the request:
        form = MilitaryForm(request.POST)
        if form.is_valid():  # All validation rules pass
            yr1 = form.cleaned_data['your_year1']
            yr2 = form.cleaned_data['your_year2']
            output = form.cleaned_data['your_output']
            # pass year as input in the calculation, get three table in DataFrame
        test1 = Industry()
        test2 = Industry()
        test1._year = int(yr1)
        test2._year = int(yr2)
        test1.get_table()
        test2.get_table()
        if output == 'category':
            df1 = test1.f_category()
            df2 = test2.f_category()
        elif output == 'manager':
            df1 = test1.f_manager()
            df2 = test2.f_manager()

        # merge two dataframes from two years
        df_merge = pd.merge(df1, df2, on=output, how='outer').fillna(0)
        # if dataframe has the sum value in the last row, get two sums and delete the sum row
        a = df_merge.loc[df_merge[output] == 'Total Portfolio', 'Percentage_x'].iloc[0]
        b = df_merge.loc[df_merge[output] == 'Total Portfolio', 'Percentage_y'].iloc[0]
        df_merge.drop(df_merge[df_merge[output] == 'Total Portfolio'].index, inplace=True)
        # delete rows with all zeros
        df_merge = df_merge.drop(df_merge[(df_merge.Percentage_x == 0) & (df_merge.Percentage_y == 0)].index)

        # convert the dataframe object to dict[list]
        d_merge = df_merge.to_dict(orient='list')
        # get three list: m_items, m_output1, m_output2
        m_items = d_merge[output]
        m_items.append('Total Portfolio')
        m_output1 = d_merge['Percentage_x']
        m_output2 = d_merge['Percentage_y']
        # append the sum to the three lists
        m_output1.append(a)
        m_output2.append(b)
        m_output1 = [round(elem, 2) for elem in m_output1]
        m_output2 = [round(elem, 2) for elem in m_output2]
        # change float format to percentage in the list, to display in tables
        p_output1 = listToPercent(m_output1)
        p_output2 = listToPercent(m_output2)

        # chartjs takes json, drop" u decimal" in list and convert to json
        js_output1 = json.dumps(m_output1, default=defaultencode)
        js_output2 = json.dumps(m_output2, default=defaultencode)
        js_manager = json.dumps(m_items)
        # table takes zip list, no need pass in json
        list = zip(m_items, p_output1, p_output2)

        return TemplateResponse(request, 'esg/military.html',
                                {'form': form, 'manager': js_manager, 'list': list, 'data1': js_output1,
                                 'data2': js_output2, 'year1': yr1, 'year2': yr2, 'group': output})

    else:
        form = MilitaryForm()

        return render(request, 'esg/tobacco.html', {'form': form})


# year1: 2015
# year2: 2016
# output table: by category, by manager
def military(request):
    # get year from form in webpage
    if request.method == 'POST':
        # create a form instance and populate it with data from the request:
        form = MilitaryForm(request.POST)
        if form.is_valid():  # All validation rules pass
            yr1 = form.cleaned_data['your_year1']
            yr2 = form.cleaned_data['your_year2']
            output = form.cleaned_data['your_output']
    # pass year as input in the calculation, get three table in DataFrame
        test1 = Industry()
        test2 = Industry()
        test1._year = int(yr1)
        test2._year = int(yr2)
        test1.sector = 'Aerospace & Defense'
        test2.sector = 'Aerospace & Defense'
        test1.get_table()
        test2.get_table()
        if output =='category':
            df1= test1.f_category()
            df2 = test2.f_category()
        elif output=='manager':
            df1 = test1.f_manager()
            df2 = test2.f_manager()

        # merge two dataframes from two years
        df_merge = pd.merge(df1, df2, on=output, how='outer').fillna(0)
        # if dataframe has the sum value in the last row, get two sums and delete the sum row
        a = df_merge.loc[df_merge[output] == 'Total Portfolio', 'Percentage_x'].iloc[0]
        b = df_merge.loc[df_merge[output] == 'Total Portfolio', 'Percentage_y'].iloc[0]
        df_merge.drop(df_merge[df_merge[output] == 'Total Portfolio'].index, inplace=True)
        # delete rows with all zeros
        df_merge = df_merge.drop(df_merge[(df_merge.Percentage_x == 0) & (df_merge.Percentage_y == 0)].index)

        # convert the dataframe object to dict[list]
        d_merge = df_merge.to_dict(orient='list')
        # get three list: m_items, m_output1, m_output2
        m_items = d_merge[output]
        m_items.append('Total Portfolio')
        m_output1 = d_merge['Percentage_x']
        m_output2 = d_merge['Percentage_y']
        # append the sum to the three lists
        m_output1.append(a)
        m_output2.append(b)
        # change float format to percentage in the list, to display in tables
        p_output1 = listToPercent(m_output1)
        p_output2 = listToPercent(m_output2)
        m_output1 = [round(elem, 2) for elem in m_output1]
        m_output2 = [round(elem, 2) for elem in m_output2]

        # chartjs takes json, drop" u decimal" in list and convert to json
        js_output1 = json.dumps(m_output1, default=defaultencode)
        js_output2 = json.dumps(m_output2, default=defaultencode)
        js_manager = json.dumps(m_items)
        # table takes zip list, no need pass in json
        list = zip(m_items, p_output1, p_output2)

        return TemplateResponse(request, 'esg/military.html',{'form': form, 'manager': js_manager,'list':list,'data1':js_output1,'data2':js_output2,'year1':yr1,'year2':yr2, 'group':output})

    else:
        form = MilitaryForm()

        return render(request, 'esg/military.html', {'form': form})

# manager: SIAS, BEAM...
# year 2016
# category: Endowment, Non_Endowment, All
# output: Asset Class, Fixed Income, Canadian Equity, Global Equity, All Equity
def manager(request):
    # get year from form in webpage
    if request.method == 'POST':
        # create a form instance and populate it with data from the request:
        form = ManagerYearCategory(request.POST)
        if form.is_valid():  # All validation rules pass

            yr = form.cleaned_data['your_year']
            manager = form.cleaned_data['your_manager']
            category = form.cleaned_data['your_category']
            output = form.cleaned_data['your_output']
            # pass year as input in the calculation, get three table in DataFrame
        test = Manager()
        test._manager=manager
        test._year = yr
        test._category=category

        test.get_data()
        if output== 'Asset Class':
            tb_assetclass = test.output_class()
            d_assetclass = tb_assetclass.to_dict(orient='list')
            m_assetclass = d_assetclass['security_type']
            m_percent = d_assetclass['Percentage']

        elif output=='Fixed Income':
            tb_assetclass = test.output_fi()
            d_assetclass = tb_assetclass.to_dict(orient='list')
            m_assetclass = d_assetclass['industry_sector']
            m_percent = d_assetclass['Percentage']

        # tb_manager = test.f_manager()
        elif output=='Canadian Equity':
            tb_assetclass = test.output_ce()
            d_assetclass = tb_assetclass.to_dict(orient='list')
            m_assetclass = d_assetclass['sector']
            m_percent = d_assetclass['Percentage']
        elif output=='Global Equity':
            tb_assetclass = test.output_ge()
            d_assetclass = tb_assetclass.to_dict(orient='list')
            m_assetclass = d_assetclass['sector']
            m_percent = d_assetclass['Percentage']

        elif output=='Total Equity':
            tb_assetclass = test.output_te()
            d_assetclass = tb_assetclass.to_dict(orient='list')
            m_assetclass = d_assetclass['sector']
            m_percent = d_assetclass['Percentage']


        js_percent = json.dumps(m_percent, default=defaultencode)
        js_manager = json.dumps(m_assetclass)

        return TemplateResponse(request, 'esg/manager.html', {'form': form, 'manager': js_manager, 'data': js_percent})

    else:
        form = ManagerYearCategory()


        return render(request, 'esg/manager.html', {'form': form})


# need debugging
# choose: year, e.g. 2016
# category(Endowment, Non_Endowment, All]
# assetclass=Total Equity, Global Equity, Canadian Equity, International Equity, Emerging Market, US Equity, Total Fixed Income, Cash
# output: Manager, Sector
def assetclass(request):
    # get year from form in webpage
    if request.method == 'POST':
        # create a form instance and populate it with data from the request:
        form = YearCategoryAssetclass(request.POST)
        if form.is_valid():  # All validation rules pass
            yr = form.cleaned_data['your_year']
            assetclass = form.cleaned_data['your_assetclass']
            category = form.cleaned_data['your_category']
            output = form.cleaned_data['your_output']
            # pass year as input in the calculation, get three table in DataFrame
        test = AssetClass()
        test._assetclass = assetclass
        test._year = int(yr)
        test._category = category

        test.get_data()
        if output == 'Manager':
            tb_manager = test.by_manager()
            d_manager = tb_manager.to_dict(orient='list')
            m_items = d_manager['manager']
            m_percent = d_manager['Percentage']

        elif output == 'Sector':
            tb_sector = test.by_sector()
            d_sector = tb_sector.to_dict(orient='list')
            m_items = d_sector['sector']
            m_percent = d_sector['Percentage']


        js_percent = json.dumps(m_percent, default=defaultencode)
        js_items = json.dumps(m_items)

        return TemplateResponse(request, 'esg/assetclass.html', {'form': form, 'manager': js_items, 'data': js_percent})

    else:
        form = YearCategoryAssetclass()

        return render(request, 'esg/assetclass.html', {'form': form})

# choose: year, e.g. 2017
# group=[sector, category, manager, country, security_type]
# output =[emission, emission per million, selection contribution]
def carbon(request):
    if request.method == 'POST':
        # create a form instance and populate it with data from the request:
        form = CarbonDropdown(request.POST)
        if form.is_valid():  # All validation rules pass
            yr1 = form.cleaned_data['your_year1']
            yr2 = form.cleaned_data['your_year2']
            group = form.cleaned_data['your_group']
            output = form.cleaned_data['your_output']

            sample1 = Carbon()
            sample1._year=int(yr1)
            sample1._group = group
            df_carbon1= sample1.get_data()


            sample2 = Carbon()
            sample2._year=int(yr2)
            sample2._group = group
            df_carbon2= sample2.get_data()
            df_merge = pd.merge(df_carbon1, df_carbon2, on=group, how='outer').fillna(0)
            df_merge = df_merge.drop(df_merge[(df_merge.emission2_x ==0) & (df_merge.emission2_y ==0)].index)
            d_merge = df_merge.to_dict(orient='list')

            m_items = d_merge[group]
            m_items.append('Total Portfolio')

            if output=='emission':
                m_output1=d_merge['emission2_x']
                m_output2=d_merge['emission2_y']
            elif output=='emission per million':
                m_output1=d_merge['emission per million_x']
                m_output2=d_merge['emission per million_y']
            elif output=='selection contribution':
                m_output1=d_merge['selection contribution_x']
                m_output2=d_merge['selection contribution_y']
            a = sum(m_output1)
            b= sum(m_output2)
            m_output1.append(a)
            m_output2.append(b)
            m_output1= [round(elem, 2) for elem in m_output1]
            m_output2 = [round(elem, 2) for elem in m_output2]

            test =type(m_items)
            # js_output1 = json.dumps(m_output1, default=defaultencode)
            # js_output2 = json.dumps(m_output2, default=defaultencode)
            js_items = json.dumps(m_items)
            list=zip(m_items,m_output1,m_output2)
            if group== 'security_type':
                group ='Asset Class'
            return TemplateResponse(request, 'esg/carbon.html', {'form': form, 'output': output,'group': group,'manager': js_items,'sum1':a,'sum2':b,'year1': yr1, 'year2':yr2,'data1':m_output1,'data2': m_output2,'list':list})

    else:
        form = CarbonDropdown()

        return render(request, 'esg/carbon.html', {'form': form})


def carbonStack1(request):
    if request.method == 'POST':
        # create a form instance and populate it with data from the request:
        form = Carbonstack(request.POST)
        if form.is_valid():  # All validation rules pass
            yr = form.cleaned_data['your_year']
            # manager = form.cleaned_data['your_manager']
            m_list = ['Pyramis', 'Bissett', 'NG', 'BMO', 'Henderson', 'Fiera', 'SIAS', 'BEAM', 'SPI', 'SPG']
            m_pack = []
            data_pack = []
            df_combine = pd.DataFrame()
            for manager in m_list:
                sample1 = CarbonStack()
                sample1._year = int(yr)
                sample1._manager = manager
                df_carbon = sample1.get_data()
                df_combine = pd.merge(df_combine, df_carbon, on=['sector'], how='outer').fillna(0)
                print df_combine.head(10)
                # sample2 = Carbon()
                # sample2._year = int(yr2)
                # sample2._group = group
                # df_carbon2 = sample2.get_data()
                # df_merge = pd.merge(df_carbon1, df_carbon2, on=group, how='outer').fillna(0)
                # df_merge = df_merge.drop(df_merge[(df_merge.emission2_x == 0) & (df_merge.emission2_y == 0)].index)
            d_combine = df_combine.to_dict(orient='list')
            m_items = d_combine['sector']
            m_data = d_combine['emission_per_mil_x']
            m_pack.append(m_items)
            data_pack.append(m_data)

            # m_items.append('Total Portfolio')
            #
            # if output == 'emission':
            #     m_output1 = d_merge['emission2_x']
            #     m_output2 = d_merge['emission2_y']
            # elif output == 'emission per million':
            #     m_output1 = d_merge['emission per million_x']
            #     m_output2 = d_merge['emission per million_y']
            # elif output == 'selection contribution':
            #     m_output1 = d_merge['selection contribution_x']
            #     m_output2 = d_merge['selection contribution_y']
            # a = sum(m_output1)
            # b = sum(m_output2)
            # m_output1.append(a)
            # m_output2.append(b)
            # m_output1 = [round(elem, 2) for elem in m_output1]
            # m_output2 = [round(elem, 2) for elem in m_output2]
            #
            # test = type(m_items)
            # # js_output1 = json.dumps(m_output1, default=defaultencode)
            # # js_output2 = json.dumps(m_output2, default=defaultencode)
            # js_items = json.dumps(m_items)
            # list = zip(m_items, m_output1, m_output2)
            # if group == 'security_type':
            #     group = 'Asset Class'
            return TemplateResponse(request, 'esg/carbonstack.html',
                                    {'form': form, 'manager': m_pack, 'data': data_pack})

    else:
        form = Carbonstack()

        return render(request, 'esg/carbonstack.html', {'form': form})


def carbonStack(request):
    if request.method == 'POST':
        # create a form instance and populate it with data from the request:
        form = Carbonstack(request.POST)
        if form.is_valid():  # All validation rules pass
            yr = form.cleaned_data['your_year']
            # manager = form.cleaned_data['your_manager']
            m_list = ['Pyramis', 'Bissett', 'NG', 'BMO', 'Henderson', 'Fiera', 'SIAS', 'BEAM', 'SPI', 'SPG']
            dfs= pd.DataFrame(columns=['sector'])
            for suck in m_list:
                sample1 = CarbonStack()
                sample1._year = int(yr)
                sample1._manager =suck
                df1 = sample1.get_data()
                df1.rename(columns={'emission_per_mil': suck}, inplace=True)

                # dfs.append(df1)
                dfs = pd.merge(dfs, df1, on=['sector'], how='outer').fillna(0)
            dfs_test = dfs.set_index('sector')
            dfs_test = dfs_test[(dfs_test.T > 1).any()]
            dfs=dfs_test.reset_index()

            d_carbon = dfs.to_dict(orient='list')
            m_items = d_carbon['sector']
            for suck in m_list:
                b = d_carbon[suck]
                exec ("%s = b" % (suck))


            js_items = json.dumps(m_items)
            #need more investigation, pyramis emission per million has two inf value, now manually replace with 0
            x = np.array(Pyramis)
            x[x == inf] = 0
            Pyramis = x.tolist()
            #need to be change: color spectrum is not pretty
            colors=['#770518', '#808080', '#FF5733', '#008080', '#0082c8', '#E6B0AA', '#e6194b', '#C39BD3', '#F4E081', '#000080']
            #need automation, add list names to a zip is hardcoded now
            list = zip(m_items,Pyramis,Bissett,NG,BMO,Henderson,Fiera, SIAS, BEAM, SPI,SPG, colors)


            return TemplateResponse(request, 'esg/carbonstack.html',
                                    {'form': form, 'alldata': d_carbon,'list': list,'managerlist':m_list})

    else:
        form = Carbonstack()

        return render(request, 'esg/carbonstack.html', {'form': form})



