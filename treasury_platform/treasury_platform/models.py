# This is an auto-generated Django model module.
# You'll have to do the following manually to clean this up:
#   * Rearrange models' order
#   * Make sure each model has one field with primary_key=True
#   * Make sure each ForeignKey has `on_delete` set to the desired behavior.
#   * Remove `managed = False` lines if you wish to allow Django to create, modify, and delete the table
# Feel free to rename the models, but don't rename db_table values or field names.
from __future__ import unicode_literals

from django.db import models


class holding(models.Model):
    year = models.IntegerField(db_column='Year', blank=True, null=True)  # Field name made lowercase.
    isin = models.CharField(db_column='ISIN', max_length=33, blank=True, null=True)  # Field name made lowercase.
    holdings = models.CharField(db_column='Holdings', max_length=24, blank=True, null=True)  # Field name made lowercase.
    name = models.CharField(db_column='Name', max_length=51, blank=True, null=True)  # Field name made lowercase.
    sector = models.CharField(db_column='Sector', max_length=26, blank=True, null=True)  # Field name made lowercase.
    sub_industry = models.CharField(db_column='Sub_Industry', max_length=34, blank=True, null=True)  # Field name made lowercase.
    security_type = models.CharField(db_column='Security_Type', max_length=21, blank=True, null=True)  # Field name made lowercase.
    industry_sector = models.CharField(db_column='Industry_Sector', max_length=244, blank=True, null=True)  # Field name made lowercase.
    industry_group = models.CharField(db_column='Industry_Group', max_length=24, blank=True, null=True)  # Field name made lowercase.
    country = models.CharField(db_column='Country', max_length=34, blank=True, null=True)  # Field name made lowercase.
    price = models.CharField(db_column='Price', max_length=10, blank=True, null=True)  # Field name made lowercase.
    coupon = models.CharField(db_column='Coupon', max_length=7, blank=True, null=True)  # Field name made lowercase.
    maturity = models.CharField(db_column='Maturity', max_length=10, blank=True, null=True)  # Field name made lowercase.
    broad_market = models.CharField(db_column='Broad Market', max_length=21, blank=True, null=True)  # Field name made lowercase. Field renamed to remove unsuitable characters.
    currency = models.CharField(db_column='Currency', max_length=3, blank=True, null=True)  # Field name made lowercase.
    market_weight = models.DecimalField(db_column='Market Weight', max_digits=11, decimal_places=9, blank=True, null=True)  # Field name made lowercase. Field renamed to remove unsuitable characters.
    market_value = models.DecimalField(db_column='Market_Value', max_digits=15, decimal_places=0, blank=True, null=True)  # Field name made lowercase.
    duration = models.CharField(db_column='Duration', max_length=15, blank=True, null=True)  # Field name made lowercase.
    ytm = models.CharField(db_column='YTM', max_length=10, blank=True, null=True)  # Field name made lowercase.
    minimum_rating = models.CharField(db_column='Minimum_Rating', max_length=3, blank=True, null=True)  # Field name made lowercase.
    dbrs_rating = models.CharField(db_column='DBRS_Rating', max_length=3, blank=True, null=True)  # Field name made lowercase.
    ticker = models.CharField(db_column='Ticker', max_length=33, blank=True, null=True)  # Field name made lowercase.
    ticker_sector = models.CharField(db_column='Ticker Sector', max_length=16, blank=True, null=True)  # Field name made lowercase. Field renamed to remove unsuitable characters.
    term = models.CharField(db_column='Term', max_length=7, blank=True, null=True)  # Field name made lowercase.
    rating_scale = models.CharField(db_column='Rating Scale', max_length=3, blank=True, null=True)  # Field name made lowercase. Field renamed to remove unsuitable characters.
    manager = models.CharField(db_column='Manager', max_length=12, blank=True, null=True)  # Field name made lowercase.
    market_value_final = models.DecimalField(db_column='Market_Value_Final', max_digits=15, decimal_places=0, blank=True, null=True)  # Field name made lowercase.
    category = models.CharField(db_column='Category', max_length=13, blank=True, null=True)  # Field name made lowercase.
    # asset_class = models.TextField(db_column='Asset_Class', blank=True, null=True)  # Field name made lowercase.

    class Meta:
        managed = False
        db_table = 'holding_v2'


class IssuerMapping(models.Model):
    old_name = models.CharField(max_length=24, blank=True, null=True)
    new_name = models.CharField(max_length=23, blank=True, null=True)

    class Meta:
        managed = False
        db_table = 'issuer_mapping'



