# VLSM Addressing Plan

Supernet: 10.0.0.0/16

HQ requirements
- Finance VLAN: ~150 hosts -> /24 (10.0.10.0/24)
- Voice VLAN: up to 100 phones -> /24 (10.0.20.0/24)
- Operations VLAN: ~120 hosts -> /24 (10.0.30.0/24)
- Guest VLAN: ~60 hosts -> /26 or /24 for simplicity -> /24 (10.0.40.0/24)
- Server subnet: ~30 servers -> /27 or /24 for growth -> /24 (10.0.50.0/24)
- Management: ~50 mgmt IPs -> /26 or /24 -> /24 (10.0.99.0/24)

Branches (each)
- Users: up to 100 -> /25 or /24 -> /24  (10.1.X.0/24)
- Voice: up to 50 -> /26 or /24 -> /24  (10.2.X.0/24)
- Mgmt: up to 30 -> /27 or /24 -> /24  (10.3.X.0/24)

WAN point-to-point
- /30 per link out of 10.255.0.0/24

Gateway IP conventions
- VLAN SVI/router subinterface: .1
- DHCP excluded: .1-.20 reserved for infra unless stated

DHCP pools
- Define per subnet; option 150 for VoIP to CME (HQ-EDGE IP) and for branches point to HQ CME.
