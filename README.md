# SayurKita 🌱
### *Globalization Indonesian Local Vegetables*

<!-- Replace 'path/to/your/logo.png' with your actual logo path -->
<p align="center">
  <img src="public\assets\logo\logo.png" alt="SayurKita Logo" width="200" height="200">
</p>

<p align="center">
  <a href="https://laravel.com/"><img src="https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel"></a>
  <a href="https://tailwindcss.com/"><img src="https://img.shields.io/badge/TailwindCSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="TailwindCSS"></a>
  <a href="https://www.mysql.com/"><img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL"></a>
  <a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript"><img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript"></a>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Status-In%20Development-yellow?style=for-the-badge" alt="Status">
  <img src="https://img.shields.io/badge/Purpose-Educational-blue?style=for-the-badge" alt="Purpose">
  <img src="https://img.shields.io/badge/Team-4%20Members-green?style=for-the-badge" alt="Team">
</p>

<p align="center">
  <a href="https://youtu.be/UO63PTp0t-c"><strong>🚀 Project Demo</strong></a> •
  <a href="https://drive.google.com/drive/folders/13LkGFJMwCiyfPhRtmk4VvyYOnub3id44?usp=sharing"><strong>📁 Project Assets</strong></a> •
  <a href="#-features-that-make-a-difference"><strong>✨ Features</strong></a> •
  <a href="#-installation-guide"><strong>📦 Installation</strong></a> •
  <a href="#-meet-our-amazing-team"><strong>👥 Team</strong></a>
</p>

---

## 🌍 **The Problem We're Solving**

Indonesia is blessed with incredible agricultural diversity, producing a vast array of local vegetables that remain hidden from global markets. **Traditional farming communities and UMKM (Usaha Mikro, Kecil, dan Menengah) businesses face significant barriers in reaching international customers**, limiting their growth potential and keeping their exceptional products local.

### 💡 **Our Solution**

**SayurKita** bridges this gap by creating a digital platform where Indonesian farmers and UMKM businesses can showcase their local vegetables to a global audience. Imagine someone in Europe discovering the unique taste of Indonesian kangkung, or a restaurant in America sourcing authentic petai directly from Indonesian farmers!

<p align="center">
  <img src="https://img.shields.io/badge/🌱-Local%20to%20Global-green?style=for-the-badge" alt="Local to Global">
  <img src="https://img.shields.io/badge/🚀-UMKM%20Empowerment-blue?style=for-the-badge" alt="UMKM Empowerment">
  <img src="https://img.shields.io/badge/🌏-Global%20Reach-orange?style=for-the-badge" alt="Global Reach">
</p>

---

## ✨ Features That Make a Difference

<table>
<tr>
<td width="50%">

### 🔐 **User Management**
- **Smart Authentication** - Secure login/registration
- **Role-Based Access** - Different permissions for users and admins
- **Profile Management** - Customizable user accounts

### 📊 **Admin Dashboard**
- **Complete CRUD Operations** - Full content management

</td>
<td width="50%">

### 🌱 **Product Showcase**
- **Vegetable Catalog** - Comprehensive product listings
- **Rich Media Gallery** - High-quality images
- **Detailed Information** - Nutritional facts, growing tips, others

### 🔍 **Discovery Features**
- **Advanced Search** - Find specific vegetables easily
- **Smart Filters** - Category, region, and others
- **Knowledge Blog** - Educational content about vegetables

</td>
</tr>
</table>

### 🎯 **Core Functionality**
- 🏠 **Engaging Landing Page** - Professional first impression
- 💬 **Interactive Comments** - Community engagement
- ⚙️ **Account Settings** - User preference management
- 🚪 **Secure Logout** - Complete session management

---

## 🛠️ **Technology Stack**

<p align="center">
  <a href="https://skillicons.dev"><img src="https://skillicons.dev/icons?i=laravel,php,mysql,js,html,css,tailwind,git,github&theme=light" alt="Tech Stack"/></a>
</p>

