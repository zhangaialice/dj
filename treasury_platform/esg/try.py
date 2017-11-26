a=[
        "meanreversionmdhullwhite_selector",
        "volatilitymdhullwhite_selector",
        "convexityadjustment_selector",
        "usdswaptionsatm-002-uncollat_selector",
        "usdswaptionsatm-001-uncollat_selector",
        "usdswaptionsatm-0005-uncollat_selector",
        "usdswaptionsatm-00025-uncollat_selector",
        "usdswaptionsatm00025-uncollat_selector",
        "usdswaptionsatm0005-uncollat_selector",
        "usdswaptionsatm001-uncollat_selector",
        "usdswaptionsatm002-uncollat_selector",
        "averagesifmaswaptionsatm-002-uncollat_selector",
        "averagesifmaswaptionsatm-001-uncollat_selector",
        "averagesifmaswaptionsatm-0005-uncollat_selector",
        "averagesifmaswaptionsatm-00025-uncollat_selector",
        "averagesifmaswaptionsatm00025-uncollat_selector",
        "averagesifmaswaptionsatm0005-uncollat_selector",
        "averagesifmaswaptionsatm001-uncollat_selector",
        "averagesifmaswaptionsatm002-uncollat_selector",
        "sifmaparam_selector",
        "usdswaptionsatm0-uncollat_selector",
        "swaptions-usd-uncollat_selector",
        "averagesifmaswaptionsatm0-uncollat_selector",
        "prime-3mbasisswaps-uncollat_selector",
        "libor3m-12mbasisswaps-uncollat_selector",
        "libor3m-6mbasisswaps-uncollat_selector",
        "libor1m-3mbasisswaps-uncollat_selector",
        "usdcashdepos_selector",
        "liborusd3mfutures-uncollat_selector",
        "liborusd3mirs-uncollat_selector",
        "swaptions-sifma-uncollat_selector",
        "usd-cap-sifma-3m-uncollat_selector",
        "sifma-cap-md-uncollat_selector",
        "usd-cap-libor-3m-uncollat_selector",
        "usd-cap-libor-3m-normal-uncollat_selector",
        "meanreversionforvolhullwhite_selector",
        "usd-cap-libor-1m-uncollat_selector",
        "usd-cap-libor-1m-normal-uncollat_selector",
        "usd-cap-sifma-3m-normal-uncollat_selector",
        "liborusd1mframd_selector",
        "liborusd12mframd_selector",
        "liborusd6mframd_selector"
    ]

b=[
        "meanreversionmdhullwhite_selector",
        "volatilitymdhullwhite_selector",
        "convexityadjustment_selector",
        "usdswaptionsatm-002-uncollat_selector",
        "usdswaptionsatm-001-uncollat_selector",
        "usdswaptionsatm-0005-uncollat_selector",
        "usdswaptionsatm-00025-uncollat_selector",
        "usdswaptionsatm00025-uncollat_selector",
        "usdswaptionsatm0005-uncollat_selector",
        "usdswaptionsatm001-uncollat_selector",
        "usdswaptionsatm002-uncollat_selector",
        "averagesifmaswaptionsatm-002-uncollat_selector",
        "averagesifmaswaptionsatm-001-uncollat_selector",
        "averagesifmaswaptionsatm-0005-uncollat_selector",
        "averagesifmaswaptionsatm-00025-uncollat_selector",
        "averagesifmaswaptionsatm00025-uncollat_selector",
        "averagesifmaswaptionsatm0005-uncollat_selector",
        "averagesifmaswaptionsatm001-uncollat_selector",
        "averagesifmaswaptionsatm002-uncollat_selector",
        "sifmaparam_selector",
        "usdswaptionsatm0-uncollat_selector",
        "swaptions-usd-uncollat_selector",
        "averagesifmaswaptionsatm0-uncollat_selector",
        "prime-3mbasisswaps-uncollat_selector",
        "libor3m-12mbasisswaps-uncollat_selector",
        "libor3m-6mbasisswaps-uncollat_selector",
        "libor1m-3mbasisswaps-uncollat_selector",
        "usdcashdepos_selector",
        "liborusd3mfutures-uncollat_selector",
        "liborusd3mirs-uncollat_selector",
        "swaptions-sifma-uncollat_selector",
        "usd-cap-sifma-3m-uncollat_selector",
        "sifma-cap-md-uncollat_selector",
        "usd-cap-libor-3m-uncollat_selector",
        "usd-cap-libor-3m-normal-uncollat_selector",
        "meanreversionforvolhullwhite_selector",
        "usd-cap-libor-1m-uncollat_selector",
        "usd-cap-libor-1m-normal-uncollat_selector",
        "usd-cap-sifma-3m-normal-uncollat_selector",
        "liborusd1mframd_selector",
        "liborusd12mframd_selector",
        "liborusd6mframd_selector"
    ]
# print cmp(a, b)
# import difflib,sys
# tl=100000
# with open('C:/temp/debug_md_6.txt', 'r') as f1, open('C:/temp/debug_md_7.txt', 'r') as f2:
#   diff = difflib.ndiff(f1.readlines(), f2.readlines())
#   for i, line in enumerate(diff):
#     if line.startswith(' '):
#       continue
#     sys.stdout.write('My count: {}, text: {}'.format(i, line))

import sys
import xml.etree.ElementTree as ET

from termcolor import colored

tree1 = ET.parse(sys.argv[1])
root1 = tree1.getroot()

tree2 = ET.parse(sys.argv[2])
root2 = tree2.getroot()

class Element:
    def __init__(self,e):
        self.name = e.tag
        self.subs = {}
        self.atts = {}
        for child in e:
            self.subs[child.tag] = Element(child)

        for att in e.attrib.keys():
            self.atts[att] = e.attrib[att]

        print "name: %s, len(subs) = %d, len(atts) = %d" % ( self.name, len(self.subs), len(self.atts) )

    def compare(self,el):
        if self.name!=el.name:
            raise RuntimeError("Two names are not the same")
        print "----------------------------------------------------------------"
        print self.name
        print "----------------------------------------------------------------"
        for att in self.atts.keys():
            v1 = self.atts[att]
            if att not in el.atts.keys():
                v2 = '[NA]'
                color = 'yellow'
            else:
                v2 = el.atts[att]
                if v2==v1:
                    color = 'green'
                else:
                    color = 'red'
            print colored("first:\t%s = %s" % ( att, v1 ), color)
            print colored("second:\t%s = %s" % ( att, v2 ), color)

        for subName in self.subs.keys():
            if subName not in el.subs.keys():
                print colored("first:\thas got %s" % ( subName), 'purple')
                print colored("second:\thasn't got %s" % ( subName), 'purple')
            else:
                self.subs[subName].compare( el.subs[subName] )



e1 = Element(root1)
e2 = Element(root2)

e1.compare(e2)