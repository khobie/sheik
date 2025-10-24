# Packet Tracer Build Checklist

Topology summary
- HQ: ISR router (edge), L3 core switch, 2x L2 access switches, CUCM Express (CME) on router, 1x Windows Server (AD/DHCP/DNS), Wireless Router/AP, IP phones, PCs, Finance/OPS/Voice/Server VLANs.
- Branch1-4: ISR router, 1x L2 switch, Wireless Router/AP, IP phones, PCs, VLANs (Users/Voice/Management).
- WAN: Simulate radio links as serial or PT point-to-point links; MPLS placeholder via EIGRP core with policy notes.

Device models (Packet Tracer compatible)
- Routers: 2911/1941 ISR (with voice capability for HQ)
- Switches: 2960 (access), 3560 (L3 core)
- Wireless: PT-AP or Home Wireless Router for simple SSIDs
- Servers: PT-Server (Windows Server role simulated via services)
- Phones: PT IP Phones

Cabling
- Router-to-core: copper straight-through
- Core-to-access: copper straight-through
- Router serial/PPP for WAN: Serial DCE/DTE between HQ <-> Branch routers

Steps
1) Place devices and name them (HQ-EDGE, HQ-CORE, HQ-ACC1, HQ-ACC2, BR1-EDGE ... BR4-EDGE).
2) Create VLANs per addressing/vlans.md and assign access ports.
3) Configure SVIs on HQ-CORE for inter-VLAN routing; branches use router-on-a-stick.
4) Configure EIGRP AS 10 with passive interfaces for LANs; advertise summary routes.
5) Configure DHCP pools (HQ serves HQ; branches serve locally on branch router).
6) Configure NAT at HQ-EDGE for Internet (over G0/0) and ACL for interesting traffic.
7) Configure CME on HQ-EDGE, create ephones and ephone-dns; branch phones register via IP.
8) Configure ACLs: restrict management, allow VoIP/RTP/SCCP/SIP; user-to-server policies.
9) Wireless SSIDs: `Bank-Staff` (WPA2), `Guest` (isolated, NAT-only).
10) Verify with tests/runbook.md.
