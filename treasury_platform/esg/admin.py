# -*- coding: utf-8 -*-
from django.contrib import admin
from treasury_platform.models import holding

class HoldingAdmin(admin.ModelAdmin):
    list_display = ['year','isin','name','security_type']

admin.site.register(holding, HoldingAdmin)


# Register your models here.
