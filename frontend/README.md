# Portfolio and Personal CRM for Freelancers - Fullstack Application (React)

This is the React frontend for the project. It provides the UI/UX for displaying certifications, projects, dashboards, and other user-facing components.

# Tech Stack

- React v19+
- TypeScript v5+
- MUI (Material UI) v7+
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
        "@emotion/react": "^11.14.0",
        "@emotion/styled": "^11.14.1",
        "@mui/icons-material": "^7.3.1",
        "@mui/lab": "^7.0.0-beta.16",
        "@mui/material": "^7.3.1",
        "axios": "^1.12.2",
        "framer-motion": "^12.23.12",
        "react": "^19.1.1",
        "react-countup": "^6.5.3",
        "react-dom": "^19.1.1",
        "react-icons": "^5.5.0",
        "react-intersection-observer": "^9.16.0",
        "react-router-dom": "^7.8.2",
        "react-scroll": "^1.9.3",
        "react-slick": "^0.31.0",
        "slick-carousel": "^1.8.1",
        "yet-another-react-lightbox": "^3.25.0"
    }

  
  
  

# Installation and Setup

1. Navigate to the frontend directory:

    cd frontend

2. Configure environment variables:

Create a .env file in the root of the project with the following content:

    VITE_BACKEND_URL=http://localhost:8000/api

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

Ensure the backend is running and accessible at the specified **VITE_BACKEND_URL** before launching the frontend.

The Lightbox and data visualization charts are designed to be modular and easily extendable.