# Packet Tracer Steps (Quick)

1) Drop devices per topology/device-list.md and name them.
2) Connect HQ-EDGE G0/1 to HQ-CORE G0/1; WAN serials S0/x/x between HQ-EDGE and each BRx-EDGE.
3) Trunk HQ-CORE G0/2,G0/3 to HQ-ACC1/2 G0/1; trunks BRx-SW G0/1 to BRx-EDGE G0/0.
4) Create VLANs on switches and SVIs on HQ-CORE.
5) Paste configs from configs/hq and configs/branches into respective devices.
6) Add PCs and Phones to access ports; assign to correct VLANs.
7) Configure Wireless Home Router with SSIDs: Bank-Staff (WPA2), Guest (WPA2, isolated).
8) Save as .pkt.
