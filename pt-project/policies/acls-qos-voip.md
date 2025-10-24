# ACLs, QoS, and VoIP Plan

ACLs
- Permit HQ Server (10.0.50.0/24) from branches; deny inter-branch user-to-user by default.
- Permit VoIP signaling (SCCP 2000/TCP, SIP 5060/5061, RTP 16384-32767/UDP) from branches to HQ CME.
- Restrict management (SSH/SNMP) to VLAN99 and specific admin hosts.
- Guest VLAN only to Internet (NAT) and DNS; deny internal.

QoS (simplified PT-compatible)
- Class-map VOICE match RTP UDP 16384-32767
- Policy-map WAN-OUT: priority percent 30 for VOICE, fair-queue for rest
- Apply on WAN serial subinterfaces outbound.

VoIP (CME at HQ)
- CME IP: 10.0.20.1 (or HQ-EDGE LAN IP)
- Dial plan: 2xxx HQ, 1xxx BR1, 3xxx BR2, 4xxx BR3, 5xxx BR4
- ephone-dn per extension; ephone per phone MAC
- Option 150 in DHCP to CME IP
