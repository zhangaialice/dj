import requests

base_url = 'http://localhost:8505/f3platform/api/v1/trade/'
result = requests.get(base_url + '?select=notruncate')
trade_slugs = result.json()
f = open('C:\\temp\\helloworld.txt','a')
# print trade_slugs
for trade_slug in trade_slugs:
  result = requests.get(base_url + trade_slug)
  trade = result.json()
  if trade['trade_template'] == 'amortizingsingleleg3':
    f.write(trade_slug + ',')
    print trade_slug
f.close()