SELECT Managers, MV_D_CE, MV_P_CE,MV_D_GE,MV_P_GE,MV_D_TE,MV_P_TE
FROM

(SELECT DISTINCT(Manager) as Managers FROM holding) AS N

LEFT JOIN

(SELECT Manager, SUM(Market_Value) as MV_D_CE, SUM(Market_Value)/160905036 as MV_P_CE FROM holding WHERE Category='Endowment' AND Asset_Class ='Canadian Equity' AND Year = '2016' GROUP BY Manager) as CE
    
ON N.Managers = CE. Manager 

LEFT JOIN

(SELECT Manager,SUM(Market_Value) as MV_D_GE, SUM(Market_Value)/138315025 as MV_P_GE FROM holding WHERE Category='Endowment' AND Asset_Class ='Global Equity' AND Year = '2016' GROUP BY Manager) AS GE 

ON N.Managers = GE. Manager

LEFT JOIN

(SELECT Manager,SUM(Market_Value) as MV_D_TE, SUM(Market_Value)/299220061 as MV_P_TE FROM holding WHERE Category='Endowment' AND (Asset_Class='Canadian Equity' or Asset_Class='Global Equity') AND Year = '2016' GROUP BY Manager) AS TE

ON N.Managers = TE. Manager





SELECT Managers, IFNULL(MV_D_CE,0), IFNULL(MV_P_CE,0), IFNULL(MV_D_GE,0), IFNULL(MV_P_GE,0), (IFNULL(MV_D_CE,0) + IFNULL(MV_D_GE,0)) AS MV_D_TE

FROM

(SELECT DISTINCT(Manager) as Managers FROM holding) AS N

LEFT JOIN

(SELECT Manager, SUM(Market_Value) as MV_D_CE, SUM(Market_Value)/160905036 as MV_P_CE FROM holding WHERE Category='Endowment' AND Asset_Class ='Canadian Equity' AND Year = '2016' GROUP BY Manager) as CE
    
ON N.Managers = CE. Manager 

LEFT JOIN

(SELECT Manager,SUM(Market_Value) as MV_D_GE, SUM(Market_Value)/138315025 as MV_P_GE FROM holding WHERE Category='Endowment' AND Asset_Class ='Global Equity' AND Year = '2016' GROUP BY Manager) AS GE 

ON N.Managers = GE. Manager


UPDATE holding 
SET Asset_Class = ""
WHERE Sector = ""