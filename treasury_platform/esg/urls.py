from django.conf.urls import url
from . import views

urlpatterns = [
    url(r'^$', views.index, name='index'),
    url(r'^fossil$', views.fossil, name='fossil'),
    url(r'^tobacco$', views.tobacco, name='tobacco'),
    url(r'^military$', views.military, name='military'),
    url(r'^manager/', views.manager, name='manager'),
    url(r'^assetclass/', views.assetclass, name='assetclass'),
    url(r'^carbon/', views.carbon, name='carbon'),
    url(r'^carbonstack/', views.carbonStack, name='carbonstack'),
]