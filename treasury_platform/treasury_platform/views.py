
from django.shortcuts import render
from django.template.response import TemplateResponse
from django.http import HttpResponseRedirect
from django.forms.models import model_to_dict
import pandas as pd
from decimal import Decimal
# from .test import fakefloat, defaultencode
from .forms import NameForm, Year
from .models import holding
from .function import fossil_fuel
from django.template import Context, Template
from .function_test import FossilFuel, fakefloat, defaultencode
import json


def get_name(request):
    # if this is a POST request we need to process the form data
    if request.method == 'POST':
        # create a form instance and populate it with data from the request:
        form = NameForm(request.POST)
        if form.is_valid():  # All validation rules pass
            # Process the data in form.cleaned_data
            # ...
            a=form.cleaned_data['your_name']
            b=form.cleaned_data['your_email']
            result=a+b
            print result
        # check whether it's valid:
            return render(request, 'treasury_platform/index.html', {'form': form, 'email': a, 'result': result})

    # if a GET (or any other method) we'll create a blank form
    else:
        form = NameForm()

    return render(request, 'treasury_platform/index.html', {'form': form})


def get_data(request):
    # get year from form in webpage
    if request.method == 'POST':
        # create a form instance and populate it with data from the request:
        form = Year(request.POST)
        if form.is_valid():  # All validation rules pass
            yr = form.cleaned_data['your_year']
    # pass year as input in the calculation, get three table in DataFrame
        test=FossilFuel()
        test._year = yr
        test.get_table()
        tb_category= test.f_category()
        tb_manager=test.f_manager()
        tb_assetclass= test.f_assetclass()


    # convert data from DataFrame--> dict (columns) --> list for one column --> json and delete "Decimal()" messy [a,b,c]
        #three tables
        d_category=tb_category.to_dict(orient='list')
        d_manager=tb_manager.to_dict(orient='list')
        d_assetclass = tb_assetclass.to_dict(orient='list')
        #each columns in three tables
        m_manager = d_manager['manager']
        m_percent = d_manager['Percentage']



        js_percent = json.dumps(m_percent, default=defaultencode)
        js_manager = json.dumps (m_manager)



        # return TemplateResponse(request,'treasury_platform/test.html',{'form': form, 'data': [d_category,d_manager,d_assetclass]})
        # return TemplateResponse(request, 'treasury_platform/test.html', {'form': form, 'data': [js_manager,js_percent]})
        return TemplateResponse(request, 'treasury_platform/graph.html', {'form': form, 'manager': js_manager, 'data': js_percent})

    else:
        form = Year()

        return render(request, 'treasury_platform/graph.html', {'form': form})


def get_graph(request):







    return render(request, 'treasury_platform/graph.html',)
# def test_data():
#     data = holding.objects.values()
#     dic_data=[entry for entry in data]
#     # tl=pd.DataFrame(dic_data).head(3)
#     from .function import fossil_fuel
#     tl=fossil_fuel(dic_data)
#     nice=tl.to_dict(orient='records')
#     return nice
# test_data()
