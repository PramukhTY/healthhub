📛 Project Title:
Smart HealthHub: An AI-Enhanced Healthcare & e-Medical Management System

🛠️ Technologies Used:
- HTML, CSS, JavaScript
- PHP (Backend)
- MySQL (Database)
- PHPMailer (Email)
- Responsive UI (Flex/Grid, Media Queries)

📦 Folder Structure:
- index.php
- /auth (signup, login, logout)
- /core (appointments, dashboard, chatbot, etc.)
- /admin (admin dashboard, management panels)
- /api (chatbot API)
- /classes (chatbot logic)
- /assets (css, js, images)
- /includes (navbar, footer, auth check)
- database/smarthealthhub.sql

✅ Key Features:
- User Auth System (Free vs Premium)
- Doctor Booking + PDF Prescription
- e-Medical Store with Cart + Checkout
- AI Chatbot for health queries
- Appointment & Medicine Reminders
- Admin Panel
- Mobile Responsive UI

📦 Deployment:
1. Import `smarthealthhub.sql` to your MySQL server.
2. Update `/config/db.php` with your DB credentials.
3. Host project on XAMPP/LAMP stack or upload to hosting provider.
4. Access via `localhost/SmartHealthHub/`.

👨‍⚕️ Admin Login:
- Email: admin@healthhub.com
- Password: admin123

📧 Email Config:
- Configure PHPMailer SMTP credentials in `includes/mailer.php`

🧠 Chatbot:
- Basic rule-based logic in `ChatbotCore.php`

📍 Simulation:
- `includes/cron_simulator.php` can simulate email reminder via manual or scheduled call.

---

Built with ❤️ by Team SmartHealthHub
