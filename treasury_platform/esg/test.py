from esg.functions import FossilFuel, defaultencode, Industry, Manager, AssetClass,Carbon
import pandas as pd
year=['2016','2017']
group=['sector','category','manager','country','security_type']
output=['emission','emission per million','selection contribution']
checklist=[]
for yr in year:
  for grp in group:
    for opt in output:
            test=Carbon()
            test._year=int(yr)
            test._group=grp
            df_test=test.get_data()
            t_emission=sum(df_test['emission2'])
            t_emissionper=sum(df_test['emission per million'])
            t_contri=sum(df_test['selection contribution'])
            checklist.append({'year': yr, 'group': grp,'emission': t_emission,'emission per million':t_emissionper,'contribution selection':t_contri})

df=pd.DataFrame(checklist)
print df.head(10)