### **Backend Architecture**
- 🚀 **[Laravel 11](https://laravel.com/)** - Modern PHP framework with elegant syntax
- 🛡️ **[Laravel Sanctum](https://laravel.com/docs/11.x/sanctum)** - API authentication system
- 🗄️ **[MySQL Database](https://www.mysql.com/)** - Reliable data storage
- 📦 **[Composer](https://getcomposer.org/)** - Dependency management

### **Frontend Excellence**
- 🎨 **[TailwindCSS](https://tailwindcss.com/)** - Utility-first CSS framework
- ⚡ **[JavaScript](https://developer.mozilla.org/en-US/docs/Web/JavaScript)** - Dynamic user interactions
- 🎭 **Modern UI/UX** - Clean, white theme with green accents

### **Development Tools**
- 📦 **[NPM](https://www.npmjs.com/)** - Package management
- 🔧 **[Git](https://git-scm.com/)** - Version control
- 🏗️ **[Vite](https://vitejs.dev/)** - Fast build tool

---

## 📦 Installation Guide

### **Prerequisites**
```bash
✅ PHP >= 8.1
✅ Composer
✅ Node.js & NPM
✅ MySQL
✅ Git
```

### **🚀 Quick Setup**

#### **Step 1: Clone the Repository**
```bash
git clone https://github.com/Juni-Viaa/cmsvegetable
cd SayurKita
```

#### **Step 2: Install Dependencies**
```bash
# Backend dependencies
composer install

# Frontend dependencies
npm install
```

#### **Step 3: Environment Configuration**
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

#### **Step 4: Database Setup**
```bash
# Update your .env file with these database settings:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sayurkita
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

#### **Step 5: Database Migration & Seeding**
```bash
# Create database tables
php artisan migrate

# Seed with sample data including admin account
php artisan db:seed
```

#### **Step 6: Build & Launch**
```bash
# Compile frontend assets
npm run dev

# Start the development server
php artisan serve
```

🎉 **Success!** Visit `http://localhost:8000` to see SayurKita in action!

### **🔑 Admin Access**
- **Username**: `admin`
- **Password**: `admin123`

> ⚠️ **Important**: Change these credentials after first login!

---

## 👥 Meet Our Amazing Team

<p align="center"><strong>Politeknik Negeri Batam - Information Technology Department</strong></p>
<p align="center"><em>PBL (Project Based Learning) Team 1</em></p>

<table align="center">
<tr>
<td align="center" width="25%">
<img src="https://github.com/ms-hamid.png" width="100px" alt="Muhammad Syarif Hamid"/><br>
<strong>Muhammad Syarif Hamid</strong><br>
<em>Team Leader & Fullstack Developer</em><br>
<a href="https://github.com/ms-hamid">🐙 GitHub</a>
</td>
<td align="center" width="25%">
<img src="https://github.com/Juni-Viaa.png" width="100px" alt="Junior Dirgantara Betan"/><br>
<strong>Junior Dirgantara Betan</strong><br>
<em>Fullstack Developer</em><br>
<a href="https://github.com/Juni-Viaa">🐙 GitHub</a>
</td>
<td align="center" width="25%">
<img src="https://github.com/Suanda27.png" width="100px" alt="Muhammad Faiz Difa Suanda"/><br>
<strong>Muhammad Faiz Difa Suanda</strong><br>
<em>Frontend Developer</em><br>
<a href="https://github.com/Suanda27">🐙 GitHub</a>
</td>
<td align="center" width="25%">
<img src="https://github.com/MITAP31.png" width="100px" alt="Muhammad Ilham Tri Adi Putra"/><br>
<strong>Muhammad Ilham Tri Adi Putra</strong><br>
<em>Frontend Developer</em><br>
<a href="https://github.com/MITAP31">🐙 GitHub</a>
</td>
</tr>
</table>

---

## 🎯 **Skills We Developed**

This project has been an incredible learning journey for our team! Starting as students with limited experience, we've grown tremendously:

### **Technical Skills Gained**
- 🎨 **Frontend Development** - Modern UI/UX design with TailwindCSS
- ⚙️ **Backend Development** - Laravel framework mastery
- 🗄️ **Database Management** - MySQL design and optimization
- 🔧 **Version Control** - Git workflow and collaboration
- 🚀 **Full-Stack Integration** - Connecting frontend and backend seamlessly

### **Professional Skills Enhanced**
- 👥 **Team Collaboration** - Working effectively as a development team
- 📋 **Project Management** - Planning, executing, and delivering projects
- 🎯 **Problem Solving** - Tackling real-world challenges
- 📚 **Continuous Learning** - Adapting to new technologies and frameworks

### **🏆 Challenges We Overcame**
- **Database Relationships** - Understanding complex data structures
- **Authentication Systems** - Implementing secure user management
- **Responsive Design** - Creating mobile-friendly interfaces
- **Team Coordination** - Managing different development roles
- **Code Integration** - Merging individual contributions smoothly

---

## 🌐 **Live Demo & Assets**

### **🚀 Live Demo**
Experience SayurKita in action! Click the link below to access our live demonstration:

<p align="center">
  <a href="">
    <img src="https://img.shields.io/badge/🌐-Live%20Demo-brightgreen?style=for-the-badge&logo=vercel&logoColor=white" alt="Live Demo">
  </a>
</p>

<!-- > **Demo Credentials:**
> - **User Email**: `demo@sayurkita.com`
> - **User Password**: `demo123`
> - **Admin Email**: `admin@sayurkita.com`
> - **Admin Password**: `admin123` -->

### **📁 Project Assets & Resources**

All project assets, documentation, and additional resources are stored in our Google Drive:

<p align="center">
  <a href="">
    <img src="https://img.shields.io/badge/📁-Project%20Assets-blue?style=for-the-badge&logo=googledrive&logoColor=white" alt="Project Assets">
  </a>
</p>

**What's included in the Drive:**
- 📸 **High-Quality Screenshots** - All application screens
- 🎨 **Design Assets** - Logo, banners, and UI elements
- 📋 **Project Documentation** - Reports, presentations, and guides
- 🎬 **Demo Videos** - Application walkthrough and features
- 📊 **Database Schema** - ER diagrams and table structures
- 🔧 **Setup Files** - Configuration templates and sample data

### **📱 Application Screenshots**

<!-- <details>
<summary>🖼️ <strong>Click to view screenshots</strong></summary>

### 🏠 Landing Page
<img src="path/to/landing-page-screenshot.png" alt="Landing Page" width="100%">
*Modern, clean design showcasing Indonesian vegetables*

### 📊 Admin Dashboard
<img src="path/to/admin-dashboard-screenshot.png" alt="Admin Dashboard" width="100%">
*Comprehensive control panel for content management*

### 🌱 Product Catalog
<img src="path/to/product-catalog-screenshot.png" alt="Product Catalog" width="100%">
*Beautiful vegetable showcase with detailed information*

### 📝 Blog Section
<img src="path/to/blog-screenshot.png" alt="Blog Section" width="100%">
*Educational content about Indonesian vegetables*

### 🔍 Search & Filter
<img src="path/to/search-filter-screenshot.png" alt="Search & Filter" width="100%">
*Advanced search functionality for easy discovery*

### 💬 Comment System
<img src="path/to/comment-system-screenshot.png" alt="Comment System" width="100%">
*Interactive community engagement features*

</details> -->

### **🎬 Video Walkthrough**
<p align="center">
  <a href="">
    <img src="https://img.shields.io/badge/🎬-Video%20Demo-red?style=for-the-badge&logo=youtube&logoColor=white" alt="Video Demo">
  </a>
</p>

*A complete walkthrough of SayurKita's features and functionality*

---

## 🔧 **Available Commands**

```bash
# Development Commands
npm run dev          # Compile assets for development
npm run watch        # Watch for file changes
npm run build        # Build for production

# Laravel Commands
php artisan serve    # Start development server
php artisan migrate  # Run database migrations
php artisan db:seed  # Seed database with sample data
php artisan route:list  # View all available routes
php artisan tinker   # Interactive PHP shell

# Maintenance Commands
php artisan config:cache    # Cache configuration
php artisan route:cache     # Cache routes
php artisan view:cache      # Cache views
```

---

## 🌟 **Future Vision**

While this project serves as our semester-long learning experience, we envision SayurKita could evolve into:

- 🌍 **Multi-language Support** - Indonesian, English, and other languages
- 📱 **Mobile Application** - Native iOS and Android apps
- 🤖 **AI-Powered Recommendations** - Smart vegetable suggestions
- 🚚 **Logistics Integration** - Direct shipping coordination
- 💳 **Payment Gateway** - Secure transaction processing
- 📊 **Analytics Dashboard** - Market insights for farmers

---

## 🤝 **Contributing**

We welcome contributions from the community! This project is open for educational purposes and collaborative learning.

### **How to Contribute**
1. 🍴 Fork the repository
2. 🌟 Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. 💾 Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. 🚀 Push to the branch (`git push origin feature/AmazingFeature`)
5. 🔄 Open a Pull Request

### **Code of Conduct**
- Be respectful and constructive
- Write clear commit messages
- Test your changes thoroughly

---

## 📄 **License**

This project is developed for **educational purposes only** as part of the Politeknik Negeri Batam curriculum. It is not intended for commercial use.

---

## 🙏 **Acknowledgments**

We extend our heartfelt gratitude to:

- 🎓 **Politeknik Negeri Batam** - For providing this learning opportunity
- 👨‍🏫 **Our Lecturers** - For guidance and support throughout the project
- 🌱 **Indonesian Farmers** - For inspiring this solution
- 🏢 **UMKM Communities** - For showing us the real-world impact
- 💻 **Open Source Community** - For the amazing tools and frameworks

---

## 📞 **Contact & Support**

<p align="center">
  <strong>Have questions or suggestions?</strong><br>
  Reach out to our team leader: <strong>Muhammad Syarif Hamid</strong><br>
  <em>We'd love to hear from you!</em>
</p>

<p align="center">
  <a href="mailto:hamid.albase@gmail.com">📧 Email</a> •
  <a href="">🌐 Live Demo</a> •
  <a href="">📁 Assets</a> •
  <a href="https://github.com/Juni-Viaa/cmsvegetable">📱 GitHub</a>
</p>

---

<p align="center">
  <img src="https://img.shields.io/badge/Politeknik%20Negeri%20Batam-2025-blue?style=for-the-badge" alt="Politeknik Negeri Batam">
</p>

<p align="center">
  <em>🌱 "Growing local vegetables, connecting global hearts" 🌱</em>
</p>