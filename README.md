# Industrial Device Monitoring Dashboard

## Getting Started

A secure, real-time industrial monitoring dashboard designed to display and track key measurements—such as temperature—from connected industrial devices. The system fetches live data from a remote VPS via APIs, supports secure login, and allows exporting logs to Excel for further analysis.

> Note: Due to security policies, user registration is only managed server-side.

---

## Features

- 🌡️ Live temperature monitoring from industrial hardware
- 🔒 Secure login system (registration disabled for safety)
- 📈 Real-time data visualization powered by API polling
- 🧾 Log export to Excel for reporting or auditing
- 📤 Automatic and manual data refresh capabilities
- 💡 Clean and responsive UI built for industrial use
- 🔧 Admin-only access to advanced controls
- 🔌 Backend-integrated with VPS for robust performance

---

## How It Works

1. User logs into the dashboard with secure credentials
2. System fetches live sensor data via RESTful APIs from VPS
3. Temperature readings are displayed and updated in real time
4. Logs are stored and can be exported as Excel files
5. All data flow is handled server-side to ensure security and reliability

---

## Logs

System maintains logs of:
- 📅 User login sessions and data access
- 🌡️ Temperature and other key measurements readings over time
- 📤 Log export activities
- 🔁 API call statuses and data retrieval events

---

## Requirements

- Frontend: HTML, CSS (Bootstrap), JavaScript (jQuery or Vanilla)
- Backend: PHP 7.x+ or Node.js (depending on your stack)
- Server: VPS with API endpoints configured
- Optional: Axios or Fetch API for dynamic data loading
- Excel Export: SheetJS or server-side CSV generation

---

## Testing

- Use real or simulated industrial devices to provide data
- Log in with test credentials
- Verify real-time data display and refresh intervals
- Export logs to ensure Excel file integrity
- Simulate API delays or failures to check dashboard resilience

---

## Demo

Address

📎 [View on my personal site](http://farnazboroumand.ir/dashboard)

📎 [View on Hiva Company site](https://hoshiserver.ir/dashboard)

Test account on my personal site:

- Username: haraz  
- Password: 1234

📎 [Execute Video](https://drive.google.com/file/d/1wklzyDCOnUFf858gKwRfW63J3VNHkAPv/view?usp=sharing)

---
