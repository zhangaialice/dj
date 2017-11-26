


trade=[["00035_cap_floor","00165_cap_floor","00260_cap_floor","00569_cap_floor","00128_cap_floor","00222_cap_floor","01515_cap_floor"],["02918_swap","02926_swap","02985_swap","03030_swap","03058_swap","04523_swap","04525_swap","04527_swap","05163_cap_floor","05268_cap_floor","04481_swaption","04531_swaption"]]
model=["risk_model_no_smoothing_model_new-2017021513203144000",
"risk_model_with_smoothing_model_new-20170215132026586000",
"ois_discounting_no_smoothing_model_new-20171006192539832000",
"ois_discounting_with_smoothing_model_new-2017100619253621000",
"fixed_libor_discounting_no_smoothing_model_new-20171006192532191000",
"fixed_libor_discounting_with_smoothing_model_new-20171006192528582000"]

for x in trade:
  for y in model:
    return ("{"+ x +","+y+"}")