from django import forms


class Year(forms.Form):
    your_year = forms.CharField(label='Choose year', max_length=100)


class MilitaryForm(forms.Form):
    YEAR = (
        ('2015', '2015'),
        ('2016', '2016'),
    )
    OUTPUT = (
        ('manager', 'Manager'),
        ('category', 'Fund'),
    )
    your_year1 = forms.ChoiceField(choices=YEAR, required=True)
    your_year2 = forms.ChoiceField(choices=YEAR, required=True)
    your_output = forms.ChoiceField(choices=OUTPUT, required=True)


class ManagerYearCategory(forms.Form):
    your_year = forms.CharField(label='Choose year', max_length=100)
    your_manager = forms.CharField(label='Choose manager', max_length=100)
    your_category = forms.CharField(label='Choose category', max_length=100)
    your_output = forms.CharField(label='Choose output', max_length=100)


class YearCategoryAssetclass(forms.Form):
    your_year = forms.CharField(label='Choose year', max_length=100)
    your_category = forms.CharField(label='Choose category', max_length=100)
    your_assetclass = forms.CharField(label='Choose asset class', max_length=100)
    your_output = forms.CharField(label='Choose output', max_length=100)


class MultiYear(forms.Form):
    YEAR = (
        ('2015', '2015'),
        ('2016', '2016'),
    )
    OUTPUT = (
        ('security_type', 'Asset Class'),
        ('manager', 'Manager'),
        ('category', 'Fund'),
    )
    your_year1 = forms.ChoiceField(choices=YEAR, required=True)
    your_year2 = forms.ChoiceField(choices=YEAR, required=True)
    your_output = forms.ChoiceField(choices=OUTPUT, required=True)


class CarbonDrop(forms.Form):

    your_year1 = forms.CharField(label='Choose year2', max_length=100)
    your_year2 = forms.CharField(label='Choose year2', max_length=100)
    your_group = forms.CharField(label='Choose group', max_length=100)
    your_output = forms.CharField(label='Choose output', max_length=100)


class CarbonDropdown(forms.Form):
    YEAR = (
        ('2017', '2017'),
        ('2016', '2016'),
    )
    GROUP = (
        ('country', 'Country'),
        ('manager', 'Manager'),
        ('security_type', 'Asset Class'),
        ('category', 'Fund'),
        ('sector', 'Sector'),
    )
    OUTPUT = (
        ('emission', 'Emission'),
        ('emission per million', 'Emission Per Million'),
        ('selection contribution', 'Selection Contribution'),
    )
    your_year1 = forms.ChoiceField(choices=YEAR, required=True)
    your_year2 = forms.ChoiceField(choices=YEAR, required=True)
    your_group = forms.ChoiceField(choices=GROUP, required=True)
    your_output = forms.ChoiceField(choices=OUTPUT, required=True)


    # layout=Layout(Row('your_year1','your_year2','your_group','your_output'))


class Carbonstack(forms.Form):
    YEAR = (
        ('2016', '2016'),
        ('2017', '2017'),
    )
    # MANAGER = (
    #     ('BEAM', 'BEAM'),
    #     ('SIAS', 'SIAS'),
    # )
    your_year = forms.ChoiceField(choices=YEAR, required=True)
    # your_manager = forms.ChoiceField(choices=MANAGER, required=True)
