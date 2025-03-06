# organ_donation_syatem
# **Organ Donation System - PHP & MySQL**  

## **Introduction**  
The **Organ Donation System** is a web-based platform developed using **PHP** and **MySQL**. It facilitates **organ donation management**, allowing donors, recipients, hospitals, and administrators to interact efficiently. The system tracks **donations, transplants, matches, hospitals, and users** while ensuring data integrity and security.  

## **Features**  
### **1. User Management**  
- Admin, Donors, Recipients, and Hospitals can register and log in.  
- Each user has a role:  
  - **Donor** - Registers and provides organ donation details.  
  - **Recipient** - Requests organ transplants.  
  - **Hospital** - Manages organ transplants and schedules.  
  - **Admin** - Manages the system and users.  

### **2. Organ and Blood Donation**  
- Donors can specify **blood type and organs donated**.  
- Recipients can request an **organ** based on urgency.  
- The system matches **compatible donors and recipients**.  

### **3. Hospital & Transplant Management**  
- Hospitals register and manage **organ transplants**.  
- Admins can **schedule transplants** and assign doctors.  
- Surgery status tracking: **Scheduled, Completed, or Cancelled**.  

### **4. Notifications & Alerts**  
- Real-time alerts for **organ availability**.  
- Notifications for **recipients, donors, and hospitals**.  

### **5. Transactions & Reports**  
- Financial transactions (donations, payments).  
- Doctors can create **medical reports for recipients**.  
- Users can provide **feedback on their experiences**.  

---

## **Database Structure**  
The system consists of **15 tables** that handle users, donations, hospitals, transplants, and more.

| Table Name | Description |
|------------|------------|
| `admin` | Stores administrator credentials. |
| `alerts` | Manages system alerts for organ availability. |
| `donations` | Tracks all organ and blood donations. |
| `donors` | Stores donor information and health records. |
| `hospitals` | Stores hospital details and status. |
| `matches` | Tracks donor-recipient matches. |
| `messages` | Manages user messages and admin replies. |
| `notifications` | Stores notifications sent to users. |
| `organs` | Stores organ donation details. |
| `recipients` | Stores recipient information and medical conditions. |
| `reports` | Doctors' reports on patients. |
| `system_settings` | System configuration details. |
| `transplant_schedule` | Manages surgery scheduling. |
| `transplants` | Tracks transplant operations. |
| `users` | Stores general user details (donors, recipients, hospitals). |

---

## **Installation & Setup**  

### **1. Requirements**  
- PHP 7.4+  
- MySQL 5.7+  
- Apache Server (XAMPP, WAMP, or LAMP)  

### **2. Database Setup**  
1. Open **phpMyAdmin**.  
2. Create a database named **`organ_donation`**.  
3. Import the **`organ_donation.sql`** file.  

### **3. Running the System**  
1. Place the PHP files in your **`htdocs`** or **`www`** directory.  
2. Start Apache and MySQL in XAMPP/WAMP.  
3. Open your browser and go to:  
   ```
   http://localhost/organ_donation/
   ```

---

## **Usage**  
- **Donors**: Register, specify organs/blood type, and check donation status.  
- **Recipients**: Register and request an organ.  
- **Hospitals**: Manage transplants and match donors.  
- **Admin**: Oversee system operations and approve matches.  

---

## **Future Enhancements**  
✅ AI-based donor-recipient matching.  
✅ SMS/email notifications for users.  
✅ Blockchain for secure donor data storage.  

---

## **Contributors**  
Developed by **[Emmanuel Elishadae]**  
For inquiries, contact: **[emmanuelratoryelishadae@gmail.com]**  

---

