# Portfolio and Personal CRM for Freelancers - Fullstack Application (React)

This is the React frontend for the project. It provides the UI/UX for displaying certifications, projects, dashboards, and other user-facing components.

# Tech Stack

- React v18+
- TypeScript v5+
- MUI (Material UI) v6+
- Axios - API requests
- React Router - Navigation
- Vite - Development server and build tool

  

# Dependencies

To install the necessary dependencies, navigate to the frontend directory and run the following command:


    npm install
    # or
    yarn install



The project uses the following key dependencies, as specified in **package.json**:

    "dependencies": {
    	"@mui/material": "^6.x",
    	"@mui/icons-material": "^6.x",
    	"axios": "^1.x",
    	"react": "^18.x",
    	"react-dom": "^18.x",
    	"react-router-dom": "^6.x",
    	"recharts": "^2.x"
    }

  
  
  

# Installation and Setup

1. Navigate to the frontend directory:

    cd frontend

2. Configure environment variables:

Create a .env file in the root of the project with the following content:

    VITE_API_URL=http://localhost:8000/api

3. Run the development server:

    npm run dev

4. Build for production:

    npm run build


# Features

- Modern UI built with MUI
- Tab filtering for gallery
- Responsive design using a grid system
- Lightbox for images
- REST API integration

# Notes

Ensure the backend is running and accessible at the specified **VITE_API_URL** before launching the frontend.

The Lightbox and data visualization charts are designed to be modular and easily extendable.