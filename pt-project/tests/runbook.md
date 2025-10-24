# Verification Runbook

After pasting configs and bringing links up:

Routing
- show ip route | include D (EIGRP learned) on all routers
- Ping HQ server 10.0.50.10 from each branch PC

DHCP
- PCs obtain IP via DHCP; check ipconfig/all in PT
- Phones receive IP from Voice VLAN pool; verify option 150 to CME

NAT
- From Guest VLAN, ping simulated Internet cloud interface (e.g., 203.0.113.1); verify show ip nat translations on HQ-EDGE

VoIP
- Register IP phones; show ephone registered on CME router
- Place calls between HQ (2001) and BR1 (1001); audio path ok

ACLs
- From Guest VLAN, attempt to reach 10.0.50.10 (should fail)
- From Branch Users, reach HQ server (should succeed)

QoS (qualitative)
- Generate traffic; verify policy-map statistics on WAN interface
