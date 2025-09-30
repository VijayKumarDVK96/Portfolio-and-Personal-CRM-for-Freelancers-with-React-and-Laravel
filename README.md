
# Portfolio and Personal CRM for Freelancers - Fullstack Application (React + Laravel)

  

This repository is a **fullstack application** built using **React (frontend)** and **Laravel (backend)**.

The goal is to provide a **modern dashboard and API-driven system** that can be extended for business use cases such as portfolio management, certifications, projects, education, experience.

  

## Project Structure

  

Portfolio-and-Personal-CRM-for-Freelancers/
├── backend/                     # Laravel API backend
│   ├── app/
│   │   ├── Http/Controllers/Api/
│   │   └── helpers.php
│   ├── config/
│   ├── database/
│   ├── routes/
│   │   ├── api.php
│   │   └── web.php
│   └── .env.example
├── frontend/                    # React frontend
│   ├── src/
│   │   ├── components/         # Reusable UI components
│   │   ├── contexts/          # React contexts
│   │   ├── hooks/             # Custom hooks
│   │   ├── pages/             # Page components
│   │   ├── styles/            # Global styles
│   │   ├── types/             # TypeScript types
│   │   ├── utils/             # Helper utilities
│   │   ├── App.tsx            # Main app component
│   │   ├── main.tsx           # Entry point
│   │   └── theme.ts           # MUI theme
│   ├── public/
│   ├── index.html
│   ├── package.json
│   └── vite.config.ts
└── README.md


## Technologies Used

 

**Frontend**
- [React](https://react.dev/) – v18+
- [TypeScript](https://www.typescriptlang.org/) – v5+
- [MUI (Material UI)](https://mui.com/) – v6+
- [Vite / CRA] – development build tool
- [Axios] – API communication

**Backend**
- [Laravel](https://laravel.com/) – v11+
- [PHP](https://www.php.net/) – v8.2+
- [MySQL](https://www.mysql.com/) / PostgreSQL
- Composer – Dependency manager
- Sanctum – Authentication (if applicable)
- Redis - Caching DB

  

---

  

## 🛠 Problem Being Solved

  

This project provides a **modular dashboard system** that enables:
- Storing and managing **certifications**, **projects**, and related data.
- Filtering, searching, and visualizing data dynamically.
- A **REST API** for scalability and external integrations.
- A **customizable UI** for personal or organizational portfolio/dashboards.
  

## Installation & Setup

  

### Clone Repository

```bash

git  clone  https://github.com/your-username/your-repo.git
cd  your-repo

  
Install  Frontend
See  frontend/README.md

  
Install  Backend
See  backend/README.md

To start the project that is frontend and backend, just double click the **start-projects.bat** (Only for Windows OS). 