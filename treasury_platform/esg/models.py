# This is an auto-generated Django model module.
# You'll have to do the following manually to clean this up:
#   * Rearrange models' order
#   * Make sure each model has one field with primary_key=True
#   * Make sure each ForeignKey has `on_delete` set to the desired behavior.
#   * Remove `managed = False` lines if you wish to allow Django to create, modify, and delete the table
# Feel free to rename the models, but don't rename db_table values or field names.
from __future__ import unicode_literals

from django.db import models


class CarbonHolding(models.Model):
    year = models.IntegerField(blank=True, null=True)
    isin = models.CharField(max_length=20, blank=True, null=True)
    holdings = models.CharField(max_length=12, blank=True, null=True)
    name = models.CharField(max_length=45, blank=True, null=True)
    id = models.IntegerField(primary_key=True)
    sector = models.CharField(max_length=26, blank=True, null=True)
    security_type = models.CharField(max_length=20, blank=True, null=True)
    country_noformatting = models.CharField(max_length=34, blank=True, null=True)
    price = models.CharField(max_length=8, blank=True, null=True)
    broad_market = models.CharField(db_column='broad market', max_length=17, blank=True,
                                    null=True)  # Field renamed to remove unsuitable characters.
    currency = models.CharField(max_length=3, blank=True, null=True)
    ticker = models.CharField(max_length=20, blank=True, null=True)
    ticker_sector = models.CharField(max_length=24, blank=True, null=True)
    manager = models.CharField(max_length=9, blank=True, null=True)
    market_value = models.DecimalField(max_digits=9, decimal_places=2, blank=True, null=True)
    category = models.CharField(max_length=13, blank=True, null=True)
    country = models.CharField(max_length=34, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'carbon_holding'

class CarbonMsci(models.Model):
    id = models.IntegerField(primary_key=True)
    year = models.IntegerField(blank=True, null=True)
    issuerid = models.CharField(max_length=18, blank=True, null=True)
    isin = models.CharField(max_length=12, blank=True, null=True)
    issuer = models.CharField(max_length=88, blank=True, null=True)
    issuer_market_cap = models.DecimalField(max_digits=15, decimal_places=2, blank=True, null=True)
    carbon_emissions = models.IntegerField(blank=True, null=True)
    issuer_mv_test = models.DecimalField(max_digits=6, decimal_places=2, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'carbon_msci'


class CarbonHoldingStack(models.Model):
    id = models.IntegerField(primary_key=True)
    year = models.IntegerField(blank=True, null=True)
    isin = models.CharField(max_length=20, blank=True, null=True)
    holdings = models.CharField(max_length=14, blank=True, null=True)
    name = models.CharField(max_length=45, blank=True, null=True)
    sector = models.CharField(max_length=26, blank=True, null=True)
    security_type = models.CharField(db_column='security type', max_length=20, blank=True,
                                     null=True)  # Field renamed to remove unsuitable characters.
    country = models.CharField(max_length=34, blank=True, null=True)
    price = models.CharField(max_length=8, blank=True, null=True)
    broad_market = models.CharField(db_column='broad market', max_length=17, blank=True,
                                    null=True)  # Field renamed to remove unsuitable characters.
    currency = models.CharField(max_length=3, blank=True, null=True)
    ticker = models.CharField(max_length=20, blank=True, null=True)
    ticker_sector = models.CharField(db_column='ticker sector', max_length=24, blank=True,
                                     null=True)  # Field renamed to remove unsuitable characters.
    manager = models.CharField(max_length=9, blank=True, null=True)
    endowment_mv = models.DecimalField(db_column='endowment mv', max_digits=9, decimal_places=2, blank=True,
                                       null=True)  # Field renamed to remove unsuitable characters.
    non_endowment_mv = models.DecimalField(db_column='non endowment mv', max_digits=9, decimal_places=2, blank=True,
                                           null=True)  # Field renamed to remove unsuitable characters.
    total_mv = models.DecimalField(db_column='total mv', max_digits=9, decimal_places=2, blank=True,
                                   null=True)  # Field renamed to remove unsuitable characters.

    class Meta:
        managed = False
        db_table = 'carbon_holding_stack'

