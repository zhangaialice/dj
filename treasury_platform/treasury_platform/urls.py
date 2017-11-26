"""treasury_platform URL Configuration

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/dev/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  url(r'^$', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  url(r'^$', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.conf.urls import url, include
    2. Add a URL to urlpatterns:  url(r'^blog/', include('blog.urls'))
"""
from django.conf.urls import url,include
from django.contrib import admin
from . import views
from material.frontend import urls as frontend_urls

urlpatterns = [
    url(r'^admin/', admin.site.urls),
    url(r'^esg/', include('esg.urls')),
    url(r'^carbon/', include('carbon.urls')),
    url(r'^asset_class/',include('asset_class.urls')),
    url(r'^$',views.get_name, name='index'),
    url(r'^test/',views.get_data, name='test'),
    url(r'^graph/',views.get_data, name='graph'),
]

