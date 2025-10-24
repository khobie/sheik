Enterprise Network Design and Simulation (Packet Tracer 8.x)

Purpose
- Design and simulate an enterprise network for a rural/community bank with HQ + 4 branches.
- Technologies: VLSM, VLANs, Inter-VLAN routing, EIGRP, MPLS-ready core (policy notes), NAT, DHCP, VoIP (CME), ACLs, Wireless.

What’s included
- docs/overview.md: Project overview and Chapter One content
- addressing/: VLSM plan and subnets
- topology/: device roles, cabling, and PT build checklist
- configs/: ready-to-paste Cisco IOS configs (HQ and branches)
- policies/: ACLs, QoS, VoIP dial plan
- tests/: verification steps and expected outputs

How to use
1) Open Packet Tracer 8.x.
2) Build topology per topology/build-checklist.md.
3) Paste configs from configs/ into devices.
4) Save as .pkt.

Notes
- This repository provides all artifacts required to build the .pkt locally since PT binary cannot be generated headlessly here.
