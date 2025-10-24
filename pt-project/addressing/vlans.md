# VLANs and Subnets

Global conventions
- Voice VLAN ID = 20 at all sites
- User VLAN ID(s): HQ 10 (Finance), 30 (Operations), 40 (Guest); Branches 10 (Users)
- Management VLAN ID = 99
- Native VLAN ID = 999

Addressing block
- Enterprise RFC1918 block: 10.0.0.0/16
- WAN point-to-point: 10.255.0.0/24 (slice per link /30)

HQ subnets
- VLAN10 Finance: 10.0.10.0/24 (GW .1)
- VLAN20 Voice:   10.0.20.0/24 (GW .1)
- VLAN30 Ops:     10.0.30.0/24 (GW .1)
- VLAN40 Guest:   10.0.40.0/24 (GW .1)
- VLAN99 Mgmt:    10.0.99.0/24 (GW .1)
- Server subnet:  10.0.50.0/24 (GW .1)

Branch subnets (per-branch)
- Users: 10.1.X.0/24 (BR1 X=1 -> 10.1.1.0/24, BR2 X=2, etc.)
- Voice: 10.2.X.0/24 (BR1 10.2.1.0/24, ...)
- Mgmt:  10.3.X.0/24

WAN links (/30)
- HQ-BR1: 10.255.0.0/30 (HQ .1, BR1 .2)
- HQ-BR2: 10.255.0.4/30 (HQ .5, BR2 .6)
- HQ-BR3: 10.255.0.8/30 (HQ .9, BR3 .10)
- HQ-BR4: 10.255.0.12/30 (HQ .13, BR4 .14)

Summaries (EIGRP)
- HQ summary for branches: 10.0.0.0/13 reserved for HQ, 10.0.0.0/16 overall; branches summarized per site group 10.0.0.0/8 not ideal; use precise:
  - BR1: 10.1.1.0/24, 10.2.1.0/24, 10.3.1.0/24 -> summary 10.0.0.0/8 is too broad; keep discrete or use 10.0.0.0/16 core + per-branch specific networks.
