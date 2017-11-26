from django import forms

class NameForm(forms.Form):
    your_name = forms.CharField(label='Your name', max_length=100)
    your_email= forms.CharField(label='Your email',max_length=100)
class Year(forms.Form):
    your_year = forms.CharField(label='Choose year', max_length=100)
